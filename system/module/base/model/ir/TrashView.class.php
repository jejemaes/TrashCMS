<?php
/**
 * Maes Jerome
 * TrashView.class.php, created at Oct 27, 2014
 * A view is an object building a UI, mostly based on XML. There is various type :
 * 			- Form : describing the form view of a record. Ex : <form name="myform"><group></group></form>
 * 			- Tree : describing the list view of a model (records)
 *  		- Template : template rendering anything (a web page, ....). Here, we use QWeb template.
 * A view can be of 2 modes :
 * 		- if extension (default), if this view is requested the closest primary view is looked up (via inherit_id), then all 
 * 		  views inheriting from it with this view's model are applied.
 * 		- if primary, the closest primary view is fully resolved (even if it uses a different model than this one), then 
 * 		  this view's inheritance specs (<xpath/>) are applied, and the result is used as if it were this view's actual arch.
 * The extention mode extends the view, and the primary mode inherit other views.
 * 
 */

/**
 * DOC :
 * http://www.sitepoint.com/php-dom-using-xpath/ 
 * http://php.net/manual/fr/domdocument.importnode.php
 *
 * @author jeromemaes
 * Oct 27, 2014
 */

namespace system\module\base\model\ir;

use system\core\TrashModel as TrashModel;
use system\helpers\TemplateEngineHelper as TemplateEngineHelper;
use system\helpers\TemplateLoaderHelper as TemplateLoaderHelper;

use \DOMDocument as DOMDocument;
use \DOMXPath as DOMXPath;


class TrashView extends TrashModel{
	
	static $table_name = 'ir.view';
	
	static $attr_accessible = array(
			'id',
			'xml_id', 		// string, unique name of the view (xml id template tag) : 'module.viewName'
			'name', 		// string displayed to Users
			'web_arch', 	// text, the content of the template (website version)
			'parent_id',	// integer, id of the inherited view
			'sequence',		// integer, sequence order to render inherited views
			// TODO
			// 'mode', // primary, extension
			'type', 		// should be : form, tree, template or bundle
			'active'		// boolean
	);
	
	static $belongs_to = array(
			array('system_module', 'class_name' => 'system\core\Module'),// TODO : remove
			
			array('module_id', 'foreign_key' => 'module_id', 'class_name' => 'system\core\Module'),
			//array('parent_id', 'foreign_key' => 'parent_id', 'class_name' => 'system\module\base\model\ir\TrashView')
	);
	
	
	public static function create($attributes, $validate=true){
		// TODO : set type according to parent_id = false ?
		parent::create($attributes, $validate);
	}
	
	
	
	public static function render($xmlid, $values, $context = array()){
		$loader = new TemplateLoaderHelper();
		$engine = new TemplateEngineHelper($loader);
		echo '<hr>';
		var_dump($values);
		return $engine->render($xmlid, $values);
	}
	
	
	
	/**
	 * get the view correspondng to the given xml_id
	 * @param string $xmlid : xml_id of the view. Must looks like "module"."view_name".
	 * @return Ambigous <>|string
	 */
	public static function get_view($xmlid){
		$views = parent::all(array(
				'conditions' => array('xml_id = ?', $xmlid)
		));
		if (count($views) > 0){
			return $views[0];
		}
		throw new ObjectNotFoundException('TrashView', $xmlid);
	}
	
	/**
	 * get the inherited views of the given view_id
	 * @param integer $view_id : identifier of the view (master view)
	 * @return Ambigous <\ActiveRecord\mixed, NULL, unknown, \ActiveRecord\Model, multitype:>
	 */
	public static function get_inherited_view($view_id){
		return static::find('all', array('conditions' => array('parent_id = ? AND active = ?', $view_id, '1'), 'order' => 'sequence desc'));
	}
	
	
	/**
	 * get the arch field of the given view xmlid, after the inheritances were applied.
	 * It return a string (code) of thebase view extended by its children
	 * @param string $xmlid : the base xmlid 
	 * @return string : the inherited view arch
	 */
	public static function apply_inheritance_arch($xmlid){
		$base_view = static::get_view($xmlid);
		$inherited_views = static::get_inherited_view($base_view->id);
		
		$base_arch_dom = new DOMDocument();
		$base_arch_dom->loadXML($base_view->web_arch, LIBXML_NOWARNING);
		
		foreach ($inherited_views as $view){
			$view_arch_dom = new DOMDocument;
			$view_arch_dom->loadXML($view->web_arch, LIBXML_NOWARNING);
			
			$elements = $view_arch_dom->getElementsByTagName("xpath");
			foreach ($elements as $xpath_element) {
				$query = $xpath_element->getAttribute('expr');
				$position = $xpath_element->getAttribute('position') ? $xpath_element->getAttribute('position') : 'inside';
			
				if($query){
					$xpath = new DOMXPath($base_arch_dom);
					$result = $xpath->query($query);
					
					if($result){
						// import nodes (child of xpath tags) from inherited view to base DOM
						$result = $result->item(0); //TODO only take the first ?
						$nodes = array();
						foreach($xpath_element->childNodes as $child){
							$nodes[] = $base_arch_dom->importNode($child, true);
						}
						// place correctly the new nodes into the base architecture DOM
						if($position == 'inside'){
							foreach ($nodes as $n) {
								$result->appendChild($n);
							}
						}
						if($position == 'replace'){
							foreach ($nodes as $n) {
								$result->parentNode->insertBefore($n, $result);
							}
							$result->parentNode->removeChild($result);
						}
						if($position == 'before'){
							foreach ($nodes as $n) {
								$result->parentNode->insertBefore($n, $result);
							}
						}
						if($position == 'after'){
							// TODO
						}
					}else{
		    			// no elem found, wrong xpath expr
		    		}
				}else{
					// TODO : not tag expr
				}
			}
		}
		//echo htmlspecialchars($base_arch_dom->saveXML());
		//var_dump($base_arch_dom);
		return $base_arch_dom->saveXML();		
	}
	
	
	// PARSING
	public static function parseAttributes($node){
		$tag_allow_attributes = array('id', 'name', 'inherit_id', 'active', 'sequence');
		$result = array();
		foreach ($tag_allow_attributes as $attr){
			if($node->hasAttribute($attr)){
				$result[$attr] = $node->getAttribute($attr);
			}
		}
		return $result;
	}
	
	public static function parseFiles(array $files){
		global $Logger;
		$view_attributes = array();
		foreach ($files as $filename){
			// load file
			$dom = new DOMDocument();
			$dom->load($filename, LIBXML_NOWARNING);
			// extract data
			$data_tags = $dom->getElementsByTagName("data");
			foreach ($data_tags as $data) {
				for ($i = 0 ; $i < $data->childNodes->length; $i++ ) {
					$current_view = $data->childNodes->item($i);
					// checkt node class (avoid DOMText)
					if(in_array(get_class($current_view), array('DOMNode', 'DOMElement'))){
						// check node type
						$node_type = $current_view->nodeName;
						if(in_array($node_type, array('bundle', 'form', 'tree', 'template'))){
							$current_attributes = static::parseAttributes($current_view);
							$current_attributes['web_arch'] = $current_view->C14N(true, true);
							$current_attributes['type'] = $node_type;
							// transfert id to xml_id
							$current_attributes['xml_id'] = $current_attributes['id'];
							unset($current_attributes['id']);
							// set the parent from the given xml_id of 'inherit_id' attribute
							if(isset($current_attributes['inherit_id'])){
								$res = static::find('all', array('conditions' => array('xml_id LIKE ?', $current_attributes['inherit_id'])));
								if(count($res) >= 1){
									$current_attributes['parent_id'] = $res[0]->id;
								}else{
									$Logger->error("Inherit an unknown view " . $current_attributes['inherit_id']);
								}
								unset($current_attributes['inherit_id']);
							}
							$view_attributes[] = $current_attributes;
						}
					}
				}
			}
			$Logger->info("Loading " . $filename);
		}
		$view_objects = array();
		$class = __CLASS__;
		foreach ($view_attributes as $view){
			$v = new $class($view);
			$view_objects[] = $v;
		}
		return $view_objects;
	}

	
}
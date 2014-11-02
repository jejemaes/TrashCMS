<?php
/**
 * Maes Jerome
 * TrashView.class.php, created at Oct 27, 2014
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


namespace system\ir;
use system\ir\TrashModel as TrashModel;

use \DOMDocument as DOMDocument;
use \DOMXPath as DOMXPath;


class TrashView extends TrashModel{
	
	static $table_name = 'system_view';
	
	static $attr_accessible = array(
			'id',
			'xml_id', 		// string, unique name of the view (xml id template tag) : 'module.viewName'
			'name', 		// string displayed to Users
			'web_arch', 	// text, the content of the template (website version)
			'mobile_arch',	// idem but for mobile
			'inherit_xml_id',	// TODO : remove!! // xml_id of the inherited view
			'parent_id',	// integer, id of the inherited view
			'sequence',		// integer, sequence order to render inherited views
			'depends',		// ???? TODO json : list of the xml_id requiered for this view ['module.view1', 'module.view2']
	);
	
	static $belongs_to = array(
			array('system_module', 'class_name' => 'system\ir\Module'),// TODO : remove
			
			array('module_id', 'foreign_key' => 'module_id', 'class_name' => 'system\ir\Module'),
			array('parent_id', 'foreign_key' => 'parent_id', 'class_name' => 'system\ir\TrashView')
	);
	
	
	
	/**
	 * get the view correspondng to the given xml_id
	 * @param string $xmlid : xml_id of the view. Must looks like "module"."view_name".
	 * @return Ambigous <>|string
	 */
	public static function get_view($xmlid){
		$views = static::all(array(
				'joins' => 'LEFT JOIN system_module M ON(system_view.module_id = M.id)',
				'conditions' => array('system_view.xml_id = ?', $xmlid)
		));
		
		if (count($views) > 0){
			return $views[0];
		}
		// TODO throw exception
		return "cacaView"; 
	}
	
	/**
	 * get the inherited views of the given view_id
	 * @param integer $view_id : identifier of the view (master view)
	 * @return Ambigous <\ActiveRecord\mixed, NULL, unknown, \ActiveRecord\Model, multitype:>
	 */
	public static function get_inherited_view($view_id){
		return static::find('all', array('conditions' => array('parent_id = ?', $view_id), 'order' => 'sequence desc'));
	}
	
	
	
	public static function apply_view_inheritance($xmlid){
		$base_view = static::get_view($xmlid);
		$inherited_views = static::get_inherited_view($base_view->id);
		
		$base_arch_dom = new DOMDocument;
		$base_arch_dom->loadHTML($base_view->web_arch);
		
		
		foreach ($inherited_views as $view){
			
			// TODO remove
			libxml_use_internal_errors(false);
			
			$view_arch_dom = new DOMDocument;
			$view_arch_dom->loadXML($view->web_arch);
			
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
			return $base_arch_dom->saveHTML();
		}
		
	}
	
	
	
}
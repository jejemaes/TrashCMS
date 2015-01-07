<?php
/**
 * Maes Jerome
 * test.php, created at Dec 27, 2014
 *
 */
include 'ir_qweb.php';

class loaderTest implements iQwebLoader{
	
	private $_templates;
	
	public function __construct($templates){
		$this->_templates = $templates;
	}
	
	function load($name){
		return $this->_templates[$name];
	}
	
}

$t1 = '<?xml version="1.0"?>
<t t-name="test1">
        <body>
            <div style="color:red;">
            	 <t t-raw="0"/>
            </div>
        </body>
</t>';


$t2 = '<?xml version="1.0"?>
<t t-name="test2">
	<t t-call="test1">
        <div id="wrap">
            <div class="container">
                <h1 class="mt32">403: Forbidden</h1>
                <p t-att-datahhh="caca_class">The page you were looking for could not be authorized.</p>
                <p t-attf-class="#{$myclass}">Maybe you were looking for one of these popular pages ?</p>
                <ul>
                <t t-foreach="$mylist" t-as="$elem">
                	<li><b><t t-esc="$elem"/></b> : <t t-esc="$elem_value"/></li>
                </t>
                </ul>

			<h3 t-if="$caca">IYUYIYIUY</h3>
		
            </div>
        </div>
    </t>
</t>';


$t = array(
		"test1" => $t1,
		"test2" => $t2,
);


$loader = new loaderTest($t);
$engine = new QWebEngine($loader);


$arrayM = array('un','deuxx', 'trois', '444');
$array = array('un' => 'ONE' ,'deux' => 'TWO', 'trois' => 'THREE', 'qut' => "FORU'");


echo htmlspecialchars($engine->render('test2', array('caca' => (2 ==2), 'mylist' => $array, 'myclass' => 'caca_class')));


<?php

include('JSMin.php');
include('CSSmin.php');


header('content-type: application/javascript'); 

$js = file_get_contents('script.js');
$css = file_get_contents('style.css');

$minifiedJs = JSMin::minify($js);
echo $minifiedJs;


echo "\n=====================================\n";
$c = new CSSmin();
echo $c->run($css);


?>
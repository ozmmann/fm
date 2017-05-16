<?php
require_once 'config.php';
$filePath = $_SERVER['DOCUMENT_ROOT'] . '/' . $config['logfile'];
if(!is_dir(dirname($filePath))){
    mkdir(dirname($filePath), 0777, true);
}

var_dump(pathinfo('D:/domains/test.txt'));
$dir = opendir('.');
//while ($entry = readdir($dir)) {
//    var_dump($entry);
//}

//$scan = scandir('.');

if(!file_exists($filePath) || filesize($filePath) == 0){
    $legend = "from -> where | when \n";
} else {
    $legend = '';
}

$f = fopen($filePath, 'a+');
$date = date('j.m.Y H:i:s');
$log = $legend . $_SERVER['HTTP_REFERER'] . ' -> ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ' | '.$date . "\n";
fwrite($f, $log);
fclose($f);

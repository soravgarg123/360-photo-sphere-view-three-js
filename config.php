<?php

$root = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
$root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

define('BASE_URL',$root);

define('BASE_PATH',$_SERVER['DOCUMENT_ROOT'].'/360-photo-sphere-view-three-js/');

?>
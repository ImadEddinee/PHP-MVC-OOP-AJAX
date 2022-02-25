<?php

define('DB_NAME',"mini_facebook");
define('HOST',"localhost");
define('USER',"root");
define('PASS',"");
define('SITENAME',"Mini Facebook");

$path = str_replace("\\","/","http://".$_SERVER['SERVER_NAME'].__DIR__."/");
$path = str_replace($_SERVER['DOCUMENT_ROOT'],"",$path);
$path = str_replace("/app/config","",$path);
define('APPROOT',dirname(dirname(__FILE__))).
define('ROOT',str_replace("app/core","public",$path));
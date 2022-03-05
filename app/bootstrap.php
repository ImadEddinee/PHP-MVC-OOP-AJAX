<?php
//Load config
require_once 'config/config.php';
require_once 'helpers/session_helpers.php';
require_once 'helpers/url_helpers.php';
require_once 'helpers/debug_helpers.php';
require_once 'libraries/Controller.php';
require_once 'libraries/Core.php';
require_once 'libraries/Database.php';
require_once 'libraries/Exception.php';
require_once 'libraries/PHPMailer.php';
require_once 'libraries/SMTP.php';
//// Autoload libraries
//spl_autoload_register(function($className){
//    require_once 'libraries/'.$className.'.php';
//});
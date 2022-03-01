<?php
//Load config
require_once 'config/config.php';
require_once 'helpers/session_helpers.php';
require_once 'helpers/url_helpers.php';
require_once 'helpers/debug_helpers.php';
// Autoload libraries
spl_autoload_register(function($className){
    require_once 'libraries/'.$className.'.php';
});
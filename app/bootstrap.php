<?php

// Load config
require_once 'config/config.php';

// Load helpers
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';

// Autoload Core Libraries
spl_autoload_register(function($className) {
    if (file_exists(APP_ROOT . '/libraries/' . $className . '.php')) {
        require_once 'libraries/' . $className . '.php';
    } else if (file_exists(APP_ROOT . '/controllers/' . $className . '.php')) {
        require_once 'controllers/' . $className . '.php';
    } else {
        die("Controller not found");
    }
});
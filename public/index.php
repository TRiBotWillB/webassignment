<?php

// Requires all files in /app/classes and /app/controllers, cleaner than writing out individual require(s)
spl_autoload_register(function ($class_name) {

    if (file_exists('../app/classes/' . $class_name . '.php')) {
        require_once '../app/classes/' . $class_name . '.php';
    } else if (file_exists('../app/controllers/' . $class_name . '.php')) {
        require_once '../app/controllers/' . $class_name . '.php';
    }
});
require_once('../app/init.php');

<?php
spl_autoload_register("myAutoLoader");

function myAutoLoader($className) {
    $rootPath = __DIR__ . '/../classes/';
    $directories = ['model/', 'control/'];

    foreach ($directories as $directory) {
        $fullPath = $rootPath . $directory . $className . '.class.php';
        if (file_exists($fullPath)) {
            require_once $fullPath;
            return;
        }
    }

    $mainPath = $rootPath . $className . '.class.php';
    if (file_exists($mainPath)) {
        require_once $mainPath;
    } else {
        error_log("Class file for {$className} not found.", 0); // Log errors silently
        return false; // Return false to prevent any further processing
    }
}

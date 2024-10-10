<?php

spl_autoload_register("myAutoLoader");

function myAutoLoader($className) {
    // Use __DIR__ to make the path relative to the current directory where the script is called
    $rootPath = __DIR__ . '/../classes/';

    // Define possible directories for models and controllers
    $directories = ['model/', 'control/'];

    // Check if the file is in the model or control subdirectories
    foreach ($directories as $directory) {
        $fullPath = $rootPath . $directory . $className . '.class.php';
        
        if (file_exists($fullPath)) {
            require_once $fullPath;
            return;
        }
    }

    // If no file found in subdirectories, check the main classes directory
    $mainPath = $rootPath . $className . '.class.php';
    
    if (file_exists($mainPath)) {
        require_once $mainPath;
    } else {
        // Optional: Log or handle the error of class file not being found
        error_log("Class file for {$className} not found.");
        return false;
    }
}

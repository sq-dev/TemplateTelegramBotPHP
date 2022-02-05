<?php

namespace Core\Helpers;

use function DI\env;

function config($name)
{
    $configFile = $_ENV['ROOT_DIR'].'/core/Config/'.$name.'.php';
    
    if (file_exists($configFile)) {
        $config = require $configFile;
        
        return (object) $config;
    }else {
        return (object) [];
    }
}
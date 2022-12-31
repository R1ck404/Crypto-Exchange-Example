<?php

spl_autoload_register('customAutoLoader');

function customAutoLoader($className) {
    if (!file_exists(($className . '.php')))
        return false;
        
    include_once $className. '.php';
}

?>
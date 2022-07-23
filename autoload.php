<?php 

function myAutoload($className) 
{
    $pathToClass = 'classes/' . $className . '.php';

    if(file_exists($pathToClass))
        require_once $pathToClass;
    else 
        throw new \Exception('File not found - ' . $className);
}

spl_autoload_register('myAutoload');
<?php

class Autoloader
{
    public static function register() : void
    {
        spl_autoload_register(function ($class) : bool {
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
            $file = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . ltrim($file, DIRECTORY_SEPARATOR);
            
            if (file_exists($file)) {
                require $file;
                return true;
            }
            
            return false;
        });
    }
}
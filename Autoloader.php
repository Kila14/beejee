<?php

class Autoloader
{
    public static function register() : void
    {
        spl_autoload_register(function ($class) : bool {
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
            $file = ROOT_PATH . DIRECTORY_SEPARATOR . ltrim($file, DIRECTORY_SEPARATOR);
            
            if (file_exists($file)) {
                require $file;
                return true;
            }
            
            return false;
        });
    }
}
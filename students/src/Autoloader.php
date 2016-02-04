<?php
class Autoloader
{
    private static $_lastLoadedFilename;
    public static function loadPackages($className)
    {
        $pathParts = explode('_', $className);
        self::$_lastLoadedFilename = implode(DIRECTORY_SEPARATOR, $pathParts) . '.php';
        require_once(self::$_lastLoadedFilename);
    }
}


<?php
class Autoloader
{
    private static $lastLoadedFilename;
    public static function loadPackages($className)
    {
        $pathParts = explode('_', $className);
        self::$lastLoadedFilename = implode(DIRECTORY_SEPARATOR, $pathParts) . '.php';
        require_once(self::$lastLoadedFilename);
    }
}


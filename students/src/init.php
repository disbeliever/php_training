<?php
//require_once(__DIR__ . '/Autoloader.php');
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/config.php');

//spl_autoload_register(array('Autoloader', 'loadPackages'));

use \App\Models\StudentTableGateway;

$PDO = new PDO("$config[dbtype]:host=$config[dbhost];dbname=$config[dbname]", $config['dbuser'], $config['dbpass']);
$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stg = new StudentTableGateway($PDO);

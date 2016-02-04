<?php
require_once('Autoloader.php');
require_once('config.php');

spl_autoload_register(array('Autoloader', 'loadPackages'));
$PDO = new PDO("$config[dbtype]:host=$config[dbhost];dbname=$config[dbname]", $config['dbuser'], $config['dbpass']);
$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stg = new StudentTableGateway($PDO, $config['studentsPerPage']);

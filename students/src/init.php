<?php
require_once('autoloader.php');
require_once('config.php');

$PDO = new PDO("$config[dbtype]:host=$config[dbhost];dbname=$config[dbname]", $config['dbuser'], $config['dbpass']);
$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stg = new StudentTableGateway($PDO, $config['studentsPerPage']);

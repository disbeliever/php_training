<?php
require_once('autoloader.php');
require_once('config.php');

$PDO = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$STG = new StudentTableGateway($PDO, $studentsPerPage);

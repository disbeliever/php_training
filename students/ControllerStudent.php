<?php
error_reporting(-1);
require_once('autoloader.php');
require_once('config.php');

$PDO = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$STG = new StudentTableGateway($PDO);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $student = $STG->getStudentById($id);
    include('views/ViewStudent.php');
}

<?php
error_reporting(-1);
require_once('autoloader.php');
require_once('config.php');

$PDO = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$STG = new StudentTableGateway($PDO);

$searchString = isset($_GET['search_string']) ? $_GET['search_string'] : "";

if ($searchString == "") {
    $students = $STG->getAllStudents();
}
else {
    $students = $STG->searchInDB($searchString);
}

include('views/ViewStudentsList.php');

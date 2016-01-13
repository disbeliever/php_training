<?php
error_reporting(-1);
require_once('autoloader.php');
require_once('init.php');

$searchString = isset($_GET['searchString']) ? $_GET['searchString'] : "";

if ($searchString == "") {
    $students = $STG->getAllStudents();
}
else {
    $students = $STG->searchInDB($searchString);
}

include('views/ViewStudentsList.php');

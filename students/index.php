<?php
require_once('init.php');

$searchString = isset($_GET['searchString']) ? $_GET['searchString'] : "";

if ($searchString == "") {
    $students = $STG->getAllStudents();
}
else {
    $students = $STG->searchInDB($searchString);
}

include('views/ViewStudentsList.php');

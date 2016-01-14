<?php
error_reporting(-1);
require_once('autoloader.php');
require_once('init.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $student = $STG->getStudentById($id);
}
else {
    $student = new Student();
}
if ($student != null) {
    include('views/ViewStudent.php');
}
else {
    header("HTTP/1.0 404 Student not found");
    $errString = "Абитуриент с id=$id не найден";
    include('views/404.php');
}

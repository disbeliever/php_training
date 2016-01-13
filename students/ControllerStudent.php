<?php
error_reporting(-1);
require_once('autoloader.php');
require_once('init.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $student = $STG->getStudentById($id);
    include('views/ViewStudent.php');
}

<?php
require_once('../src/init.php');

$searchString = isset($_GET['searchString']) ? $_GET['searchString'] : "";
$sortField = isset($_GET['sort']) ? $_GET['sort'] : "mark";
$sortDir = isset($_GET['dir']) ? $_GET['dir'] : "desc";
$page = isset($_GET['page']) ? $_GET['page'] : 1;

if ($searchString == "") {
    $students = $stg->getAllStudents($sortField, $sortDir, $page);
}
else {
    $students = $stg->searchInDB($searchString, $sortField, $sortDir);
}

$studentsPerPage = $config['studentsPerPage'];
$pager = new Pager(
    $stg->getTotalStudentsNum() / $studentsPerPage + 1,
    $studentsPerPage,
    UrlHelper::getPagerURL($searchString, $sortField, $sortDir, "_page_")
);

include('../src/views/ViewStudentsList.php');

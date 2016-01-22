<?php
require_once('init.php');

function getQueryArray($search, $sort, $dir, $page)
{
    return [
        'searchString' => $search,
        'sort' => $sort,
        'dir' => $dir,
        'page' => $page
    ];
}

function getSortingURL($search, $sort, $dir, $page)
{
    global $sortField;
    $dir = $sortField == $sort && $dir == "asc" ? "desc" : "asc";
    return "{$_SERVER['SCRIPT_NAME']}?" .
           http_build_query(getQueryArray($search, $sort, $dir, $page));
}

function getSortDirGlyph($sort, $dir)
{
    global $sortField;
    if ($sort == $sortField) {
        return $dir == 'desc' ? '&#8593;' : '&#8595;';
    }
}

function getPagerURL($search, $sort, $dir, $page)
{
    return "{$_SERVER['SCRIPT_NAME']}?" .
           http_build_query(getQueryArray($search, $sort, $dir, $page));
}

$searchString = isset($_GET['searchString']) ? $_GET['searchString'] : "";
$sortField = isset($_GET['sort']) ? $_GET['sort'] : "mark";
$sortDir = isset($_GET['dir']) ? $_GET['dir'] : "desc";
$page = isset($_GET['page']) ? $_GET['page'] : 1;

if ($searchString == "") {
    $students = $STG->getAllStudents($sortField, $sortDir, $page);
}
else {
    $students = $STG->searchInDB($searchString, $sortField, $sortDir);
}

#$pager = new Pager($STG->getTotalStudentsNum() / $studentsPerPage + 1, $studentsPerPage, "{$_SERVER['SCRIPT_NAME']}?page={page}");
$pager = new Pager($STG->getTotalStudentsNum() / $studentsPerPage + 1, $studentsPerPage, getPagerURL($searchString, $sortField, $sortDir, "_page_"));

include('views/ViewStudentsList.php');

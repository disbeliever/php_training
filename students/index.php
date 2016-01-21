<?php
require_once('init.php');

function getSortingURL($search, $sort, $dir, $page)
{
    global $sortField;
    return "{$_SERVER['SCRIPT_NAME']}?" .
           http_build_query([
               'searchString' => $search,
               'sort' => $sort,
               'dir' => $sortField == $sort && $dir == "asc" ? "desc" : "asc",
               'page' => $page
           ]);
}

function getSortDirGlyph($sort, $dir)
{
    global $sortField;
    if ($sort == $sortField) {
        return $dir == 'desc' ? '&#8593;' : '&#8595;';
    }
}

$searchString = isset($_GET['searchString']) ? $_GET['searchString'] : "";
$sortField = isset($_GET['sort']) ? $_GET['sort'] : "id";
$sortDir = isset($_GET['dir']) ? $_GET['dir'] : "";
$page = isset($_GET['page']) ? $_GET['page'] : 1;

if ($searchString == "") {
    $students = $STG->getAllStudents($sortField, $sortDir);
}
else {
    $students = $STG->searchInDB($searchString, $sortField, $sortDir);
}

include('views/ViewStudentsList.php');

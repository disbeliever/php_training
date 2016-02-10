<?php
class ControllerStudentsList
{
    private $stg;
    public function __construct($stg)
    {
        $this->stg = $stg;
    }

    public function run($studentsPerPage)
    {
        $searchString = isset($_GET['searchString']) ? $_GET['searchString'] : "";
        $sortField = isset($_GET['sort']) ? $_GET['sort'] : "mark";
        $sortDir = isset($_GET['dir']) ? $_GET['dir'] : "desc";
        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        if ($searchString == "") {
            $students = $this->stg->getAllStudents(
                $sortField,
                $sortDir,
                $studentsPerPage,
                $studentsPerPage * ($page-1)
            );
        }
        else {
            $students = $this->stg->searchInDB($searchString, $sortField, $sortDir);
        }

        $pager = new Pager(
            $this->stg->getTotalStudentsNum() / $studentsPerPage + 1,
            $studentsPerPage,
            UrlHelper::getPagerURL($searchString, $sortField, $sortDir, "{page}")
        );

        include('../src/views/ViewStudentsList.php');

    }
}

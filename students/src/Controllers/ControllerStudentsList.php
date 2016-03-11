<?php
namespace App\Controllers;

use \App\Models\StudentTableGateway;
use \App\Helpers\Pager;
use \App\Helpers\UrlHelper;

class ControllerStudentsList
{
    private $stg;
    private $studentsPerPage;
    public function __construct(StudentTableGateway $stg, $studentsPerPage)
    {
        $this->stg = $stg;
        $this->studentsPerPage = $studentsPerPage;
    }

    public function run()
    {
        $searchString = isset($_GET['searchString']) ? $_GET['searchString'] : "";
        $sortField = isset($_GET['sort']) ? $_GET['sort'] : "mark";
        $sortDir = isset($_GET['dir']) ? $_GET['dir'] : "desc";
        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        if ($searchString == "") {
            $students = $this->stg->getAllStudents(
                $sortField,
                $sortDir,
                $this->studentsPerPage,
                $this->studentsPerPage * ($page-1)
            );
        }
        else {
            $students = $this->stg->searchInDB($searchString, $sortField, $sortDir);
        }

        $urlHelper = new UrlHelper();
        $pager = new Pager(
            intval(ceil($this->stg->getTotalStudentsNum() / $this->studentsPerPage)),
            $this->studentsPerPage,
            $urlHelper->getPagerURL($searchString, $sortField, $sortDir, "{page}")
        );

        include(__DIR__ . '/../views/ViewStudentsList.php');

    }
}

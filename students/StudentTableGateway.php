<?php

class StudentTableGateway
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function addStudent(Student $student)
    {
        $query = $this->pdo->query("INSERT INTO students(first_name, last_name, group, mark) VALUES(@first_name, @last_name, @group, @mark)");

        $query->bindValue("@first_name", $student->firstName);
        $query->bindValue("@last_name", $student->lastName);
        $query->bindValue("@group", $student->group);
        $query->bindValue("@mark", $student->mark);
        
        $query->execute();
    }

    public function getStudentById($id)
    {
        $query = $this->pdo->query("SELECT * FROM students WHERE id=@id");
        $query->bindValue("@id", $id);
        $row = $query->fetch();

        if ($row) {
            return new Student($row);
        }
    }

    public function getAllStudents()
    {
        $query = $this->pdo->query("SELECT * FROM students");
        $arr = array();
        while ($row = $query->fetch()) {
            $arr[] = new Student($row);
        }

        return $arr;
    }

    public function searchInDB($searchString)
    {
        $query = $this->pdo->query("SELECT * FROM students WHERE CONCAT(first_name, last_name, student_group, mark) LIKE @search_string");
        $query->bindValue("@search_string", "%" . $searchString . "%");
        $arr = array();
        while ($row = $query->fetch()) {
            $arr[] = new Student($row);
        }

        return $arr;
    }
}

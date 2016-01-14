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
        $query = $this->pdo->prepare("INSERT INTO students(first_name, last_name, group, mark) VALUES(:first_name, :last_name, :group, :mark)");

        $query->bindValue(":first_name", $student->firstName);
        $query->bindValue(":last_name", $student->lastName);
        $query->bindValue(":group", $student->group);
        $query->bindValue(":mark", $student->mark);
        
        $query->execute();
    }

    public function getStudentById($id)
    {
        $query = $this->pdo->prepare("SELECT * FROM students WHERE id=:id");
        $query->bindValue(":id", $id);
        $query->execute();
        $row = $query->fetch();

        if ($row) {
            return Student::fromRow($row);
        }
    }

    public function getAllStudents()
    {
        $query = $this->pdo->query("SELECT * FROM students");
        $arr = array();
        while ($row = $query->fetch()) {
            $arr[] = Student::fromRow($row);
        }

        return $arr;
    }

    public function searchInDB($searchString)
    {
        $query = $this->pdo->prepare("SELECT * FROM students WHERE CONCAT(first_name, ' ', last_name, ' ', student_group, ' ', mark) LIKE '%' || :search_string || '%'");
        $query->bindValue(":search_string", $searchString, PDO::PARAM_STR);
        $query->execute();
        $arr = array();
        while ($row = $query->fetch()) {
            $arr[] = Student::fromRow($row);
        }

        return $arr;
    }
}

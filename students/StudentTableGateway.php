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
        $query = $this->pdo->prepare("INSERT INTO students(first_name, last_name, student_group, mark, email, gender, birthyear) VALUES(:first_name, :last_name, :student_group, :mark, :email, :gender, :birthyear) RETURNING id");

        $query->bindValue(":first_name", $student->firstName);
        $query->bindValue(":last_name", $student->lastName);
        $query->bindValue(":student_group", $student->group);
        $query->bindValue(":mark", $student->mark);
        $query->bindValue(":email", $student->email);
        $query->bindValue(":gender", $student->gender);
        $query->bindValue(":birthyear", $student->birthyear);
        
        $query->execute();
        $student->id = $query->fetchColumn();
    }

    public function updateStudent(Student $student)
    {
        $query_string = "UPDATE students SET first_name=:first_name,last_name=:last_name,student_group=:student_group,mark=:mark,email=:email,gender=:gender,birthyear=:birthyear WHERE id=:id";

        $query = $this->pdo->prepare($query_string);

        $query->bindValue(":id", $student->id);
        $query->bindValue(":first_name", $student->firstName);
        $query->bindValue(":last_name", $student->lastName);
        $query->bindValue(":student_group", $student->group);
        $query->bindValue(":mark", $student->mark);
        $query->bindValue(":email", $student->email);
        $query->bindValue(":gender", $student->gender);
        $query->bindValue(":birthyear", $student->birthyear);

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

    private function getValidSortField($field)
    {
        $orders = array("id", "first_name", "last_name", "student_group", "mark");
        $key = array_search($field, $orders);
        $order = $orders[$key];
        return $order;
    }

    public function getAllStudents($sortField, $sortDir)
    {
        $sortField = $this->getValidSortField($sortField);
        $sortDir = $sortDir == 'desc' ? "DESC" : "";
        $query = $this->pdo->prepare("SELECT * FROM students ORDER BY $sortField $sortDir");
        $query->execute();

        $students = array();
        while ($row = $query->fetch()) {
            $students[] = Student::fromRow($row);
        }

        return $students;
    }

    public function isEmailInDB($email)
    {
        $query = $this->pdo->prepare("SELECT COUNT(email) FROM students WHERE email=:email");
        $query->bindValue(":email", $email);
        $query->execute();
        $count = $query->fetchColumn();
        return $count > 0;
    }

    public function searchInDB($searchString, $sortField, $sortDir)
    {
        $sortField = $this->getValidSortField($sortField);
        $sortDir = $sortDir == 'desc' ? "DESC" : "";
        $query = $this->pdo->prepare("SELECT * FROM students WHERE CONCAT(first_name, ' ', last_name, ' ', student_group, ' ', mark) LIKE '%' || :search_string || '%' ORDER BY $sortField $sortDir");
        $query->bindValue(":search_string", $searchString, PDO::PARAM_STR);
        $query->execute();
        $arr = array();
        while ($row = $query->fetch()) {
            $arr[] = Student::fromRow($row);
        }

        return $arr;
    }
}

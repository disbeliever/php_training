<?php

class StudentTableGateway
{
    private $pdo;
    private $studentsPerPage;
    public function __construct(PDO $pdo, $studentsPerPage)
    {
        $this->pdo = $pdo;
        $this->studentsPerPage = $studentsPerPage;
    }

    public function addStudent(Student $student)
    {
        $query = $this->pdo->prepare("INSERT INTO students(first_name, last_name, student_group, mark, email, gender, birthyear, auth_code) VALUES(:first_name, :last_name, :student_group, :mark, :email, :gender, :birthyear, :auth_code) RETURNING id");

        $query->bindValue(":first_name", $student->firstName);
        $query->bindValue(":last_name", $student->lastName);
        $query->bindValue(":student_group", $student->group);
        $query->bindValue(":mark", $student->mark);
        $query->bindValue(":email", $student->email);
        $query->bindValue(":gender", $student->gender);
        $query->bindValue(":birthyear", $student->birthyear);
        $query->bindValue(":auth_code", $student->auth);
        
        $query->execute();
        $student->id = $query->fetchColumn();
    }

    public function updateStudent(Student $student)
    {
        $query_string = "UPDATE students SET first_name=:first_name,last_name=:last_name,student_group=:student_group,mark=:mark,email=:email,gender=:gender,birthyear=:birthyear WHERE auth_code=:auth";

        $query = $this->pdo->prepare($query_string);

        $query->bindValue(":auth", $student->auth);
        $query->bindValue(":first_name", $student->firstName);
        $query->bindValue(":last_name", $student->lastName);
        $query->bindValue(":student_group", $student->group);
        $query->bindValue(":mark", $student->mark);
        $query->bindValue(":email", $student->email);
        $query->bindValue(":gender", $student->gender);
        $query->bindValue(":birthyear", $student->birthyear);

        $query->execute();
    }

    public function getStudent($key)
    {
        if (is_string($key) && strlen($key) == CONFIG_AUTH_LENGTH) {
            $query = $this->pdo->prepare("SELECT * FROM students WHERE auth_code=:auth_code");
            $query->bindValue(":auth_code", $key);
        }
        else if (is_numeric($key)) {
            $query = $this->pdo->prepare("SELECT * FROM students WHERE id=:id");
            $query->bindValue(":id", $key);
        }

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

    public function getAllStudents($sortField, $sortDir, $page)
    {
        $sortField = $this->getValidSortField($sortField);
        $sortDir = $sortDir == 'desc' ? "DESC" : "";
        $query = $this->pdo->prepare("SELECT * FROM students ORDER BY $sortField $sortDir LIMIT $this->studentsPerPage OFFSET " . $this->studentsPerPage * ($page-1));
        $query->execute();

        $students = array();
        while ($row = $query->fetch()) {
            $students[] = Student::fromRow($row);
        }

        return $students;
    }

    public function getTotalStudentsNum()
    {
        $query = $this->pdo->query("SELECT COUNT(id) FROM students");
        $count = $query->fetchColumn();
        return $count;
    }

    public function isEmailInDB($student)
    {
        $query = $this->pdo->prepare("SELECT COUNT(email) FROM students WHERE email ILIKE :email AND auth_code <> :auth_code");
        $query->bindValue(":email", $student->email);
        $query->bindValue(":auth_code", $student->auth);
        $query->execute();
        $count = $query->fetchColumn();
        return $count > 0;
    }

    public function searchInDB($searchString, $sortField, $sortDir)
    {
        $sortField = $this->getValidSortField($sortField);
        $sortDir = $sortDir == 'desc' ? "DESC" : "";
        $query = $this->pdo->prepare("SELECT * FROM students WHERE CONCAT(first_name, ' ', last_name, ' ', student_group, ' ', mark) ILIKE '%' || :search_string || '%' ORDER BY $sortField $sortDir");
        $query->bindValue(":search_string", $searchString, PDO::PARAM_STR);
        $query->execute();
        $arr = array();
        while ($row = $query->fetch()) {
            $arr[] = Student::fromRow($row);
        }

        return $arr;
    }
}

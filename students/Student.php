<?php

class Student
{
    public $firstName;
    public $lastName;
    public $group;
    public $gender;
    public $mark; // баллы
    public $birthyear;
    public $local;
    public $email;
    
    
    public function __construct($row)
    {
        $this->id = $row['id'];
        $this->firstName = $row['first_name'];
        $this->lastName = $row['last_name'];
        $this->group = $row['student_group'];
        $this->mark = $row['mark'];
        $this->email = $row['email'];
    }
}

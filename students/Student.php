<?php

class Student
{
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

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
        switch ($row['gender'])
        {
            case 'male': {
                $this->gender = self::GENDER_MALE;
                break;
            }

            case 'female': {
                $this->gender = self::GENDER_FEMALE;
                break;
            }

            default: {
                $this->gender = null;
                break;
            }
        }
        $this->mark = $row['mark'];
        $this->email = $row['email'];
    }
}

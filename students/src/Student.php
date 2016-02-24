<?php

class Student
{
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    public $id;
    public $firstName;
    public $lastName;
    public $group;
    public $gender;
    public $mark; // баллы
    public $birthyear;
    public $local;
    public $email;
    public $auth;

    public function __construct()
    {

    }
    
    public static function fromRow(array $row)
    {
        $s = new self();
        $s->id = $row['id'];
        $s->firstName = $row['first_name'];
        $s->lastName = $row['last_name'];
        $s->group = $row['student_group'];
        switch ($row['gender'])
        {
            case 'male': {
                $s->gender = self::GENDER_MALE;
                break;
            }

            case 'female': {
                $s->gender = self::GENDER_FEMALE;
                break;
            }

            default: {
                $s->gender = null;
                break;
            }
        }
        $s->mark = $row['mark'];
        $s->birthyear = $row['birthyear'];
        $s->email = $row['email'];
        $s->auth = $row['auth_code'];

        return $s;
    }
}

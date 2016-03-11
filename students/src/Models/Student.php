<?php
namespace App\Models;

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
}

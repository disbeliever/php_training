<?php
namespace App\Helpers;

use \App\Models\Student;

class StudentHelper
{
    public static function fillStudentFromArrayAndCookies(array $formData, Student $student)
    {
        $fieldsForEdit = array('firstName', 'lastName', 'group', 'mark', 'gender', 'birthyear', 'email');
        foreach ($fieldsForEdit as $field) {
            if (isset($formData[$field])) {
                $student->$field = is_numeric($formData[$field]) ?
                                   intval($formData[$field]) :
                                   trim(strval($formData[$field]));
            }
        }

        if (isset($formData['gender'])) {
            switch($formData['gender'])
            {
                case Student::GENDER_MALE: {
                    $student->gender = Student::GENDER_MALE;
                    break;
                }
                case Student::GENDER_FEMALE: {
                    $student->gender = Student::GENDER_FEMALE;
                    break;
                }
                default: {
                    $student->gender = null;
                    break;
                }
            }
        }
        $student->auth = isset($_COOKIE['auth']) ? $_COOKIE['auth'] : "";
        return $student;
    }
}

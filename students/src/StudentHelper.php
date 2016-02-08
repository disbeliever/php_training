<?php
class StudentHelper
{
    public static function updateStudentFromPostAndCookies($student)
    {
        $fieldsForEdit = array('firstName', 'lastName', 'group', 'mark', 'gender', 'birthyear', 'email');
        foreach ($fieldsForEdit as $field) {
            if (isset($_POST[$field])) {
                $student->$field = is_numeric($_POST[$field]) ? intval($_POST[$field]) : trim(strval($_POST[$field]));
            }
        }

        if (isset($_POST['gender'])) {
            switch($_POST['gender'])
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

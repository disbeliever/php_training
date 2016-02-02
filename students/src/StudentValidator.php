<?php
class StudentValidator
{
    private $stg;
    public function __construct(StudentTableGateway $stg)
    {
        $this->stg = $stg;
    }

    private static function validateNotEmptyAndMaxLength($fieldValue, $fieldName, $maxLength)
    {
        if ($fieldValue == "") {
            return "Поле '$fieldName' не должно быть пустым";
        }
        else if (($length = mb_strlen($fieldValue)) > $maxLength) {
            return "Максимальное количество символов в поле '$fieldName' - $maxLength (вы ввели $length)";
        }
        else {
            return null;
        }
    }

    private static function validateNumberWihtLimits($fieldValue, $min, $max)
    {
        if (!is_numeric($fieldValue) || $fieldValue < $min || $fieldValue > $max) {
            return "Необходимо ввести число от $min до $max";
        }
    }

    private static function validateGroupNumber($fieldValue, $maxLength)
    {
        if (!$fieldValue || mb_strlen($fieldValue) > $maxLength || !ctype_alnum($fieldValue)) {
            return "Номер группы должен содержать только буквы и цифры (не более $maxLength символов)";
        }
    }

    private static function validateGender($fieldValue)
    {
        if (!($fieldValue == "male" || $fieldValue == "female"))
            return "Выберите один из вариантов";
    }

    private function validateEmail($student)
    {
        $email = $student->email;
        if ($email == "" || mb_strlen($email) == 0) {
            return "Укажите E-mail";
        }
        else if (mb_strlen($email) > 254) {
            return "Длина E-mail не может превышать 254 символов";
        }
        else if (!(preg_match("/.+@.+\..+/i", $email) == 1)) {
            return "Укажите корректный E-mail (вида user@domain.suf)";
        }
        else if ($this->stg->isEmailInDB($student)) {
            return "Этот E-mail уже присутствует в базе данных";
        }
    }

    public function validate(Student $student)
    {
        $errors = array();
        $errors['firstName'] = self::validateNotEmptyAndMaxLength($student->firstName, "имя", 90);
        $errors['lastName'] = self::validateNotEmptyAndMaxLength($student->lastName, "фамилия", 90);
        $errors['group'] = self::validateGroupNumber($student->group, 5);
        $errors['mark'] = self::validateNumberWihtLimits($student->mark, 0, 300);
        $errors['gender'] = self::validateGender($student->gender);
        $errors['birthyear'] = self::validateNumberWihtLimits($student->birthyear, 1900, 2000);
        $errors['email'] = $this->validateEmail($student);

        return array_filter($errors);
    }
}

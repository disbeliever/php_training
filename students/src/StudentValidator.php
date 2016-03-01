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
        else {
            $strLength = mb_strlen($fieldValue);
            if ($strLength > $maxLength) {
                return "Максимальное количество символов в поле '$fieldName' - $maxLength (вы ввели $strLength)";
            }
            else {
                return null;
            }
        }
    }

    private static function validateName($fieldValue, $fieldName, $maxLength)
    {
        if (!$fieldValue) {
            return "Заполните поле '$filedName'";
        }
        else if (preg_match('/^[а-яА-ЯёЁ`\-\']+$/u', $fieldValue) != 1) {
            return "Поле может содержать только русские буквы, апостроф и дефис";
        }
        else {
            return self::validateNotEmptyAndMaxLength($fieldValue, $fieldName, $maxLength);
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
        if (!$fieldValue) {
            return "Укажите номер группы";
        }
        else if (!$fieldValue || mb_strlen($fieldValue) > $maxLength ||
            preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9]+$/u', $fieldValue) != 1) {
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
        else if (preg_match("/.+@.+\..+/i", $email) != 1) {
            return "Укажите корректный E-mail (вида user@domain.suf)";
        }
        else if ($this->stg->isEmailInDB($student->email, $student->id)) {
            return "Этот E-mail уже присутствует в базе данных";
        }
    }

    public function validate(Student $student)
    {
        $errors = array();
        $errors['firstName'] = self::validateName($student->firstName, "имя", 90);
        $errors['lastName'] = self::validateName($student->lastName, "фамилия", 90);
        $errors['group'] = self::validateGroupNumber($student->group, 5);
        $errors['mark'] = self::validateNumberWihtLimits($student->mark, 0, 300);
        $errors['gender'] = self::validateGender($student->gender);
        $errors['birthyear'] = self::validateNumberWihtLimits($student->birthyear, 1900, 2000);
        $errors['email'] = $this->validateEmail($student);

        return array_filter($errors);
    }
}

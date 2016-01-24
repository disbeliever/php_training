<?php
require_once('init.php');
require_once('autoloader.php');

function isFormSent()
{
    return isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST";
}

function isEditable()
{
    return isset($_POST['id']) && is_numeric($_POST['id']) && $_POST['id'] > 0;
}

function generateRandomString()
{
    return md5(rand());
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$registered = isset($_GET['registered']);
$changesSaved = isset($_GET['changesSaved']);

if ($registered) {
    $succString = "Регистрация выполнена";
}
else if ($changesSaved) {
    $succString = "Изменения сохранены";
}

/* if method is POST then fill a Student object with data from $_POST
   and try to save it */
if (isFormSent()) {
    $student = new Student();
    foreach (array_keys(get_object_vars($student)) as $field) {
        if (isset($_POST[$field])) {
            $student->$field = is_numeric($_POST[$field]) ? intval($_POST[$field]) : trim(strval($_POST[$field]));
        }
    }

    if (isset($_POST['gender'])) {
        switch($_POST['gender'])
        {
            case 'male': {
                $student->gender = Student::GENDER_MALE;
                break;
            }
            case 'female': {
                $student->gender = Student::GENDER_FEMALE;
                break;
            }
            default: {
                $student->gender = null;
                break;
            }
        }
    }

    $validator = new StudentValidator($STG);
    $errors = $validator->validate($student);

    if (count($errors) == 0) {
        try {
            if (isEditable()) {
                $redirectSuffix = "&changesSaved=1";
                $STG->updateStudent($student);
            }
            else {
                $redirectSuffix = "&registered=1";
                $student->auth = generateRandomString();
                $STG->addStudent($student);
                setcookie('auth', $student->auth, time() + 10*365*24*60*60, '/', null, false, true);
            }
            $redirectTo = "{$_SERVER['SCRIPT_NAME']}?id={$student->id}$redirectSuffix";
            header("Location: $redirectTo");
        }
        catch (PDOException $e) {
            #TODO: actually do something here
            var_dump($e);
            #$errString = ;
        }
    }
}
/* if method is GET then we should retreive student from DB (if we got id)
   or create a new one. */
else if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if ($id > 0) {
        $student = $STG->getStudent($id);
    }
    else if (isset($_COOKIE['auth'])) {
        $student = $STG->getStudent($_COOKIE['auth']);
    }
    else {
        $student = new Student();
    }
}

if ($student != null) {
    if (isset($student->id) && $student->id > 0) {
        $title = "Студент: $student->firstName $student->lastName";
        $saveButtonText = "Сохранить изменения";
    }
    else {
        $title = "Регистрация";
        $saveButtonText = "Зарегистрироваться";
    }
    include('views/ViewStudent.php');
}
else {
    header("HTTP/1.0 404 Student not found");
    $errString = "Абитуриент с id=$id не найден";
    include('views/404.php');
}

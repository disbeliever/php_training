<?php
error_reporting(-1);
require_once('autoloader.php');
require_once('init.php');

function isFormSent()
{
    return isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST";
}

function isEditable()
{
    return isset($_POST['id']) && is_numeric($_POST['id']) && $_POST['id'] > 0;
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

if (isFormSent()) {
    $student = new Student();
    foreach (array_keys(get_object_vars($student)) as $field) {
        if (isset($_POST[$field])) {
            $student->$field = is_numeric($_POST[$field]) ? intval($_POST[$field]) : $_POST[$field];
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

    # TODO: add validation here

    try {
        if (isEditable()) {
            $STG->updateStudent($student);
            header("Location: {$_SERVER['SCRIPT_NAME']}?id={$student->id}&changesSaved=1");
        }
        else {
            $STG->addStudent($student);
            header("Location: {$_SERVER['SCRIPT_NAME']}?id={$student->id}&registered=1");
        }
    }
    catch (PDOException $e) {
        #TODO: actually do something here
        var_dump($e);
        #$errString = ;
    }
}

if ($id > 0) {
    $student = $STG->getStudentById($id);
}
else {
    $student = new Student();
}

if ($student != null) {
    if (isset($student->id)) {
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

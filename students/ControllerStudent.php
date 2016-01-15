<?php
error_reporting(-1);
require_once('autoloader.php');
require_once('init.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$registered = isset($_GET['registered']);

if (isset($_POST['dosave'])) {
    $student = new Student();
    foreach (array_keys(get_object_vars($student)) as $field) {
        if (isset($_POST[$field])) {
            $student->$field = is_numeric($_POST[$field]) ? intval($_POST[$field]) : $_POST[$field];
        }
    }

    try {
        $STG->addStudent($student);
        header("Location: {$_SERVER['SCRIPT_NAME']}?id={$student->id}&registered=1");
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

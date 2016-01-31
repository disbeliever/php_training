<?php
require_once('../src/init.php');
require_once('../src/registerHelpers.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$registered = isset($_GET['registered']);
$changesSaved = isset($_GET['changesSaved']);
$token = getOrGenerateCSRFToken();

if ($registered) {
    $msg = ["class" => "success", "text" => "Регистрация выполнена"];
}
else if ($changesSaved) {
    $msg = ["class" => "success", "text" => "Изменения сохранены"];
}

/* if method is POST then fill a Student object with data from $_POST
   and try to save it */
if (isFormSent()) {

    $student = CreateStudentFromPostAndCookies();
    if (!(isCSRFTokenSet() && isFormTokenSet() && $_COOKIE['csrf'] == $_POST['csrfToken'])) {
        $msg = ["class" => "danger", "text" => "Ошибка CSRF токена"];
    }
    else {
        $validator = new StudentValidator($stg);
        $errors = $validator->validate($student);

        if (count($errors) == 0) {
            try {
                if (isEditable()) {
                    $redirectSuffix = "&changesSaved=1";
                    $stg->updateStudent($student);
                }
                else {
                    $redirectSuffix = "&registered=1";
                    $student->auth = generateRandomString();
                    $stg->addStudent($student);
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
}
/* if method is GET then we should retreive student from DB (if we got id)
   or create a new one. */
else if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if ($id > 0) {
        $student = $stg->getStudent($id);
    }
    else if (isset($_COOKIE['auth'])) {
        $student = $stg->getStudent($_COOKIE['auth']);
    }
    else {
        $student = new Student();
    }
}

if ($student != null) {
    if ((isset($student->id) && $student->id > 0) || isset($_COOKIE['auth'])) {
        $title = "Студент: $student->firstName $student->lastName";
        $saveButtonText = "Сохранить изменения";
    }
    else {
        $title = "Регистрация";
        $saveButtonText = "Зарегистрироваться";
    }
    include('../src/views/ViewStudent.php');
}
else {
    header("HTTP/1.0 404 Student not found");
    $errString = "Абитуриент с id=$id не найден";
    include('../src/views/404.php');
}

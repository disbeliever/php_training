<?php
class ControllerStudent
{
    public function __construct(StudentTableGateway $stg)
    {
        $this->stg = $stg;
    }

    public function run()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $registered = isset($_GET['registered']);
        $changesSaved = isset($_GET['changesSaved']);
        $token = TokenHelper::getOrGenerateCSRFToken();

        if ($registered) {
            $msg = ["class" => "success", "text" => "Регистрация выполнена"];
        }
        else if ($changesSaved) {
            $msg = ["class" => "success", "text" => "Изменения сохранены"];
        }

        /* if method is POST then load Student from DB, update it with data
           from $_POST and try to save it */
        if (FormHelper::isFormSent()) {
            if (isset($_COOKIE['auth'])) {
                $student = $this->stg->getStudentByAuthToken($_COOKIE['auth']);
            } else {
                $student = new Student();
            }
            StudentHelper::fillStudentFromArrayAndCookies($_POST, $student);

            if (!TokenHelper::isCSRFTokenSetAndValid()) {
                $msg = [
                    "class" => "danger",
                    "text" => "Ошибка. Попробуйте сохранить данные ещё раз"
                ];
            }
            else {
                TokenHelper::setCSRFToken($token);
                $validator = new StudentValidator($this->stg);
                $errors = $validator->validate($student);

                if (count($errors) == 0) {
                    if (FormHelper::isEditable()) {
                        $redirectSuffix = "&changesSaved=1";
                        $this->stg->updateStudent($student);
                    }
                    else {
                        $redirectSuffix = "&registered=1";
                        $student->auth = TokenHelper::generateToken();
                        $this->stg->addStudent($student);
                        setcookie('auth', $student->auth, time() + 10*365*24*60*60, '/', null, false, true);
                    }
                    $redirectTo = "student.php?id={$student->id}$redirectSuffix";
                    header("Location: $redirectTo");
                }
            }
        }
        /* if method is GET then we should retreive student from DB (if we got id)
           or create a new one. */
        else if ($_SERVER['REQUEST_METHOD'] == "GET") {
            if ($id > 0) {
                $student = $this->stg->getStudentById($id);
            }
            else if (isset($_COOKIE['auth'])) {
                $student = $this->stg->getStudentByAuthToken($_COOKIE['auth']);
            }
            else {
                $student = new Student();
            }
        }

        if ($student != null) {
            if ($student->auth != $_COOKIE['auth']) {
                header("HTTP/1.0 403 Access denied");
                $errString = "Нет доступа";
                include(__DIR__ . '/../src/views/Error.php');
                return;
            }

            if ((isset($student->id) && $student->id > 0) ||
                (isset($_COOKIE['auth']) && $this->stg->doStudentExists($_COOKIE['auth']))) {
                $title = "Студент: $student->firstName $student->lastName";
                $saveButtonText = "Сохранить изменения";
            }
            else {
                $title = "Регистрация";
                $saveButtonText = "Зарегистрироваться";
            }
            include(__DIR__ . '/../src/views/ViewStudent.php');
        }
        else {
            header("HTTP/1.0 404 Student not found");
            $errString = "Абитуриент с id=$id не найден";
            include(__DIR__ . '/../src/views/Error.php');
        }

    }
}

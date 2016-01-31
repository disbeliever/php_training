<?php
function isFormSent()
{
    return isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST";
}

function isEditable()
{
    return (isset($_POST['id']) && is_numeric($_POST['id']) && $_POST['id'] > 0) ||
          (isset($_COOKIE['auth']) && $_COOKIE['auth'] != "");
}

function generateRandomString()
{
    return md5(rand());
}

function createStudentFromPostAndCookies()
{
    $student = new Student();
    foreach (array_keys(get_object_vars($student)) as $field) {
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

function setCSRFToken($token)
{
    setcookie('csrf', $token, time() + 24*60*60, '/', null, false, true);
}

function getOrGenerateCSRFToken()
{
    if (isset($_COOKIE['csrf']) && $_COOKIE['csrf'] != "") {
        $token = $_COOKIE['csrf'];
    }
    else {
        var_dump("set new token");
        setCSRFToken($token = generateRandomString());
    }
    return $token;
}

function isCSRFTokenSet()
{
    return isset($_COOKIE['csrf']) && $_COOKIE['csrf'] != "";
}

function isFormTokenSet()
{
    return isset($_POST['csrfToken']) && $_POST['csrfToken'] != "";
}

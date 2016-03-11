<?php
namespace App\Helpers;

class FormHelper
{
    public static function isFormSent()
    {
        return isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST";
    }

    public static function isEditable()
    {
        return (isset($_POST['id']) && is_numeric($_POST['id']) && $_POST['id'] > 0) ||
              (isset($_COOKIE['auth']) && $_COOKIE['auth'] != "");
    }
}

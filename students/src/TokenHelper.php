<?php
class TokenHelper
{
    public static function generateToken()
    {
        return md5(rand());
    }

    public static function getOrGenerateCSRFToken()
    {
        if (isset($_COOKIE['csrf']) && $_COOKIE['csrf'] != "") {
            $token = $_COOKIE['csrf'];
        }
        else {
            self::setCSRFToken($token = self::generateToken());
        }
        return $token;
    }

    
    private static function isCSRFTokenSet()
    {
        return isset($_COOKIE['csrf']) && $_COOKIE['csrf'] != "";
    }

    private static function isFormTokenSet()
    {
        return isset($_POST['csrfToken']) && $_POST['csrfToken'] != "";
    }


    public static function isCSRFTokenSetAndValid()
    {
        return self::isCSRFTokenSet() && self::isFormTokenSet() && $_COOKIE['csrf'] == $_POST['csrfToken'];
    }

    public static function setCSRFToken($token)
    {
        setcookie('csrf', $token, time() + 24*60*60, '/', null, false, true);
    }
}

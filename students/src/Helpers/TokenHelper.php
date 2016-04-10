<?php
namespace App\Helpers;

class TokenHelper
{
    const AUTH_TOKEN_LENGTH = 32;
    public static function generateToken()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = mb_strlen($characters);
        $randomString = '';
        for ($i = 0; $i < self::AUTH_TOKEN_LENGTH; $i++) {
            $randomString .= mb_substr(
                $characters,
                rand(0, $charactersLength - 1),
                1
            );
        }
        return $randomString;
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

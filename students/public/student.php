<?php
require_once('../src/init.php');

try {
    $app = new ControllerStudent($stg);
    $app->run();
}
catch(Exception $e) {
    $errString = "Упс, что-то пошло не так :(";
    header("{$_SERVER['SERVER_PROTOCOL']} 503 Sorry about the mess");
    include('../src/views/Error.php');
    error_log($e);
}

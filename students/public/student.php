<?php
require_once('../src/init.php');

$app = new ControllerStudent($stg);

try {
    $app->run();
}
catch(Exception $e) {
    $errString = "Упс, что-то пошло не так :(";
    header("{$_SERVER['SERVER_PROTOCOL']} 503 Sorry about the mess");
    include('../src/views/404.php');
    error_log($e);
}

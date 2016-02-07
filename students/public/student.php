<?php
require_once('../src/init.php');
require_once('../src/registerHelpers.php');

$app = new ControllerStudent($stg);

try {
    $app->run();
}
catch(Exception $e) {
    $errString = "Упс, что-то пошло не так :(";
    include('../src/views/404.php');
    error_log($e);
}

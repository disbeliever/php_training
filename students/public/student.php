<?php
require_once(__DIR__ . '/../src/init.php');

use \App\Controllers\ControllerStudent;

try {
    $app = new ControllerStudent($stg);
    $app->run();
}
catch(Exception $e) {
    error_log($e);
    $errString = "Упс, что-то пошло не так :(";
    header("{$_SERVER['SERVER_PROTOCOL']} 503 Sorry about the mess");
    include('../src/views/Error.php');
}

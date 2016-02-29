<?php
require_once(__DIR__ . '/../src/init.php');

try {
    $app = new ControllerStudentsList($stg);
    $app->run($config['studentsPerPage']);
}
catch(Exception $e) {
    error_log($e);
    $errString = "Упс, что-то пошло не так :(";
    header("{$_SERVER['SERVER_PROTOCOL']} 503 Sorry about the mess");
    include('../src/views/Error.php');
}

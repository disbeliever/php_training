<?php
require '../vendor/autoload.php';

$app = new \Slim\App();
$app->get('/', function() {
    include('../src/views/index.html'); 
});
$app->run();

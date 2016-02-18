<?php
require '../vendor/autoload.php';

$app = new \Slim\App();
$app->get('/', function() {
    include('../src/views/index.phtml'); 
});
$app->get('/last/', function() {
    include('../src/views/last.phtml');
});
$app->run();

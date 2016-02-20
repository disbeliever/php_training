<?php
require '../vendor/autoload.php';

$app = new \Slim\App();

$container = $app->getContainer();
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('../src/views', [
        'cache' => false
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    return $view;
};

$app->get('/', function($request, $response, $args) {
    return $this->view->render($response, 'index.html', array());
});
$app->get('/last/', function($request, $response, $args) {
    return $this->view->render($response, 'last.html', array());
});
$app->run();

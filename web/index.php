<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$app = new Slim\App();

$app->get('/helloworld/{name}', [ new \Addtool\Slim\UseCases\HelloWorld\RequestHandler(), 'handle' ] );

$app->run();

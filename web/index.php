<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$container = new Pimple\Container();

$container['simplecachefactory'] = function ($c) {
	return new \Addtool\SimpleCache\SimpleCacheFactory();
};

$container['requesthandler_helloworld'] = function ($c) {
	return new \Addtool\Slim\UseCases\HelloWorld\RequestHandler();
};
$container['wikimedia_gerrit_changeidextractor'] = function ($c) {
	return new \Addtool\Wikimedia\Gerrit\UrlChangeIdExtractor();
};

$app = new Slim\App();

$app->get('/helloworld/{name}', [ $container['requesthandler_helloworld'], 'handle' ] );

$app->run();

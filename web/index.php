<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$container = new Pimple\Container();

$container['simplecachefactory'] = function ($c) {
	return new \Addtool\SimpleCache\SimpleCacheFactory();
};

$container['slim_helloworld'] = function ($c) {
	return new \Addtool\Slim\HelloWorld();
};
$container['slim_isitdeployed'] = function ($c) {
	return new \Addtool\Slim\IsItDeployed(
		$c['wikimedia_gerrit_changeidextractor']
	);
};
$container['wikimedia_gerrit_changeidextractor'] = function ($c) {
	return new \Addtool\Wikimedia\Gerrit\UrlChangeIdExtractor();
};

$app = new Slim\App();

$app->get('/helloworld/{name}', [ $container['slim_helloworld'], 'handle' ] );
$app->get('/isitdeployed/{gerriturl:.*}', [ $container['slim_isitdeployed'], 'handle' ] );

$app->run();

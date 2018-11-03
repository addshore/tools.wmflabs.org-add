<?php

require_once __DIR__ .
	DIRECTORY_SEPARATOR . '..' .
	DIRECTORY_SEPARATOR . '..' .
	DIRECTORY_SEPARATOR . 'src' .
	DIRECTORY_SEPARATOR . 'vendor' .
	DIRECTORY_SEPARATOR . 'autoload.php';

$services = new \Addtool\Services();
$app = new Slim\App();

$app->get('/add/api/helloworld/{name}', [ $services['slim_helloworld'], 'handle' ] );
$app->get( '/add/api/changesfrombug/{bug}', [ $services['slim_changesfrombug'], 'handle' ] );
$app->get(
	'/add/api/spec',
	[ new \Addtool\Slim\OpenApiSpec( require_once __DIR__ . DIRECTORY_SEPARATOR . 'spec.php'), 'handle' ]
);
$app->get(
	'/add/api/gerrit.wikimedia/deployedSites/{gerriturl:.*}',
	[ $services['slim_whereisitdeployed'], 'handle' ]
);

$app->run();

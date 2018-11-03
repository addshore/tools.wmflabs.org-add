<?php

require_once __DIR__ .
	DIRECTORY_SEPARATOR . '..' .
	DIRECTORY_SEPARATOR . '..' .
	DIRECTORY_SEPARATOR . 'src' .
	DIRECTORY_SEPARATOR . 'vendor' .
	DIRECTORY_SEPARATOR . 'autoload.php';

$services = new \Addtool\Services();
$app = new Slim\App();

$getOpenApiSpecRequestHandler = function () {
	// 2468 indicates a dev env (with docker)
	if( $_SERVER['SERVER_PORT'] == 2468 ) {
		$baseUrl = "http://localhost:3333/add/api/";
	} else {
		$baseUrl = "https://tools.wmflabs.org/add/api/";
	}
	return new \Addtool\Slim\OpenApiSpec(
		new \erasys\OpenApi\Spec\v3\Document(
			new \erasys\OpenApi\Spec\v3\Info(
				'Add Tool', '0.0.1', 'A collection of Apis..'
			),
			[
				'/spec' => new \erasys\OpenApi\Spec\v3\PathItem(
					[
						'get' => new \erasys\OpenApi\Spec\v3\Operation(
							[
								'200' => new \erasys\OpenApi\Spec\v3\Response( 'Successful response.' ),
								'default' => new \erasys\OpenApi\Spec\v3\Response(
									'Default error response.'
								),
							]
						)
					]
				),
				'/gerrit.wikimedia/deployedSites/{gerritchange}' => new \erasys\OpenApi\Spec\v3\PathItem(
					[
						'get' => new \erasys\OpenApi\Spec\v3\Operation(
							[
								'200' => new \erasys\OpenApi\Spec\v3\Response( 'Successful response.' ),
								'default' => new \erasys\OpenApi\Spec\v3\Response(
									'Default error response.'
								),
							]
						),
						'parameters' => [
							new \erasys\OpenApi\Spec\v3\Parameter(
								'gerritchange',
								'path',
								'Gerrit change URL',
								[
									'schema' => new \erasys\OpenApi\Spec\v3\Schema(
										[
											'type' => 'string',
										]
									),
									'example' => 'https://gerrit.wikimedia.org/r/#/c/mediawiki/extensions/WikibaseQualityConstraints/+/470058/',
								]
							)
						],
					]
				),
			],
			'3.0.1',
			[
				'servers' => [
					new \erasys\OpenApi\Spec\v3\Server(
						$baseUrl
					)
				]
			]
		)
	);
};

$app->get('/add/api/helloworld/{name}', [ $services['slim_helloworld'], 'handle' ] );
$app->get( '/add/api/changesfrombug/{bug}', [ $services['slim_changesfrombug'], 'handle' ] );
$app->get(
	'/add/api/spec',
	[ $getOpenApiSpecRequestHandler(), 'handle' ]
);
$app->get(
	'/add/api/gerrit.wikimedia/deployedSites/{gerriturl:.*}',
	[ $services['slim_whereisitdeployed'], 'handle' ]
);

$app->run();

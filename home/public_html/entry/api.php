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
	return new \Addtool\Slim\OpenApiSpec(
		new \erasys\OpenApi\Spec\v3\Document(
			new \erasys\OpenApi\Spec\v3\Info(
				'Add Tool', '0.0.1', 'A collection of Apis..'
			), [
				'/add/api/spec' => new \erasys\OpenApi\Spec\v3\PathItem(
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
				'/add/api/gerrit.wikimedia/deployedSites/{gerritchange}' => new \erasys\OpenApi\Spec\v3\PathItem(
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

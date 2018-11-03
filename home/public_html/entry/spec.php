<?php

// 2468 indicates a dev env (with docker)
if ( $_SERVER['SERVER_PORT'] == 2468 ) {
	$baseUrl = "http://localhost:3333/add/api/";
} else {
	$baseUrl = "https://tools.wmflabs.org/add/api/";
}

return new \erasys\OpenApi\Spec\v3\Document(
	new \erasys\OpenApi\Spec\v3\Info(
		'Add Tool', '0.0.1', 'A collection of Apis..'
	), [
		'/spec' => new \erasys\OpenApi\Spec\v3\PathItem(
			[
				'get' => new \erasys\OpenApi\Spec\v3\Operation(
					[
						'200' => new \erasys\OpenApi\Spec\v3\Response( 'Successful response.' ),
						'default' => new \erasys\OpenApi\Spec\v3\Response(
							'Default error response.'
						),
					],
					null,
					'Get the Open API spec.',
					[
						'tags' => [
							'local'
						]
					]
				),
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
					],
					null,
					'Get a list of Wikimedia sites that the given Gerrit change is deployed on.',
					[
						'description' => "Sites are provided as a list of Wikimedia site Ids.\n\nDeployed does not necessarily mean that the code is enabled.",
						'tags' => [
							'gerrit.wikimedia'
						],
					]
				),
				'parameters' => [
					new \erasys\OpenApi\Spec\v3\Parameter(
						'gerritchange', 'path', 'Gerrit change URL', [
							'schema' => new \erasys\OpenApi\Spec\v3\Schema(
								[
									'type' => 'string',
								]
							),
							'example' => 'https://gerrit.wikimedia.org/r/#/c/mediawiki/extensions/WikibaseQualityConstraints/+/470058/',
						]
					),
				],
			]
		),
	], '3.0.1', [
		'servers' => [
			new \erasys\OpenApi\Spec\v3\Server(
				$baseUrl
			),
		],
	]
);

<?php

require_once __DIR__ .
	DIRECTORY_SEPARATOR . '..' .
	DIRECTORY_SEPARATOR . '..' .
	DIRECTORY_SEPARATOR . 'src' .
	DIRECTORY_SEPARATOR . 'vendor' .
	DIRECTORY_SEPARATOR . 'autoload.php';

$container = new Pimple\Container();

$container['simplecachefactory'] = function ($c) {
	return new \Addtool\SimpleCache\SimpleCacheFactory();
};
$container['simplecache-10'] = function ($c) {
	/** @var \Addtool\SimpleCache\SimpleCacheFactory $f */
	$f = $c['simplecachefactory'];
	return $f->newSimpleCache( 10 );
};
$container['simplecache-60'] = function ($c) {
	/** @var \Addtool\SimpleCache\SimpleCacheFactory $f */
	$f = $c['simplecachefactory'];
	return $f->newSimpleCache( 60 );
};

$container['slim_helloworld'] = function ($c) {
	return new \Addtool\Slim\HelloWorld();
};
$container['slim_whereisitdeployed'] = function ($c) {
	return new \Addtool\Slim\WhereIsItDeployed(
		$c['wikimedia_gerrit_changeidextractor'],
		$c['wikimedia_gerrit_changesfetcher'],
		$c['wikimedia_noc']
	);
};
$container['slim_changesfrombug'] = function ($c) {
	return new \Addtool\Slim\ChangesFromBug(
		$c['wikimedia_gerrit_changesfetcher']
	);
};
$container['wikimedia_noc'] = function ($c) {
	return new \Addtool\Wikimedia\Noc\WikimediaNoc(
		$c['simplecache-10']
	);
};
$container['wikimedia_gerrit'] = function ($c) {
	return new \Addtool\Wikimedia\Gerrit\CachedGerrit(
		'https://gerrit.wikimedia.org',
		$c['simplecache-60']
	);
};
$container['wikimedia_gerrit_changeidextractor'] = function ($c) {
	return new \Addtool\Wikimedia\Gerrit\UrlChangeIdExtractor();
};
$container['wikimedia_gerrit_changesfetcher'] = function ($c) {
	return new \Addtool\Wikimedia\Gerrit\ChangesFetcher(
		$c['wikimedia_gerrit']
	);
};

$container['openapi-spec'] = function ( $c ) {
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

$app = new Slim\App();

$app->get('/add/api/helloworld/{name}', [ $container['slim_helloworld'], 'handle' ] );
$app->get( '/add/api/changesfrombug/{bug}', [ $container['slim_changesfrombug'], 'handle' ] );


$app->get(
	'/add/api/spec',
	[ $container['openapi-spec'], 'handle' ]
);
$app->get(
	'/add/api/gerrit.wikimedia/deployedSites/{gerriturl:.*}',
	[ $container['slim_whereisitdeployed'], 'handle' ]
);

$app->run();

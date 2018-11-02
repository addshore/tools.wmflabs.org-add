<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

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

$app = new Slim\App();

$app->get('/helloworld/{name}', [ $container['slim_helloworld'], 'handle' ] );
$app->get('/whereisitdeployed/{gerriturl:.*}', [ $container['slim_whereisitdeployed'], 'handle' ] );
$app->get( '/changesfrombug/{bug}', [ $container['slim_changesfrombug'], 'handle' ] );

$app->run();

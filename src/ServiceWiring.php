<?php

namespace Addtool;

return [
	'simplecachefactory' => function ( $c ) {
		return new \Addtool\SimpleCache\SimpleCacheFactory();
	},
	'simplecache-10' => function ( $c ) {
		/** @var \Addtool\SimpleCache\SimpleCacheFactory $f */
		$f = $c['simplecachefactory'];

		return $f->newSimpleCache( 10 );
	},
	'simplecache-60' => function ( $c ) {
		/** @var \Addtool\SimpleCache\SimpleCacheFactory $f */
		$f = $c['simplecachefactory'];

		return $f->newSimpleCache( 60 );
	},
	'slim_helloworld' => function ($c) {
		return new \Addtool\Slim\HelloWorld();
	},
	'slim_whereisitdeployed' => function ($c) {
		return new \Addtool\Slim\WhereIsItDeployed(
			$c['wikimedia_gerrit_changeidextractor'],
			$c['wikimedia_gerrit_changesfetcher'],
			$c['wikimedia_noc']
		);	},
	'slim_changesfrombug' => function ($c) {
		return new \Addtool\Slim\ChangesFromBug(
			$c['wikimedia_gerrit_changesfetcher']
		);
	},
	'wikimedia_noc' => function ( $c ) {
		return new \Addtool\Wikimedia\Noc\WikimediaNoc(
			$c['simplecache-10']
		);
	},
	'wikimedia_gerrit' => function ( $c ) {
		return new \Addtool\Wikimedia\Gerrit\CachedGerrit(
			'https://gerrit.wikimedia.org',
			$c['simplecache-60']
		);
	},
	'wikimedia_gerrit_changeidextractor' => function ( $c ) {
		return new \Addtool\Wikimedia\Gerrit\UrlChangeIdExtractor();

	},
	'wikimedia_gerrit_changesfetcher' => function ( $c ) {
		return new \Addtool\Wikimedia\Gerrit\ChangesFetcher(
			$c['wikimedia_gerrit']
		);
	},
];

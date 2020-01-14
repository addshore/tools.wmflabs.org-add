<?php

namespace Addtool;

return [

	// Caches
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

	// Sites
	'site_gerrit.wikimedia.org' => function ( $c ) {
		return new \Addtool\CachedSite(
			"https://gerrit.wikimedia.org",
			$c['simplecache-60']
		);
	},
	'site_noc.wikimedia.org' => function ( $c ) {
		return new \Addtool\CachedSite(
			"https://noc.wikimedia.org",
			$c['simplecache-10']
		);
	},

	// Apis
	'slim_helloworld' => function ($c) {
		return new \Addtool\Slim\HelloWorld();
	},
	'slim_whereisitdeployed' => function ($c) {
		return new \Addtool\Slim\WhereIsItDeployed(
			$c['app_wikimedia_gerrit_changeidextractor'],
			$c['app_wikimedia_gerrit_changes'],
			$c['app_wikimedia_noc_wikiversions']
		);	},
	'slim_changesfrombug' => function ($c) {
		return new \Addtool\Slim\ChangesFromBug(
			$c['app_wikimedia_gerrit_changes']
		);
	},

	// App services
	'app_wikimedia_noc_wikiversions' => function ( $c ) {
		return new \Addtool\Wikimedia\Noc\Services\WikiVersions(
			$c['site_noc.wikimedia.org']
		);
	},
	'app_wikimedia_gerrit_changeidextractor' => function ( $c ) {
		return new Wikimedia\Gerrit\Utility\UrlChangeIdExtractor();

	},
	'app_wikimedia_gerrit_changes' => function ( $c ) {
		return new \Addtool\Wikimedia\Gerrit\Services\Changes(
			$c['site_gerrit.wikimedia.org']
		);
	},

];

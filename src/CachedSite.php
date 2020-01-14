<?php

namespace Addtool;

use Addtool\SimpleCache\SimpleCache;

class CachedSite {

	private $baseUrl;
	protected $simpleCache;

	/**
	 * @param string $baseUrl Example: https://gerrit.wikimedia.org
	 * @param SimpleCache $simpleCache
	 */
	public function __construct(
		string $baseUrl,
		SimpleCache $simpleCache
	) {
		$this->baseUrl = $baseUrl;
		$this->simpleCache = $simpleCache;
	}

	/**
	 * @param string $path Example: /foo/bar
	 * @return bool|false|string
	 */
	public function getRequest( string $path ) {
		return $this->simpleCache->get( $this->baseUrl . $path );
	}

}

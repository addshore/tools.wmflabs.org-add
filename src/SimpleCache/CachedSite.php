<?php

namespace Addtool\SimpleCache;

use Addtool\Interfaces\RequestableSite;

class CachedSite implements RequestableSite {

	private $baseUrl;
	protected $simpleCache;

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

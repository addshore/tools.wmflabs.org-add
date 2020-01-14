<?php

namespace Addtool\Wikimedia\Gerrit;

use Addtool\Interfaces\RequestableSite;
use Addtool\SimpleCache\SimpleCache;

class Gerrit implements RequestableSite {

	private $baseUrl;
	private $simpleCache;

	public function __construct(
		string $baseUrl, SimpleCache $simpleCache
	) {
		$this->baseUrl = $baseUrl;
		$this->simpleCache = $simpleCache;
	}

	/**
	 * @param string $path Example: /r/changes/1234
	 * @return bool|false|string
	 */
	public function getRequest( string $path ) {
		return $this->simpleCache->get( $this->baseUrl . $path );
	}

}

<?php

namespace Addtool\Wikimedia\Gerrit;

use Addtool\SimpleCache\SimpleCache;

class CachedGerrit
{
	private $gerritUrl;
	private $simpleCache;

	public function __construct(
		string $gerritUrl,
		SimpleCache $simpleCache
	)
	{
		$this->gerritUrl = $gerritUrl;
		$this->simpleCache = $simpleCache;
	}

	/**
	 * @param string $path Example: /r/changes/1234
	 */
	public function getRequest( string $path ) {
		return $this->simpleCache->get( $this->gerritUrl . $path );
	}

}

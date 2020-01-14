<?php

namespace Addtool\Wikimedia\Noc;

use Addtool\Interfaces\RequestableSite;
use Addtool\SimpleCache\SimpleCache;

class Noc implements RequestableSite {

	private $baseUrl = 'https://noc.wikimedia.org';
	private $simpleCache;

	public function __construct(
		SimpleCache $simpleCache
	) {
		$this->simpleCache = $simpleCache;
	}

	/**
	 * @param string $path Example: /r/changes/1234
	 * @return bool|false|string
	 */
	public function getRequest( string $path ) {
		return $this->simpleCache->get( $this->baseUrl . $path );
	}

	/**
	 * @return array mapping dbname => version deployed
	 * @todo getting this from Gerrit / git directly would be better?
	 */
	public function getWikiVersions(): array {
		$wikiVersions = $this->getRequest( "/conf/wikiversions.json" );
		$wikiVersions = json_decode( $wikiVersions, true );

		return $wikiVersions;
	}

}

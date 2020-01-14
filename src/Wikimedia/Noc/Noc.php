<?php

namespace Addtool\Wikimedia\Noc;

use Addtool\SimpleCache\CachedSite;
use Addtool\SimpleCache\SimpleCache;

class Noc extends CachedSite {

	public function __construct( SimpleCache $simpleCache ) {
		parent::__construct( "https://noc.wikimedia.org", $simpleCache );
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

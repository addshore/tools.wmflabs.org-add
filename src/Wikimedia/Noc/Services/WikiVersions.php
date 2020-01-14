<?php

namespace Addtool\Wikimedia\Noc\Services;

use Addtool\CachedSite;

class WikiVersions {

	private $site;

	public function __construct( CachedSite $site ) {
		$this->site = $site;
	}

	/**
	 * @return array mapping dbname => version deployed
	 * @todo getting this from Gerrit / git directly would be better?
	 */
	public function get(): array {
		$wikiVersions = $this->site->getRequest( "/conf/wikiversions.json" );
		$wikiVersions = json_decode( $wikiVersions, true );

		return $wikiVersions;
	}

}

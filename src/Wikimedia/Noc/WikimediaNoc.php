<?php

namespace Addtool\Wikimedia\Noc;

use Addtool\SimpleCache\SimpleCache;

class WikimediaNoc {

	private $nocUrl = 'https://noc.wikimedia.org';
	private $simpleCache;

	public function __construct(
		SimpleCache $simpleCache
	)
	{
		$this->simpleCache = $simpleCache;
	}

	/**
	 * TODO getting this from gerrit / git directly would be better?
	 * @return array mapping dbname => version deployed
	 */
	public function getWikiVersions() : array {
		$wikiVersions = $this->simpleCache->do_curl(
			 $this->nocUrl . "/conf/wikiversions.json"
		);
		$wikiVersions = json_decode( $wikiVersions, true );
		return $wikiVersions;
	}

}

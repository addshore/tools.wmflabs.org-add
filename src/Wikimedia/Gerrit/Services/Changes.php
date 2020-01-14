<?php

namespace Addtool\Wikimedia\Gerrit\Services;

use Addtool\CachedSite;

class Changes {

	private $site;

	public function __construct(
		CachedSite $site
	) {
		$this->site = $site;
	}

	/**
	 * @param string $s
	 * @return string
	 */
	private function cleanResponse ( string $s ) : string {
		$s = str_replace( ")]}'", "", $s );
		return trim( $s );
	}

	private function getArrayFromResponse( string $s ) : array {
		return json_decode( $this->cleanResponse( $s ), true );
	}

	private function getRequest( string $path ) : array {
		return $this->getArrayFromResponse(
			$this->site->getRequest( $path )
		);
	}

	/**
	 * @param string $changeId example 447080
	 * @return array
	 */
	public function getFromUrlId( string $changeId ) : array {
		return $this->getRequest( '/r/changes/' . $changeId );
	}

	/**
	 * @param string $fullId example I440dcfbca16c7589723971f69ed0a7e7b1306630
	 * @return array
	 */
	public function getFromFullId( string $fullId ) : array {
		return $this->getRequest( '/r/changes/?q=change:' . $fullId );
	}

	/**
	 * @param string $numChangeId
	 * @return array
	 */
	public function inFromUniqueId( string $numChangeId ) : array {
		return $this->getRequest( '/r/changes/' . $numChangeId . '/in');
	}

	/**
	 * @param string $ticketID example T12345
	 * @return array
	 */
	public function getFromPhabricatorID( string $ticketID ) : array {
		return $this->getRequest( '/r/changes/?q=bug:' . $ticketID );
	}

}

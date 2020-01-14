<?php

namespace Addtool\Wikimedia\Gerrit\Utility;

class UrlChangeIdExtractor {

	/**
	 * @param string $url Example: https://gerrit.wikimedia.org/r/#/c/mediawiki/extensions/WikibaseLexeme/+/463980/
	 * @throws UrlChangeIdExtractorException if failed to extract
	 * @return string
	 */
	public function getChangeId( string $url ) : string {
		$regexSuccess = preg_match( '/[0-9]+/', $url, $matches );
		if ( $regexSuccess && array_key_exists( 0, $matches ) ) {
			return $matches[0];
		}
		throw new UrlChangeIdExtractorException( 'Failed to get change id from ' . $url );
	}

}

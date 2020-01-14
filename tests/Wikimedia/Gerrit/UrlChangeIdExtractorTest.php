<?php

namespace Addtool\Tests\Wikimedia\Gerrit;

use Addtool\Wikimedia\Gerrit\Utility\UrlChangeIdExtractor;
use PHPUnit\Framework\TestCase;

class UrlChangeIdExtractorTest  extends TestCase {

	public function provide() {
		return [
			[
				'https://gerrit.wikimedia.org/r/#/c/mediawiki/extensions/Wikibase/+/447080/',
				'447080'
			],
			[
				'https://gerrit.wikimedia.org/r/#/c/mediawiki/extensions/Wikibase/+/447080/2/repo/includes/ParserOutput/EntityParserOutputGenerator.php',
				'447080'
			]
		];
	}

	/**
	 * @dataProvider provide
	 */
	public function testExtraction( $url, $expected ) {
		$e = new UrlChangeIdExtractor();
		$r = $e->getChangeId( $url );
		$this->assertEquals( $expected, $r );
	}

}

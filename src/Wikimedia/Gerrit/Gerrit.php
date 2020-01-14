<?php

namespace Addtool\Wikimedia\Gerrit;

use Addtool\SimpleCache\CachedSite;
use Addtool\SimpleCache\SimpleCache;

class Gerrit extends CachedSite {

	public function __construct( SimpleCache $simpleCache ) {
		parent::__construct( "https://gerrit.wikimedia.org", $simpleCache );
	}
}

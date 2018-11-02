<?php

namespace Addtool;

use Pimple\Container;

class Services extends Container {

	public function __construct() {
		$wiring = require __DIR__ . DIRECTORY_SEPARATOR . 'ServiceWiring.php';
		parent::__construct( $wiring );
	}

}

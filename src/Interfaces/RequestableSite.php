<?php

namespace Addtool\Interfaces;

interface RequestableSite {

	/**
	 * @param string $path Example: /r/changes/1234
	 * @return bool|false|string
	 */
	public function getRequest( string $path );

}
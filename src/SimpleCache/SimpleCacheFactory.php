<?php

namespace Addtool\SimpleCache;

class SimpleCacheFactory {

	/**
	 * @param int $ttl for cached items in seconds
	 * @return SimpleCache
	 */
	public function newSimpleCache( $ttl ) {
		$o = new SimpleCache();

		// Path to cache folder (with trailing /)
		$o->cache_path = __DIR__ . '/../../cache/';
		// Length of time to cache a file (in seconds)
		$o->cache_time = $ttl;
		// Cache file extension
		$o->cache_extension = '.cache';

		return $o;
	}

}

<?php

namespace Addtool\SimpleCache;

class SimpleCache extends \Gilbitron\Util\SimpleCache {

	/**
	 * Helper function for retrieving data from url
	 * @param $url
	 * @return bool|mixed|string
	 */
	public function do_curl($url)
	{
		if(function_exists("curl_init")){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_USERAGENT, "tools.wmflabs.org/add");
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			$content = curl_exec($ch);
			curl_close($ch);
			return $content;
		} else {
			return file_get_contents($url);
		}
	}

}

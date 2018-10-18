<?php

require_once __DIR__ . '/vendor/autoload.php';

dispatch('/', 'hello');
function hello()
{
	return 'Hello world!';
}
run();

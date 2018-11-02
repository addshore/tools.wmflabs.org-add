<?php

namespace Addtool\Slim\UseCases\HelloWorld;

use Slim\Http\Request;
use Slim\Http\Response;

class RequestHandler implements \Addtool\Slim\RequestHandler {

	public function handle( Request $request, Response $response, array $args ) {
		$response->getBody()->write("Hello, " . $args['name'] . '.');
	}
}

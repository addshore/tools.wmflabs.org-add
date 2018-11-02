<?php

namespace Addtool\Slim;

use Slim\Http\Request;
use Slim\Http\Response;

class IsItDeployed implements RequestHandler {

	public function handle(Request $request, Response $response, array $args) {
		$response->getBody()->write("Maybe...");
	}

}
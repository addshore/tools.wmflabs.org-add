<?php

namespace Addtool\Slim;

use Slim\Http\Request;
use Slim\Http\Response;

interface RequestHandler {

	public function handle( Request  $request, Response $response, array $args);

}

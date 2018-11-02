<?php

namespace Addtool\Slim;

use Slim\Http\Request;
use Slim\Http\Response;
use erasys\OpenApi\Spec\v3 as OASv3;

class OpenApiSpec implements RequestHandler {

	private $document;

	public function __construct( OASv3\Document $document ) {
		$this->document = $document;
	}

	public function handle( Request $request, Response $response, array $args ) {
		return $response->withJson( $this->document->toArray() );
	}

}

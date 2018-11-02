<?php

namespace Addtool\Slim;

use Addtool\Wikimedia\Gerrit\ChangesFetcher;
use Slim\Http\Request;
use Slim\Http\Response;

class ChangesFromBug implements RequestHandler {

	private $changesFetcher;

	public function __construct( ChangesFetcher $changesFetcher ) {
		$this->changesFetcher = $changesFetcher;
	}

	public function handle( Request $request, Response $response, array $args ) {
		$ticketId = $args['bug'];

		$allChanges = $this->changesFetcher->getFromPhabricatorID( $ticketId );

		var_dump($allChanges);

		$response->withJson($allChanges);
	}
}

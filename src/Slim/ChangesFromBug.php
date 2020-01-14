<?php

namespace Addtool\Slim;

use Addtool\Wikimedia\Gerrit\Services\Changes;
use Slim\Http\Request;
use Slim\Http\Response;

class ChangesFromBug implements RequestHandler {

	private $gerritChanges;

	public function __construct( Changes $gerritChanges ) {
		$this->gerritChanges = $gerritChanges;
	}

	public function handle( Request $request, Response $response, array $args ) {
		$ticketId = $args['bug'];

		$allChanges = $this->gerritChanges->getFromPhabricatorID( $ticketId );

		$changesIds = [];
		foreach ( $allChanges as $change ) {
			if (array_key_exists( 'id', $change ) ) {
				$changesIds[] = $change['id'];
			}
		}

		$response->withJson($changesIds);
	}
}

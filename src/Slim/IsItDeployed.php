<?php

namespace Addtool\Slim;

use Addtool\Wikimedia\Gerrit\UrlChangeIdExtractor;
use Slim\Http\Request;
use Slim\Http\Response;

class IsItDeployed implements RequestHandler {

	private $changeIdExtractor;

	public function __construct(
		UrlChangeIdExtractor $changeIdExtractor
	)
	{
		$this->changeIdExtractor = $changeIdExtractor;
	}

	public function handle(Request $request, Response $response, array $args) {
		$gerritUrl = $args['gerriturl'];
		$changeId = $this->changeIdExtractor->getChangeId( $gerritUrl );

		$response->getBody()->write("Maybe... " . $changeId);
	}

}
<?php

namespace Addtool\Slim;

use Addtool\Wikimedia\Gerrit\Services\Changes;
use Addtool\Wikimedia\Gerrit\Utility\UrlChangeIdExtractor;
use Addtool\Wikimedia\Noc\Services\WikiVersions;
use Slim\Http\Request;
use Slim\Http\Response;

class WhereIsItDeployed implements RequestHandler {

	private $gerritChangeIdExteractor;
	private $gerritChanges;
	private $nocWikiVersions;

	public function __construct(
		UrlChangeIdExtractor $gerritChangeIdExteractor,
		Changes $gerritChanges,
		WikiVersions $nocWikiVersions
	) {
		$this->gerritChangeIdExteractor = $gerritChangeIdExteractor;
		$this->gerritChanges = $gerritChanges;
		$this->nocWikiVersions = $nocWikiVersions;
	}

	public function handle(Request $request, Response $response, array $args) {
		$gerritUrl = $args['gerriturl'];

		// Go from a URL to a list of changes
		$changeIdForUrl = $this->gerritChangeIdExteractor->getChangeId( $gerritUrl );
		$fullChangeId = $this->gerritChanges->getFromUrlId( $changeIdForUrl )['change_id'];
		$allChanges = $this->gerritChanges->getFromFullId( $fullChangeId );

		// Get all unique merged change ids
		$uniqueMergedChangeIds = [];
		foreach ( $allChanges as $change ) {
			// Only get merged change ids
			if ( $change['status'] === 'MERGED' ) {
				$uniqueMergedChangeIds[] = $change['id'];
			}
		}

		// Get the list of unique gerrit branches that the changes are on.
		$gerritBranches = [];
		foreach ( $uniqueMergedChangeIds as $uniqueId ) {
			$gerritBranches = array_merge( $gerritBranches, $this->gerritChanges->inFromUniqueId( $uniqueId )['branches'] );
		}
		$gerritBranches = array_unique( $gerritBranches );

		// Get the list of deployed branches
		$wikiBranches = $this->convertWikiVersionsToBranches( $this->nocWikiVersions->get() );

		$result = [
			'gerrit' => [
				'url' => $gerritUrl,
				'@change-id' => 'Full change id',
				'change-id' => $fullChangeId,
				'@ids' => 'Merged unique gerrit ids',
				'ids' => $uniqueMergedChangeIds,
			],
			'sites' => []
		];
		foreach ( $wikiBranches as $dbname => $branch ) {
			if ( in_array( $branch, $gerritBranches ) ) {
				$result['sites'][] = $dbname;
			}
		}

		$response = $response->withJson( $result );
		return $response;
	}

	/**
	 * Switch from php- prefixes to wmf/ prefixes
	 * @param array $wikiVersions
	 * @return array
	 */
	private function convertWikiVersionsToBranches( array $wikiVersions ) : array {
		$wikiBranches = [];
		foreach ( $wikiVersions as $dbname => $version ) {
			$wikiBranches[$dbname] = str_replace( 'php-', 'wmf/', $version );
		}
		return $wikiBranches;
	}

}

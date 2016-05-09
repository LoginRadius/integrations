<?php

require_once '../../config/config.php';
require_once '../lib/livefyre/Livefyre.php';
use Livefyre\Livefyre;

if( ! empty( $_POST['title'] ) && ! empty( $_POST['articleId'] ) && ! empty( $_POST['url'] ) ) {
	$network = Livefyre::getNetwork( LIVEFYRE_NETWORK , LIVEFYRE_NETWORK_KEY );
	$site = $network->getSite( LIVEFYRE_SITE_ID, LIVEFYRE_SITE_KEY );
	$collection = $site->buildCommentsCollection( $_POST['title'], $_POST['articleId'], $_POST['url'] );
	
	// Optional Tags
	//$collection->getData()->setTags("tags");

	$collectionMetaToken = $collection->buildCollectionMetaToken();
	$checksum = $collection->buildChecksum();

	die( json_encode( array( 'collectionMetaToken' => $collectionMetaToken, 'checksum' => $checksum ) ) );
} else {
	$error = "Error retrieving collectionMetaToken";
	die( json_encode( array( 'error' => $error ) ) );
}
?>
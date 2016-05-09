<?php

require_once '../../config/config.php';
require_once '../lib/livefyre/Livefyre.php';
use Livefyre\Livefyre;

if( ! empty( $_POST['userId'] ) && ! empty( $_POST['displayName'] ) ) {

	$network = Livefyre::getNetwork( LIVEFYRE_NETWORK , LIVEFYRE_NETWORK_KEY );
	$userAuthToken = $network->buildUserAuthToken( $_POST['userId'], $_POST['displayName'], SESSION_EXPIRATION );
	die( json_encode( array( 'userAuthToken' => $userAuthToken ) ) );
} else {
	$error = "Error retrieving authToken";
	die(  json_encode( array( 'error' => $error ) ) );
}
?>
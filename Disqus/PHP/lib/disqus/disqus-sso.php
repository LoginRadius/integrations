<?php
// Start session if needed
if( ! session_id() ) {
    session_start();
}
define('__ROOT__', dirname( dirname( dirname(__FILE__) ) ) );
require_once(__ROOT__.'\config.php');
require_once(__ROOT__.'\lib\loginradius\LoginRadiusSDK.php');


if( ! empty( $_POST['token'] ) ) {
    
    $token = $_POST['token'];
    $loginRadiusObject = new LoginRadius();

    // Try to get user profile data using LoginRadius PHP SDK
    try {
        $response = $loginRadiusObject->loginradius_get_user_profiledata( $token );

    } catch ( LoginException $e ) {
        $response = null;
        // Return error message
        die('Error getting profile data');
    }

    // Save user data from response
    $data = array(
        "id" => ! empty( $response->ID ) ? $response->ID : '',
        "username" => ! empty( $response->FullName ) ? $response->FullName : '',
        "email" => ! empty( $response->Email[0]->Value ) ? $response->Email[0]->Value : '',
        "avatar" => ! empty( $response->ThumbnailImageUrl ) ? $response->ThumbnailImageUrl : '',//Avatar - (Optional)
        "url" => ! empty( $response->ProfileUrl ) ? $response->ProfileUrl : ''//Users website url (Optional)
    );
    
    // Hmac generator (Disqus Function)
    function dsq_hmacsha1( $data, $key ) {
        $blocksize=64;
        $hashfunc='sha1';
        if (strlen($key)>$blocksize)
            $key=pack('H*', $hashfunc($key));
        $key=str_pad($key,$blocksize,chr(0x00));
        $ipad=str_repeat(chr(0x36),$blocksize);
        $opad=str_repeat(chr(0x5c),$blocksize);
        $hmac = pack(
                    'H*',$hashfunc(
                        ($key^$opad).pack(
                            'H*',$hashfunc(
                                ($key^$ipad).$data
                            )
                        )
                    )
                );
        return bin2hex($hmac);
    }
    
    // Save Disqus variables needed for login
    $_SESSION['message'] = base64_encode(json_encode($data));
    $_SESSION['timestamp'] = time();
    $_SESSION['hmac'] = dsq_hmacsha1( $_SESSION['message'] . ' ' . $_SESSION['timestamp'], DISQUS_SECRET_KEY );

    // Return user data in die to end AJAX call
    die( $data );
}

?>
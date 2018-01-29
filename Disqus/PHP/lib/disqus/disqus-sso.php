<?php
// Start session if needed
if (!session_id()) {
    session_start();
}
define('__ROOT__', dirname(dirname(dirname(__FILE__))));
require_once(__ROOT__ . '/config.php');
require_once(__ROOT__ . '/lib/loginradius/LoginRadiusSDK/Utility/Functions.php');
require_once(__ROOT__ . '/lib/loginradius/LoginRadiusSDK/LoginRadiusException.php');
require_once(__ROOT__ . '/lib/loginradius/LoginRadiusSDK/Clients/IHttpClient.php');
require_once(__ROOT__ . '/lib/loginradius/LoginRadiusSDK/Clients/DefaultHttpClient.php');
require_once(__ROOT__ . '/lib/loginradius/LoginRadiusSDK/CustomerRegistration/Social/SocialLoginAPI.php');


use \LoginRadiusSDK\Utility\Functions;
use \LoginRadiusSDK\LoginRadiusException;
use \LoginRadiusSDK\Clients\IHttpClient;
use \LoginRadiusSDK\Clients\DefaultHttpClient;
use \LoginRadiusSDK\CustomerRegistration\Social\SocialLoginAPI;

if (!empty($_REQUEST['token'])) {

    $token = $_REQUEST['token'];
    $socialLoginObject = new SocialLoginAPI(LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

    // Try to get user profile data using LoginRadius PHP SDK
    try {

        $response = $socialLoginObject->getUserProfiledata($token);
    } catch (LoginException $e) {
        $response = null;
        // Return error message
        die('Error getting profile data');
    }

    // Save user data from response
    $data = array(
        "id" => !empty($response->ID) ? $response->ID : '',
        "username" => !empty($response->FullName) ? $response->FullName : '',
        "email" => !empty($response->Email[0]->Value) ? $response->Email[0]->Value : '',
        "avatar" => !empty($response->ThumbnailImageUrl) ? $response->ThumbnailImageUrl : '', //Avatar - (Optional)
        "url" => !empty($response->ProfileUrl) ? $response->ProfileUrl : ''//Users website url (Optional)
    );

    // Hmac generator (Disqus Function)
    function dsq_hmacsha1($data, $key) {
        $blocksize = 64;
        $hashfunc = 'sha1';
        if (strlen($key) > $blocksize)
            $key = pack('H*', $hashfunc($key));
        $key = str_pad($key, $blocksize, chr(0x00));
        $ipad = str_repeat(chr(0x36), $blocksize);
        $opad = str_repeat(chr(0x5c), $blocksize);
        $hmac = pack(
                'H*', $hashfunc(
                        ($key ^ $opad) . pack(
                                'H*', $hashfunc(
                                        ($key ^ $ipad) . $data
                                )
                        )
                )
        );
        return bin2hex($hmac);
    }

    // Save Disqus variables needed for login
    $_SESSION['message'] = base64_encode(json_encode($data));
    $_SESSION['timestamp'] = time();
    $_SESSION['hmac'] = dsq_hmacsha1($_SESSION['message'] . ' ' . $_SESSION['timestamp'], DISQUS_SECRET_KEY);
    if (LR_HOSTED_PAGE) {
        ?><script>
            window.close();
        </script><?php
    }
    // Return user data in die to end AJAX call
    die();
}
<?php

require 'facebook-php-sdk/src/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '604681699561069',
  'secret' => 'b31b75bfc478a7c4ba691b02a7a67095',
));

$user = $facebook->getUser();

if (!$user) {
    header( 'Location: login.php' );
}


// We have a user ID, so probably a logged in user.
// If not, we'll get an exception, which we handle below.
try {
$fql = 'SELECT name from user where uid = ' . $user;
$ret_obj = $facebook->api(array(
                           'method' => 'fql.query',
                           'query' => $fql,
                         ));

// FQL queries return the results in an array, so we have
//  to get the user's name from the first element in the array.
echo '<pre>Name: ' . $ret_obj[0]['name'] . '</pre>';

} catch(FacebookApiException $e) {
// If the user is logged out, you can have a 
// user ID even though the access token is invalid.
// In this case, we'll get an exception, so we'll
// just ask the user to login again here.
$login_url = $facebook->getLoginUrl(); 
echo 'Please <a href="' . $login_url . '">login.</a>';
error_log($e->getType());
error_log($e->getMessage());
}   

$facebook->setExtendedAccessToken();

?>

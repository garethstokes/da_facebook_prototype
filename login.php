<?php

require 'facebook-php-sdk/src/facebook.php';


// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '604681699561069',
  'secret' => 'b31b75bfc478a7c4ba691b02a7a67095',
));


// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
    $params = array(
      'scope' => 'read_stream, friends_likes',
      'redirect_uri' => 'http://localhost:8000/auth.php'
    );
    $loginUrl = $facebook->getLoginUrl($params);
}
?>

<html>
    <body>
        <?php if($user) : ?>
            <a href='<?= $logoutUrl ?>'>logout to facebook</a>
        <?php else: ?>
            <a href='<?= $loginUrl ?>'>login to facebook</a>
        <?php endif ?>
    </body>
</html>

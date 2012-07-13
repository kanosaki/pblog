<?php
require_once '../lib/common.php';
header('Content-type: application/json');

// $callback_url = absolute_url("actions/twitter-callback.php");
if(!isset($_SERVER['HTTP_HOST'])){
    echo "ERROR: You must acces this page by browser.";
}
$callback_url = absolute_url("actions/twitter-callback.php");

if(isset($_SERVER['HTTP_REFERER'])){
    $_SESSION['before_oauth'] = $_SERVER['HTTP_REFERER'];
} else {
    $_SESSION['before_oauth'] = "index.html";
}
require_once('../lib/twitteroauth.php');

$connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET);

/* Get temporary credentials. */
$request_token = $connection->getRequestToken($callback_url);
/* Save temporary credentials to session. */
$token = $request_token['oauth_token'];
$secret= $request_token['oauth_token_secret'];

/* If last connection failed don't display authorization link. */
switch ($connection->http_code)
{
case 200:
    /* Build authorize URL and redirect user to Twitter. */
    $twitter_url = $connection->getAuthorizeURL($token);
    $twitter_msg = "Ready for Twitter";
    $status = 'OK';
    break;

default:
    /* Show notification if something went wrong. */
    $twitter_url = "#";
    $status = $connection->http_code;
    $twitter_msg = 'Could not connect to Twitter. Refresh the page or try again later.';
}

echo json_encode(array(
    'status'    => $status,
    'request_url' => $twitter_url,
    'message'   => $twitter_msg
));

?>

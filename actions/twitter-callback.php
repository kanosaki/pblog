<?php
require_once '../lib/common.php';

// Send the user back to the last page.
if(isset($_SESSION['before_oauth'])){
    $send_back = $_SESSION['before_oauth'];
} else {
    $send_back = absolute_url("../index.php");
}
header("Locale: $send_back");


$oauth_token = $_GET['oauth_token'];
$oauth_verifier = $_GET['oauth_verifier'];

?>

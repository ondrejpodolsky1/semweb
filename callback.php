<?php
require_once "config.php";

   
if (isset($_GET['code'])) {
    $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $token;
} else {
    header('Location: login.php');
    exit();
}


$oAuth = new Google_Service_Oauth2($gClient);
$userData = $oAuth->userinfo_v2_me->get();

$_SESSION['email'] = $userData['email'];

header('Location: index.php');
exit();
?>
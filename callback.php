<?php
require_once "config.php";

   
if (isset($_GET['code'])) {
    $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $token;
} else {
    header('Location: prihlaseni.php');
    exit();
}


$oAuth = new Google_Service_Oauth2($gClient);
$userData = $oAuth->userinfo_v2_me->get();

$_SESSION['email'] = $userData['email'];
$_SESSION['normal-prihlasen'] = 'ano';
$_SESSION['admin'] = 'ne';
$_SESSION['glogin'] = 'ano';

$_SESSION['gprijmeni'] = $userData['familyName'];
$_SESSION['gjmeno'] = $userData['givenName'];
header('Location: index.php');
exit();
?>
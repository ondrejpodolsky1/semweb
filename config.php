<?php
session_start();
require_once "GoogleAPI/vendor/autoload.php";
$gClient = new Google_Client();
$gClient->setClientId("156814683795-ohodsf8hobqn22roh583ir9a5nhdit03.apps.googleusercontent.com");
$gClient->setClientSecret("M9E67QdAL6KNq0i4syIh4XtY");
$gClient->setApplicationName("GOOGLE LOGIN semprace");
$gClient->setRedirectUri("https://eso.vse.cz/~podo01/sem/callback.php");
$gClient->addScope("https://www.googleapis.com/auth/plus.login");
$gClient->addScope("https://www.googleapis.com/auth/userinfo.email");


?>
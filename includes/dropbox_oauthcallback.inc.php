<?php
require_once 'dropbox_oauth.inc.php';
require_once 'functions.inc.php';
require_once 'dbh.inc.php';


if (isset($_GET['code']) && isset($_GET['state'])) {  
    
    //Bad practice! No input sanitization!
    $code = $_GET['code'];
    $state = $_GET['state'];

    //Fetch the AccessToken
    $credentials = $authHelper->getAccessToken($code, $state, $callbackUrl);
    
    // Insert data into db
    $userId = $_SESSION['userid'];
    $accessToken = $credentials->getToken();
    $expires = 14400;
    $created = time();

    insertDropboxCredentials($conn, $userId, $accessToken, $expires, $created, "Dropbox");
}

// Local
$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/Projects/SeniorDesign/Development/includes/dropbox_oauth.inc.php';

// Production
$redirect_uri = "https://ez-drive.herokuapp.com/includes/dropbox_oauth.inc.php";

header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));


?>
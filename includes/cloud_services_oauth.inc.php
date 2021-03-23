<?php 
session_start();
require_once dirname(__DIR__, 1) .'/vendor/autoload.php'; 
require_once 'functions.inc.php';
require_once 'dbh.inc.php';

$userId = $_SESSION['userid'];

// The first three statements are for the "connect" buttons on the homepage
if (isset($_POST['googledriveconnect'])){
    require_once 'google_drive_oauth.inc.php';
}
if (isset($_POST['dropboxconnect'])){
    require_once 'dropbox_oauth.inc.php';
    $authUrl = $authHelper->getAuthUrl($callbackUrl);
    echo $authUrl;
    exit();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
}
if (isset($_POST['onedriveconnect'])){
    // OneDrive API is not fully setup yet
    require_once 'onedrive_oauth.inc.php';
}
 
// The second three statements are for the disconnect buttons for each cloud service
if (isset($_POST['googledrive-disconnect'])){
    $serviceType = "GoogleDrive";
    deleteCloudServiceCredentials($conn, $userId, $serviceType);
}
if (isset($_POST['dropbox-disconnect'])){
    $serviceType = "Dropbox";
    deleteCloudServiceCredentials($conn, $userId, $serviceType);
}
if (isset($_POST['onedrive-disconnect'])){
    $serviceType = "OneDrive";
    deleteCloudServiceCredentials($conn, $userId, $serviceType);
}

// The last three statements are for the checkboxes on the uploads page
if (isset($_POST["submit"])) {
    if (isset($_POST["cbgoogledrive"])) {
        require_once 'google_drive_oauth.inc.php';
    } 
    if (isset($_POST["cbdropbox"])) {
        require_once 'dropbox_oauth.inc.php';
        $authUrl = $authHelper->getAuthUrl($callbackUrl);
        header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    } 
    if (isset($_POST["cbonedrive"])) {
        // OneDrive API is not fully setup yet
        require_once 'onedrive_oauth.inc.php';
    } 
} 

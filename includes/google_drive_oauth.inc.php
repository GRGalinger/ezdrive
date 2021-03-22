<?php 

require_once dirname(__DIR__, 1) .'/vendor/autoload.php';
require_once 'functions.inc.php';
require_once 'dbh.inc.php';
session_start(); 

if (!file_exists("client_id_google_drive.json")) exit("Client secret file not found");
$client = new Google_Client();
$client->setAuthConfig('client_id_google_drive.json');
$client->addScope(Google_Service_Drive::DRIVE);

$userId = $_SESSION['userid'];
$row = getUserCredentials($conn, $userId, "google_credentials");

if ($row != false){ // A row was returned, so this user has been authenticated before and has credentials
  $client->setAccessToken($row['accessToken']); // This line is vital

  // Now, we check if the access token is expired
  if (checkAccessToken($conn, $row['created'], $row['expires'])){
    $client->fetchAccessTokenWithRefreshToken($row['refreshToken']);
    $accessToken = $client->getAccessToken();
    updateAccessToken($conn, $userId, $accessToken['access_token']);
  } 

  if (dir_is_empty('../uploads/')) {
    header("location: ../home.php");
    exit;
  }

  // Once access token is updated, or if it wasnt expired, proceed with upload
  $drive_service = new Google_Service_Drive($client);
  $file = new Google_Service_Drive_DriveFile();
  $file->setDescription('A test document');
  $file->setMimeType('image/jpeg'); // TODO: figure out what Mime types i need to have set??

  // This is where we upload the files //
  $dir = new DirectoryIterator('../uploads/');
  foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
      $data = file_get_contents('../uploads/' . $fileinfo->getFilename());
      $file->setName($fileinfo->getFilename());
      try {
        $createdFile = $drive_service->files->create($file, array(
          'data' => $data,
          'mimeType' => 'image/jpeg', 
          'uploadType' => 'multipart'
        ));
      } catch (Exception $exc) {
        echo $exc->getMessage() . "\n";
      }
    }
  }

  if (!isset($_POST["cbdropbox"]) && !isset($_POST["cbonedrive"])) {
    header("location: ../results.php");
}

} else {  // A row was not returned, so this user has not been authenticated before
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/Projects/SeniorDesign/Development/includes/google_drive_oauthcallback.inc.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}




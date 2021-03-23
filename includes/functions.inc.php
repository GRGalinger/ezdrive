<?php 

function emptyInputsSignup($name, $email, $username, $pwd, $pwdRepeat) {
    $result;
    if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    } else { $result = false; }
    return $result;
}

function emptyInputsEditInfo($name, $email, $username) {
    $result;
    if (empty($name) || empty($email) || empty($username)) {
        $result = true;
    } else { $result = false; }
    return $result;
}

function invalidUid($username) {
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else { $result = false; }
    return $result;
}

function invalidEmail($email) {
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else { $result = false; }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat) {
    $result;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    } else { $result = false; }
    return $result;
}

function uidExistsEditInfo($conn, $username) {
    $sql = "SELECT * FROM users WHERE usersUid = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultsData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultsData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultsData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultsData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $email, $username, $pwd) {
    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) 
        VALUES (?, ?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../login.php");
    exit();
}

function emptyInputsLogin($username, $pwd) {
    $result;
    if (empty($username) || empty($pwd)) {
        $result = true;
    } else { $result = false; }
    return $result;
}

function loginUser($conn, $username, $pwd) {
    
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    // Password user provided is not the same as the password in the db
    if ($checkPwd === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    else if ($checkPwd === true) {
        session_start();
        $_SESSION["userid"] = $uidExists["usersId"];
        $_SESSION["useruid"] = $uidExists["usersUid"];
        
        clearUploads();
        header("location: ../home.php");
        // exit();

    }
}

function getHomePageUserInfo($conn, $usersId){
    $sql = "SELECT usersName, usersEmail, usersUid FROM users WHERE usersId = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        //header("location: ../signup.php?error=stmtfailed"); // TODO: This header needs changed
    }

    mysqli_stmt_bind_param($stmt, "i", $usersId);
    mysqli_stmt_execute($stmt);

    $resultsData = mysqli_stmt_get_result($stmt);

    // If row is returned, then the logged in user aligns with the credentials file
    if ($row = mysqli_fetch_assoc($resultsData)) {
        mysqli_stmt_close($stmt);
        return $row;
    } else { 
        $result = false;
        mysqli_stmt_close($stmt);
        return $result;
    }
}

function getHomePageCloudServiceInfo($conn, $usersId){
    $sql = "SELECT u.usersId, g.serviceType AS googledrive, d.serviceType AS dropbox, o.serviceType AS onedrive
            FROM users u
            LEFT JOIN google_credentials g ON g.usersId = u.usersId
            LEFT JOIN dropbox_credentials d ON d.usersId = u.usersId
            LEFT JOIN onedrive_credentials o ON o.usersId = u.usersId
            WHERE u.usersId = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        //header("location: ../signup.php?error=stmtfailed"); // TODO: This header needs changed
    }

    mysqli_stmt_bind_param($stmt, "i", $usersId);
    mysqli_stmt_execute($stmt);

    $resultsData = mysqli_stmt_get_result($stmt);

    // If row is returned, then the logged in user aligns with the credentials file
    if ($row = mysqli_fetch_assoc($resultsData)) {
        mysqli_stmt_close($stmt);
        return $row;
    } else { 
        $result = false;
        mysqli_stmt_close($stmt);
        return $result;
    }
}

function getHomePageGoogleDriveInfo($conn, $usersId){
    $sql = "SELECT * FROM google_credentials WHERE usersId = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        //header("location: ../signup.php?error=stmtfailed"); // TODO: This header needs changed
    }

    mysqli_stmt_bind_param($stmt, "i", $usersId);
    mysqli_stmt_execute($stmt);

    $resultsData = mysqli_stmt_get_result($stmt);

    // If row is returned, then the logged in user aligns with the credentials file
    if ($row = mysqli_fetch_assoc($resultsData)) {
        mysqli_stmt_close($stmt);
        return $row;
    } else { 
        $result = false;
        mysqli_stmt_close($stmt);
        return $result;
    }
}

function updateUserInfo($conn, $usersId, $name, $email, $username, $pwd, $pwdChanged = false){

    
    if ($pwdChanged) {
        $sql = "UPDATE users SET usersName = ?, usersEmail = ?, usersUid = ?, usersPwd = ? WHERE usersId = ?;";
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
        
    } else  {
        $sql = "UPDATE users SET usersName = ?, usersEmail = ?, usersUid = ? WHERE usersId = ?;";
    }
    
    
    $stmt = mysqli_stmt_init($conn);
    

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        //header("location: ../edituserinfo.php?error=stmtfailed"); 
        echo "failed";
        exit();
    }

    if ($pwdChanged) {
        mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $username, $hashedPwd, $usersId);
    } else {
        mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $username, $usersId);
    }
    
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../home.php"); 
    exit();
}

function clearUploads(){
    array_map('unlink', array_filter( 
        (array) array_merge(glob("../uploads/*")))
    ); 
}

function filesizeFormatted($path)
{
    $size = filesize($path);
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}

function dir_is_empty($dir) {
    $handle = opendir($dir);
    while (false !== ($entry = readdir($handle))) {
      if ($entry != "." && $entry != "..") {
        closedir($handle);
        return FALSE;
      }
    }
    closedir($handle);
    return TRUE;
  }

function deleteCloudServiceCredentials($conn, $usersId, $serviceType){
    if ($serviceType == "GoogleDrive") {$sql = "DELETE FROM google_credentials WHERE usersId = ?;";}
    elseif ($serviceType == "Dropbox") { $sql = "DELETE FROM dropbox_credentials WHERE usersId = ?;";}
    else { $sql = "DELETE FROM onedrive_credentials WHERE usersId = ?;";}

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        //header("location: ../signup.php?error=stmtfailed");
        echo "failed";
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $usersId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../home.php");
    exit();
}

  // this is google credentials, need to update function name
function insertGoogleCredentials($conn, $usersId, $accessToken, $expires, $scope, $tokenType, $created, $refreshToken, $serviceType) {
    $sql = "INSERT INTO google_credentials (usersId, accessToken, expires, scope, tokenType, created, refreshToken, serviceType) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        //header("location: ../signup.php?error=stmtfailed");
        echo "failed";
        exit();
    }

    mysqli_stmt_bind_param($stmt, "isississ", $usersId, $accessToken, $expires, $scope, $tokenType, $created, $refreshToken, $serviceType);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "here";
    exit();
    //header("location: ../signup.php?error=none");
}

function insertDropboxCredentials($conn, $usersId, $accessToken, $expires, $created, $serviceType) {
    $sql = "INSERT INTO dropbox_credentials (usersId, accessToken, expires, created, serviceType) 
        VALUES (?, ?, ?, ?, ?);";
   
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        //header("location: ../signup.php?error=stmtfailed");
        echo "failed";
        exit();
    }

    mysqli_stmt_bind_param($stmt, "isiis", $usersId, $accessToken, $expires, $created, $serviceType);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function insertOneDriveCredentials($conn, $usersId, $accessToken, $expires, $scope, $tokenType, $created, $refreshToken, $serviceType) {
    $sql = "INSERT INTO onedrive_credentials (usersId, accessToken, expires, scope, tokenType, created, refreshToken, serviceType) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        //header("location: ../signup.php?error=stmtfailed");
        echo "failed";
        exit();
    }

    mysqli_stmt_bind_param($stmt, "isississ", $usersId, $accessToken, $expires, $scope, $tokenType, $created, $refreshToken, $serviceType);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    //header("location: ../signup.php?error=none");
}

function getUserCredentials($conn, $usersId, $dbName){

    if ($dbName == "google_credentials"){
        $sql = "SELECT * FROM google_credentials WHERE usersId = ?;";
    } else if ($dbName == "dropbox_credentials"){
        $sql = "SELECT * FROM dropbox_credentials WHERE usersId = ?;";
    } else if ($dbName == "onedrive_credentials") {
        $sql = "SELECT * FROM onedrive_credentials WHERE usersId = ?;";
    }

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        //header("location: ../signup.php?error=stmtfailed"); // TODO: This header needs changed
    }

    mysqli_stmt_bind_param($stmt, "i", $usersId);
    mysqli_stmt_execute($stmt);

    $resultsData = mysqli_stmt_get_result($stmt);

    // If row is returned, then the logged in user aligns with the credentials file
    if ($row = mysqli_fetch_assoc($resultsData)) {
        mysqli_stmt_close($stmt);
        return $row;
    } else { 
        $result = false;
        mysqli_stmt_close($stmt);
        return $result;
    }

}

function verifyCredentials($conn, $usersId, $accessToken){
    $sql = "SELECT * FROM google_credentials WHERE usersId = ? AND accessToken = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        //header("location: ../signup.php?error=stmtfailed"); // TODO: This header needs changed
        exit();
    }

    mysqli_stmt_bind_param($stmt, "is", $usersId, $accessToken);
    mysqli_stmt_execute($stmt);

    $resultsData = mysqli_stmt_get_result($stmt);

    // If row is returned, then the logged in user aligns with the credentials file
    if ($row = mysqli_fetch_assoc($resultsData)) {
        // var_dump($row);
        // exit();
        mysqli_stmt_close($stmt);
        return $row;
    } else { 
        $result = false;
        echo "not the same";
        // exit();
        mysqli_stmt_close($stmt);
        return $result;
    }
}

function updateAccessToken($conn, $usersId, $accessToken){
    $sql = "UPDATE google_credentials SET accessToken = ? WHERE usersId = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        //header("location: ../signup.php?error=stmtfailed"); 
        echo "failed";
        exit();
    }

    mysqli_stmt_bind_param($stmt, "si", $accessToken, $usersId);
    mysqli_stmt_execute($stmt);
    
    mysqli_stmt_close($stmt);
}

function checkAccessToken($conn, $created, $expires){
    $currentTime = time();
    if (($currentTime - $created) >= $expires){
        // access token is expired
        $result = true;
        return $result;
    } else {
        $result = false;
        return $result;
    }
}

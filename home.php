<?php 
    include_once 'header.php';
    require_once 'includes/functions.inc.php';
    require_once 'includes/dbh.inc.php';

    $userId = $_SESSION['userid'];
    $userInfo = getHomePageUserInfo($conn, $userId);
    $usersName = $userInfo['usersName'];
    $usersUid = $userInfo['usersUid'];
    $usersEmail = $userInfo['usersEmail'];
    $googleDriveConnected = "";
    $dropboxConnected = "";
    $onedriveConnected = "";

    // Get homepage cloud service info
    $row = getHomePageCloudServiceInfo($conn, $userId);
    if ($row != false) { 
        if ($row['googledrive'] == 'GoogleDrive') {
            $googleDriveConnected = "Connected";
        } else { $googleDriveConnected = "Awaiting Connection..."; }

        if ($row['dropbox'] == 'Dropbox') {
            $dropboxConnected = "Connected";
        } else { $dropboxConnected = "Awaiting Connection..."; }

        if ($row['onedrive'] == 'OneDrive') {
            $onedriveConnected = "Connected";
        } else { $onedriveConnected = "Awaiting Connection..."; }
    }  
?>

    <div class="container-home"> 
			<div class="box"> 

				<div class="box-row"> 

					<div class="box-cell account-info"> 
                        <form action="includes/edituserinfo.inc.php" method="post">
                            <h1> Account Info </h1>
                            <h3> Name: <?php echo $usersName ?></h3>
                            <hr>
                            <h3> Username: <?php echo $usersUid ?></h3>
                            <hr>
                            <h3> Email: <?php echo $usersEmail ?></h3>
                            <hr>
                            <div class="btn-edit">
                                <button type="submit" name="edit">edit</button>
                            </div>
                            
                        </form>
					</div> 

					<div class="box-cell cloud-services"> 
                        <h1> Cloud Services </h1>
                        <div class="cloud-service">
                            <form action="profile.inc.php">
                                <h3> Google Drive </h3>
                            </form>
                            <div class="connection-status">
                                <?php
                                    if ($googleDriveConnected == "Connected") {
                                        ?> <div class="connected"><h3> <?php echo $googleDriveConnected ?> </h3></div> <?php
                                    } else {
                                        ?> <div class="not-connected"><h3> <?php echo $googleDriveConnected ?> </h3></div><?php
                                    } 
                                ?>
                            </div>
                        </div>
                        <div class="cloud-service">
                            <form action="profile.inc.php">
                                <h3> Dropbox </h3>
                            </form>
                            <div class="connection-status">
                                <?php
                                    if ($dropboxConnected == "Connected") {
                                        ?> <div class="connected"><h3> <?php echo $dropboxConnected ?> </h3></div> <?php
                                    } else {
                                        ?> <div class="not-connected"><h3> <?php echo $dropboxConnected ?> </h3></div><?php
                                    } 
                                ?>
                            </div>
                        </div>
                        <div class="cloud-service">
                            <form action="profile.inc.php">
                                <h3> OneDrive </h3>
                            </form>
                            <div class="connection-status">
                                <?php
                                    if ($onedriveConnected == "Connected") {
                                        ?> <div class="connected"><h3> <?php echo $onedriveConnected ?> </h3></div> <?php
                                    } else {
                                        ?> <div class="not-connected"><h3> <?php echo $onedriveConnected ?> </h3></div><?php
                                    } 
                                ?>
                            </div>
                        </div>
                        
                    </div>
                     
                    <div class="box-cell statuses">
                        <h1> Status </h1>
                        <div class="btn-google-drive">
                            <form action="includes/cloud_services_oauth.inc.php" method="post">
                                <div class="btn-connect">
                                    <input type="submit" name="googledriveconnect" value="Connect"></input>
                                </div>
                                <div class="btn-disconnect">
                                    <button type="disconnect" name="googledrive-disconnect">X</button>
                                </div>
                            </form>
                        </div>

                        <div class="btn-dropbox">
                            <form action="includes/cloud_services_oauth.inc.php" method="post">
                                <div class="btn-connect">
                                    <input type="submit" name="dropboxconnect" value="Connect"></input>
                                </div>
                                <div class="btn-disconnect">
                                    <button type="disconnect" name="dropbox-disconnect">X</button>
                                </div>
                            </form>
                        </div>

                        <div class="btn-onedrive">
                            <form action="includes/cloud_services_oauth.inc.php" method="post">
                                <div class="btn-connect">
                                    <input type="submit" name="onedriveconnect" value="Connect"></input>
                                </div>
                                <div class="btn-disconnect">
                                    <button type="disconnect" name="onedrive-disconnect">X</button>
                                </div>
                            </form>
                        </div>
                    </div>
				</div> 
			</div> 
		</div> 

        <div class="btn-upload">
            <a href="upload.php"><button type="upload">Go to Uploads</button></a>
        </div>
    </div>



<?php 
    include_once 'footer.php';
?>



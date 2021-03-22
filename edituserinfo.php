<?php 
    include_once 'header.php';
    require_once 'includes/functions.inc.php';
    require_once 'includes/dbh.inc.php';

    $userId = $_SESSION['userid'];
    $userInfo = getHomePageUserInfo($conn, $userId);
    $usersName = $userInfo['usersName'];
    $usersUid = $userInfo['usersUid'];
    $usersEmail = $userInfo['usersEmail'];
?>


<div class="container-edituserinfo"> 
    <form action="includes/updateuserinfo.inc.php" method="post">
        <h1> Edit Account Info </h1>

        <label> Full Name: </label>
        <div class="info">
            <input type="text" name="name" value="<?php echo $usersName; ?>">
        </div>

        <label> Username: </label>
        <div class="info">
            <input type="text" name="uid" value="<?php echo $usersUid; ?>">
        </div>

        <label> Email: </label>
        <div class="info">
            <input type="text" name="email" value="<?php echo $usersEmail; ?>">
        </div>

        <label> Password: </label>
        <div class="info">
            <input type="text" name="pwd" placeholder="****">
        </div>

        <label> Confirm: </label>
        <div class="info">
            <input type="text" name="pwdrepeat" placeholder="****">
        </div>

        <div class="btns-edit">
            <button type="submit" name="submit">Submit Changes</button>
            <button type="submit" name="cancel">Cancel</button>
        </div>
            
       
    </form>
</div>
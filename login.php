<?php include_once 'header_login.php'; ?>

<div class="login-message">
    <h1>Welcome to EZ-Drive</h1>
    <p> EZ-Drive is a platform for uploading your files to your favorite cloud services all in one</p> 
</div>

<div class="container-login">
    <div class="login-form">
        <h2>Log In</h2>
        <div class="login-form-form">
            <form action="includes/login.inc.php" method="post">    
            <!-- Files with .inc are not pages that the user will see, but rather a basic php file with a script that runs -->
                <input type="text" name="uid" placeholder="Email/Username...">
                <input type="password" name="pwd" placeholder="Password...">
                <button type="submit" name="submit">Log In</button>
            </form>
        </div>
        <div class="text-signup">
            <a href="signup.php"> <p> sign up </p> </a>
        </div>
        
        <!-- // TODO: style the error messages to display in a good position on screen -->
        <?php
            if (isset($_GET["error"])){
                if ($_GET["error"] == "emptyinput") {
                    echo "<p>Fill in all fields.</p>";
                }
                else if ($_GET["error"] == "wronglogin") {
                    echo "<p>Incorrect login.</p>";
                }
            }
        ?>
    </div>
</div>

<?php include_once 'footer.php';?>



<?php include_once 'header_login.php'; ?>

<div class="signup-message">
    <h1>Welcome to EZ-Drive</h1>
    <p> EZ-Drive is a platform for uploading your files to your favorite cloud services all in one</p> 
</div>

<div class="container-signup">
    <div class="signup-form">
        <h2>Sign Up</h2>
        <form action="includes/signup.inc.php" method="post">    
        <!-- Files with .inc are not pages that the user will see, but rather a basic php file with a script that runs -->
            <input type="text" name="name" placeholder="Full Name...">
            <input type="text" name="email" placeholder="Email...">
            <input type="text" name="uid" placeholder="Username...">
            <input type="password" name="pwd" placeholder="Password...">
            <input type="password" name="pwdrepeat" placeholder="Confirm Password...">
            <button type="submit" name="submit">Sign Up</button>
        </form>
    </div>
    <div class="text-login">
            <a href="login.php"> <p> Log in </p> </a>
    </div>

    <?php
        if (isset($_GET["error"])){
            if ($_GET["error"] == "emptyinput") {
                echo "<p>Fill in all fields.</p>";
            }
            else if ($_GET["error"] == "invaliduid") {
                echo "<p>Choose a proper username.</p>";
            }
            else if ($_GET["error"] == "invalidemail") {
                echo "<p>Choose a proper email.</p>";
            }
            else if ($_GET["error"] == "pwdsdontmatch") {
                echo "<p>Passwords do not match.</p>";
            }
            else if ($_GET["error"] == "stmtfailed") {
                echo "<p>Oops, something went wrong, try again.</p>";
            }
            else if ($_GET["error"] == "usernametaken") {
                echo "<p>Username or email already taken</p>";
            }
            else if ($_GET["error"] == "none") {
                echo "<p>Sign up successful!</p>";
            }
        }
    ?>

</section>

    







<?php include_once 'footer.php';?>



<?php 
    require_once 'functions.inc.php';
    require_once 'dbh.inc.php';
    session_start();

    $userId = $_SESSION['userid'];
    $userInfo = getHomePageUserInfo($conn, $userId);
    $usersName = $userInfo['usersName'];
    $usersUid = $userInfo['usersUid'];
    $usersEmail = $userInfo['usersEmail'];

    // echo $usersName;
    // echo $usersUid;
    // echo $usersEmail;
   
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST["submit"])) {
            
            
            $name = $_POST["name"];
            $username = $_POST["uid"];
            $email = $_POST["email"];
            $pwd = $_POST["pwd"];
            $pwdRepeat = $_POST["pwdrepeat"];

            $pwdChanged = false;



            // echo $name;
            // echo $username;
            // echo $email;
            // echo $pwd;
            // echo $pwdRepeat;

           

            
            if (emptyInputsEditInfo($name, $email, $username) !== false) {
                header("location: ../edituserinfo.php?error=emptyinputs");
                exit();
            }
        
            if (!empty($username) && ($username != $usersUid)) {
                if (invalidUid($username) !== false) {
                    header("location: ../edituserinfo.php?error=invaliduid");
                    exit();
                }
            }
             
            if (!empty($email) && ($email != $usersEmail)) {
                if (invalidEmail($email) !== false) {
                    header("location: ../edituserinfo.php?error=invalidemail");
                    exit();
                }
            }

            if (!empty($username) && ($username != $usersUid)) {
                if (uidExistsEditInfo($conn, $username) !== false) {
                    header("location: ../edituserinfo.php?error=usernametaken");
                    exit();
                }
            }
            
            if (!empty($pwd) || !empty($pwdRepeat)){
                if (pwdMatch($pwd, $pwdRepeat) !== false) {
                    header("location: ../edituserinfo.php?error=pwdsdontmatch");
                    exit();
                }
                $pwdChanged = true;
            }

            updateUserInfo($conn, $userId, $name, $email, $username, $pwd, $pwdChanged);

        } elseif (isset($_POST["cancel"])) {
            header("location: ../home.php");
            exit();
        }
    
    } else {
        header("location: ../login.php");
        exit();
    }


    
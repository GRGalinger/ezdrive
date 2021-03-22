<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST["edit"])) {
        header("location: ../edituserinfo.php");
        exit();
    }
} else {
    header("location: ../login.php");
    exit();
}



        


    

   
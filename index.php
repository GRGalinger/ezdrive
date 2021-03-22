<?php 
    if (!isset($_SESSION['useruid'])) {
        header("location: login.php");
    } 
?>

    

<?php 
    include_once 'footer.php';
?>



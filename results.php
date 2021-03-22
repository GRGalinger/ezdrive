<?php
    include_once 'header.php';
    require_once 'includes/functions.inc.php';
    require_once 'includes/dbh.inc.php';
?>

    <div class="container-results"> 
        <div class="box"> 
            <div class="box-row"> 
                <div class="box-cell upload-summary">
                    <h1> File Upload Summary </h1>
                    <?php
                        $dir = "/uploads";
                        foreach(glob("uploads/*") as $file) { ?>
                            <div class="file-summary">
                                <?php 
                                    $size = filesizeFormatted("uploads/" . basename($file));
                                ?>
                                <h3> <?php print(basename($file) . " - " . $size) ?> </h3>
                            </div>
                            <?php echo "<br>";
                        } 
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="link-images">
        <a href="https://drive.google.com/" target="_blank"><img src="img/googledrive.png"  /></a>
        <a href="https://www.dropbox.com/" target="_blank"><img src="img/dropbox.png"  /></a>
        <a href="https://onedrive.live.com/" target="_blank"><img src="img/onedrive.png"  /></a>
        <h3> Follow links to cloud services </h3>    
    </div>
  

<?php
    //Once files are displayed we can clear the uploads folder
    array_map('unlink', array_filter( 
        (array) array_merge(glob("uploads/*")))
    ); 
?>

    
<?php 
    include_once 'footer.php';
?>

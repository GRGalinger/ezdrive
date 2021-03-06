<?php


function filesize_formatted($path)
{
    $size = filesize($path);
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}

foreach(glob("uploads/*") as $file) {
    // $filesize = filesize("uploads/" . basename($file));
    $size = filesize_formatted("uploads/" . basename($file));
    echo $size;

}


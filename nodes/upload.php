<?php
if (isset($_POST['imgURI'])) {

    define('UPLOAD_DIR', 'upload/');//to save image files
    $imageData=$_POST['imgURI'];
    $filteredData=substr($imageData, strpos($imageData, ",")+1);
    $unencodedData=base64_decode($filteredData);
    $fileName = 'download/'.uniqid().'.png';
    $fp = fopen($fileName, 'wb' );
    fwrite( $fp, $unencodedData);
    fclose( $fp );
    echo $fileName;
}

?>
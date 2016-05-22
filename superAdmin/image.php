<?php
$exp = 2592000;  //30days (60sec * 60min * 24hours * 30days)
header("Cache-Control: max-age=$exp"); 
header("Expires:".date("D, M j G:i:s",(time()+$exp)) );
header("pragma:cache");

if(isset($_SERVER['PATH_INFO'])){
    list($temp,$id,$size) = explode("/",$_SERVER['PATH_INFO']);
    if(!in_array($size, array('thumb','small'))) $size = 'full';
 
    $dbh = new PDO('sqlite:../sqlite/products');
    $sth = $dbh->query("SELECT $size AS image FROM images WHERE id = $id");
    $image = $sth->fetch(PDO::FETCH_COLUMN);
    if(!$image) {
        $noimage = "img/no-image-$size.jpg";
        if(!file_exists($noimage)){
            include '../lib/ResampleImage.php';
            $s = parse_ini_file('../image.ini', true);
            file_put_contents($noimage, resampleimage(file_get_contents('img/no-image.png'), $s[$size]['width'], $s[$size]['height'], $s['bgcolor']) );
        }
        $image = file_get_contents( $noimage );
    }
    header('Content-type: image/jpeg');
    echo $image;
}
<?php
    if(!isset($exp)) $exp = 2592000;  //30days (60sec * 60min * 24hours * 30days)
    header("Cache-Control: max-age=$exp"); 
    header("Expires:".date("D, M j G:i:s",(time()+$exp)) );
    header("pragma:cache");
    
    $_ASSETS = parse_ini_file('../ini/assets.ini');
    $_COMPANY = parse_ini_file('../ini/company.ini');
?>
<?php
    if(!isset($exp)) $exp = 43200;  //1/2days (60sec * 60min * 12hours * 0days)
    header("Cache-Control: max-age=$exp"); 
    header("Expires:".date("D, M j G:i:s",(time()+$exp)) );
    header("pragma:cache");
    
    $_ASSETS = parse_ini_file('../ini/assets.ini');
    $_COMPANY = parse_ini_file('../ini/company.ini');
?>
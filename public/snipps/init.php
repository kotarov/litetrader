<?php
    
    $exp = 0;//2592000;  //30days (60sec * 60min * 24hours * 30days)
    header("Cache-Control: max-age=$exp"); 
    header("Expires:".date("D, M j G:i:s",(time()+$exp)) );
    header("pragma:cache");
    
    $_ASSETS = parse_ini_file(__DIR__.'/../../assets.ini');
    $_COMPANY = parse_ini_file(__DIR__.'/../../company.ini');
    
    define('URL_BASE', 'https://internet-skotarov.c9users.io/lite/public/');
    define( 'DB_DIR', realpath('../../sqlite/').'/' );
    define('LIB_DIR', realpath('../../lib/'   ).'/' );
    define('INI_DIR', realpath('../../'   ).'/' );
?>
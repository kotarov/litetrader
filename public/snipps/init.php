<?php
    define( 'DB_DIR', realpath(__DIR__.'/../../sqlite/').'/' );
    define('LIB_DIR', realpath(__DIR__.'/../../lib/'   ).'/' );
    define('INI_DIR', realpath(__DIR__.'/../../ini/'    ).'/' );


    if(!isset($exp)) $exp = 3600;  //1hour (60sec * 60min * 1hours * 0days)
    header("Cache-Control: max-age=$exp"); 
    header("Expires:".date("D, M j G:i:s",(time()+$exp)) );
    header("pragma:cache");
    
    $_ASSETS = parse_ini_file(__DIR__.'/../../ini/assets.ini');
    $_COMPANY = parse_ini_file(__DIR__.'/../../ini/company.ini');
    
    
    include(LIB_DIR."URLBase.php");
 
    define('URL_BASE', base_url( realpath(__DIR__.'/../') ));
    define('URL_PRODUCTS', 'products/index.php');
    define('URL_PRODUCT', 'products/view/index.php');
    
?>
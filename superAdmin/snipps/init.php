<?php
    if(!isset($exp)) $exp = 3600;  //1hour (60sec * 60min * 1hours * 0days)
    header("Cache-Control: max-age=$exp"); 
    header("Expires:".date("D, M j G:i:s",(time()+$exp)) );
    header("pragma:cache");
    
    define('DIR_BASE', realpath(__DIR__.'/../../').'/');
    define(  'DB_DIR', DIR_BASE.'sqlite/' );
    define( 'LIB_DIR', DIR_BASE.'lib/' );
    define( 'INI_DIR', DIR_BASE.'ini/' );
    
    include(LIB_DIR."URLBase.php");
    define('URL_BASE', base_url( realpath(__DIR__.'/../') ));

    $_ASSETS = parse_ini_file(INI_DIR.'assets.ini');
    $_COMPANY = parse_ini_file(INI_DIR.'company.ini');
?>
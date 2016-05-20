<?php

if (!function_exists('base_url')) { function base_url(){   
    $base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='off') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO']=='https')) ? 'https://' : 'http://';
    
    $tmpURL = str_replace(chr(92),'/',realpath(__DIR__.'/../'));
    $tmpURL = trim(str_replace($_SERVER['DOCUMENT_ROOT'],'',$tmpURL),'/');

    if ($tmpURL !== $_SERVER['HTTP_HOST']) $base_url .= $_SERVER['HTTP_HOST'].'/'.$tmpURL.'/';
    else $base_url .= $tmpURL.'/';
    
    return $base_url; 
} }


    $exp = 0;//86400;  //1day (60sec * 60min * 24hours * 1days)
    header("Cache-Control: max-age=$exp"); 
    header("Expires:".date("D, M j G:i:s",(time()+$exp)) );
    header("pragma:cache");
    
    $_ASSETS = parse_ini_file(__DIR__.'/../../assets.ini');
    $_COMPANY = parse_ini_file(__DIR__.'/../../company.ini');
    
    define('URL_BASE', base_url());
    define( 'DB_DIR', realpath('../../sqlite/').'/' );
    define('LIB_DIR', realpath('../../lib/'   ).'/' );
    define('INI_DIR', realpath('../../'   ).'/' );
?>
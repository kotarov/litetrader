<?php
if (!function_exists('base_url')) { function base_url($base_realpath = false){
    if(!$base_realpath) $base_realpath = realpath(__DIR__.'/../public/');
    
    $base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='off') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO']=='https')) ? 'https://' : 'http://';
    
    $tmpURL = str_replace(chr(92),'/',$base_realpath);
    $tmpURL = trim(str_replace($_SERVER['DOCUMENT_ROOT'],'',$tmpURL),'/');

    if ($tmpURL !== $_SERVER['HTTP_HOST']) $base_url .= $_SERVER['HTTP_HOST'].'/'.$tmpURL.'/';
    else $base_url .= $tmpURL.'/';
    
    return $base_url; 
} }

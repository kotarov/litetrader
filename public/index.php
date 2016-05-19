<?php
$request_uri = basename($_SERVER['REQUEST_URI']);

if($request_uri == 'index.php'  ||  substr($_SERVER['REQUEST_URI'],-1) == '/'){
    $request_uri = '';
}else{
    $request_uri .= '/';
}

header('Location: '.$request_uri.'home/');
?>
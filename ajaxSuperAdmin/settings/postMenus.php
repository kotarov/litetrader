<?php
include LIB_DIR.'Configuration.php';
$ret = array();

$fields = array('home','products','articles','contacts','order');

$post = array();
foreach($fields AS $f){
    $post[$f] = isset($_POST[$f])?"1":"0";
}

file_put_contents(INI_DIR.'menus.ini', "[public]\n".arr2ini($post));
$ret['success'] = 'Data saved successfuly';


return json_encode($ret);
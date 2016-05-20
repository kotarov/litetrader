<?php
session_start();
if(!isset($_SESSION['customer']['id'])) return;

$ret = array('success'=>1);
$post = filter_var_array($_POST,array(
    'name'=>FILTER_SANITIZE_STRING,
    'family'=>FILTER_SANITIZE_STRING,
    'phone'=>FILTER_SANITIZE_STRING,
    'city'=>FILTER_SANITIZE_STRING,
    'address'=>FILTER_SANITIZE_STRING,
    'password'=>FILTER_DEFAULT
), false);

if(isset($post['password']) && !$post['password']) unset($post['password']);

if($post){
    if(isset($post['password'])) $post['password'] = md5($post['password']);
    
    $sets = array();
    foreach($post AS $k => $v){
        $sets[] = $k.' = :'.$k;
    }
    $dbh = new PDO('sqlite:../sqlite/customers');
    $sth = $dbh->prepare("UPDATE customers SET ".implode(', ',$sets)." WHERE id = ".$_SESSION['customer']['id']);
    $sth->execute($post);
    
    $_SESSION['customer'] = array_merge( $_SESSION['customer'], $post );
}

return json_encode($ret);
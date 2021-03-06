<?php
if(!isset($_SESSION['supplier']['id'])) return;

$ret = array('success'=>1);
$post = filter_var_array($_POST,array(
    'name'=>FILTER_SANITIZE_STRING,
    'family'=>FILTER_SANITIZE_STRING,
    'phone'=>FILTER_SANITIZE_STRING,
    'skype'=>FILTER_SANITIZE_STRING,
    'facebook'=>FILTER_SANITIZE_STRING,
    'twitter'=>FILTER_SANITIZE_STRING,
    'country'=>FILTER_SANITIZE_STRING,
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
    $dbh = new PDO('sqlite:../sqlite/suppliers');
    $sth = $dbh->prepare("UPDATE suppliers SET ".implode(', ',$sets)." WHERE id = ".$_SESSION['supplier']['id']);
    $sth->execute($post);
    
    $_SESSION['supplier'] = array_merge( $_SESSION['supplier'], $post );
}

return json_encode($ret);
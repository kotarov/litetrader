<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'icon'=>FILTER_SANITIZE_STRING,
    'name'=>FILTER_SANITIZE_STRING,
    'color'=>FILTER_SANITIZE_STRING,
    'is_closed'=>FILTER_VALIDATE_BOOLEAN
));

//print_r($post);exit;

if(!$post['name']) $ret['required'][] = 'name';
if(!$post['icon']) $ret['required'][] = 'icon';

if(!isset($ret['required'])){
    //$post['icon'] .= " uk-icon-justify";
    $post['is_default'] = 0;
    $sets = array_keys($post);
    $dbh = new PDO('sqlite:'.DB_DIR.'customers');
    $sth = $dbh->prepare("INSERT INTO order_statuses (".implode(',', $sets).") VALUES (:".implode(", :", $sets).")");
    $sth->execute($post);
    $_REQUEST['id'] = $dbh->lastInsertId();
    
    include 'getStatuses.php';
    $ret['success'] = 'Order id='.$_REQUEST['id'].' added successful.';
    $ret['id'] = $_REQUEST['id'];
}

return json_encode($ret);
<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
    'name'=>FILTER_SANITIZE_STRING,
    'abbreviation'=>FILTER_SANITIZE_STRING,
    'position'=>FILTER_VALIDATE_INT
));

if(!$post['id']) return;
if(!$post['name']) $ret['required'][] = 'name';
if(!$post['abbreviation']) $ret['required'][] = 'abbreviation';

if(!isset($ret['required'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'products');
    
    $sets = array(); foreach(array_keys($post) AS $k=>$v) $sets[] = $v.'=:'.$v;
    $sth = $dbh->prepare("UPDATE units SET ".implode(",", $sets)." WHERE id = :id");
    $sth->execute($post);
    $_REQUEST['id'] = $post['id'];
    include 'getMeasureUnits.php';
    $ret['success'] = 'Measure unit #'.$_REQUEST['id'].' edited successful.';
}

return json_encode($ret);

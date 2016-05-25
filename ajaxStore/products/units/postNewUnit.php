<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'name'=>FILTER_SANITIZE_STRING,
    'abbreviation'=>FILTER_SANITIZE_STRING,
    'position'=>FILTER_VALIDATE_INT
));

if(!$post['name']) $ret['required'][] = 'name';
if(!$post['abbreviation']) $ret['required'][] = 'abbreviation';

if(!isset($ret['required'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'products');
    $sth = $dbh->prepare("INSERT INTO units (".implode(',', array_keys($post)).") VALUES (:".implode(", :", array_keys($post)).")");
    $sth->execute($post);
    $_REQUEST['id'] = $dbh->lastInsertId();
    include 'getMeasureUnits.php';
    $ret['success'] = 'Measure unit #'.$_REQUEST['id'].' added successful.';
}

return json_encode($ret);

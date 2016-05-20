<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'name'=>FILTER_SANITIZE_STRING,
    'id_parent'=>FILTER_VALIDATE_INT,
    'pos'=>FILTER_VALIDATE_INT,
    'description'=>FILTER_SANITIZE_STRING,
    'tags' => FILTER_SANITIZE_STRING
));

if(!$post['name']) $ret['required'][] = 'name';
//if(!$post['id_parent']) $ret['required'][] = 'id_parent';
if(!$post['description']) $ret['required'][] = 'description';
if(!$post['tags']) $ret['required'][] = 'tags';

if(!isset($ret['required'])){
    $sets = array_keys($post);
    $dbh = new PDO('sqlite:'.DB_DIR.'products');
    $sth = $dbh->prepare("INSERT INTO categories (".implode(',', $sets).") VALUES (:".implode(", :", $sets).")");
    $sth->execute($post);
    $_REQUEST['id'] = $dbh->lastInsertId();
    include 'prepareCategories.php';
    include 'getCategories.php';
    $ret['success'] = 'Category with id='.$_REQUEST['id'].' added.';
}

return json_encode($ret);

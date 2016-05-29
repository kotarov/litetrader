<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'title'=>FILTER_SANITIZE_STRING,
    'id_parent'=>FILTER_VALIDATE_INT,
    'position'=>FILTER_VALIDATE_INT,
    'subtitle'=>FILTER_SANITIZE_STRING,
    'tags' => array(
        'filter' => FILTER_SANITIZE_STRING,
        'flags'  => FILTER_FORCE_ARRAY,
    )
));

if(!$post['title']) $ret['required'][] = 'title';
//if(!$post['id_parent']) $ret['required'][] = 'id_parent';
if(!$post['subtitle']) $ret['required'][] = 'subtitle';
if(!$post['tags']) $ret['required'][] = 'tags[]';

if(!isset($ret['required'])){
    $post['tags'] = implode(',',$post['tags']);
    $sets = array_keys($post);
    $dbh = new PDO('sqlite:'.DB_DIR.'blogs');
    $sth = $dbh->prepare("INSERT INTO categories (".implode(',', $sets).") VALUES (:".implode(", :", $sets).")");
    $sth->execute($post);
    $_REQUEST['id'] = $dbh->lastInsertId();
    include 'prepareCategories.php';
    include 'getCategories.php';
    $ret['success'] = 'Category with id='.$_REQUEST['id'].' added.';
}

return json_encode($ret);

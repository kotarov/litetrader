<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
    'name'=>FILTER_SANITIZE_STRING,
    'id_parent'=>FILTER_VALIDATE_INT,
    'pos'=>FILTER_VALIDATE_INT,
    'description'=>FILTER_SANITIZE_STRING,
    'tags' => array(
        'filter' => FILTER_SANITIZE_STRING,
        'flags'  => FILTER_FORCE_ARRAY,
    )
));

if(!$post['id']) exit;

if(!$post['name']) $ret['required'][] = 'name';
//if(!$post['id_parent']) $ret['required'][] = 'id_parent';
if(!$post['description']) $ret['required'][] = 'description';
if(!$post['tags']) $ret['required'][] = 'tags[]';

if(!isset($ret['required'])){
    $post['tags'] = implode(',',$post['tags']);

    $sets = array();
    foreach(array_keys($post) AS $k=>$v){
        $sets[] = $v.'=:'.$v;
    }
    $dbh = new PDO('sqlite:'.DB_DIR.'products');
    $sth = $dbh->prepare("UPDATE categories SET ".implode(",", $sets)." WHERE id = :id");
    $sth->execute($post);
    include 'prepareCategories.php';
    $_GET['getforselect'] = 1;
    include 'getCategories.php';
    $ret['success'] = 'Category id='.$_REQUEST['id'].' changed.';
}

return json_encode($ret);

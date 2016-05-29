<?php
include_once(LIB_DIR."URLRewrite.php");

$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
    'edit-title'=>FILTER_SANITIZE_STRING,
    'edit-subtitle'=>FILTER_SANITIZE_STRING,
    'edit-content'=>FILTER_DEFAULT,
    'date'=>FILTER_SANITIZE_STRING,
    'id_category'=>FILTER_VALIDATE_INT,
    'tags' => array(
        'filter' => FILTER_SANITIZE_STRING,
        'flags'  => FILTER_FORCE_ARRAY,
    )
));

if(!$post['id']) exit;


$post['title'] = $post['edit-title'];
$post['subtitle'] = $post['edit-subtitle'];
$post['content'] = $post['edit-content'];
unset($post['edit-title']);unset($post['edit-subtitle']);unset($post['edit-content']);

if(!$post['title']) $ret['required'][] = 'title';
if(!$post['tags']) $ret['required'][] = 'tags[]';

if(!isset($ret['required'])){
        $post['tags'] = implode(',',$post['tags']);
        if($post['date']) $post['date'] = strtotime($post['date']);
        $post['url_rewrite'] = url_rewrite($post['id'].'-'.$post['title']);
        
        $sets = array();
        foreach(array_keys($post) AS $k=>$v){
            $sets[] = $v.'=:'.$v;
        }
        
        $dbh = new PDO('sqlite:'.DB_DIR.'blogs');
        $sth = $dbh->prepare("UPDATE blogs SET ".implode(",", $sets)." WHERE id = :id");
        $sth->execute($post);
        $_REQUEST['id'] = $post['id'];
        include 'getBlogs.php';
        $ret['id'] = $post['id'];
        $ret['success'] = 'Blog id='.$_REQUEST['id'].' changed.';
}

return json_encode($ret);


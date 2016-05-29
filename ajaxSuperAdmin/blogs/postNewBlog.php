<?php
include_once(LIB_DIR."URLRewrite.php");

$ret = array();
$post = filter_var_array($_POST,array(
    'new-title'=>FILTER_SANITIZE_STRING,
    'new-subtitle'=>FILTER_SANITIZE_STRING,
    'new-content'=>FILTER_DEFAULT,
    'date'=>FILTER_SANITIZE_STRING,
    'id_category'=>FILTER_VALIDATE_INT,
    'tags' => array(
        'filter' => FILTER_SANITIZE_STRING,
        'flags'  => FILTER_FORCE_ARRAY,
    )
));

$post['title'] = $post['new-title'];
$post['subtitle'] = $post['new-subtitle'];
$post['content'] = $post['new-content'];
unset($post['new-title']);unset($post['new-subtitle']);unset($post['new-content']);

if(!$post['title']) $ret['required'][] = 'title';
if(!$post['tags']) $ret['required'][] = 'tags[]';

if(!isset($ret['required'])){
        $post['tags'] = implode(',',$post['tags']);
        $post['author'] = $_SESSION['employee']['name'].' '.$_SESSION['employee']['family'];
        $post['date_add'] = time();
        if($post['date']) $post['date'] = strtotime($post['date']);
        
        $sets = array_keys($post);
        $dbh = new PDO('sqlite:'.DB_DIR.'blogs');
        $sth = $dbh->prepare("INSERT INTO blogs (".implode(',', $sets).") VALUES (:".implode(", :", $sets).")");
        $sth->execute($post);
        $_REQUEST['id'] = $dbh->lastInsertId();
        
        $url_rewrite = url_rewrite($_REQUEST['id'].'-'.$post['title']);
        $dbh->query("UPDATE blogs SET url_rewrite = '".$url_rewrite."' WHERE id = ".$_REQUEST['id']);

        include 'getBlogs.php';
        $ret['success'] = 'Blog with id='.$_REQUEST['id'].' added.';
        $ret['id'] = $_REQUEST['id'];
    
}

return json_encode($ret);


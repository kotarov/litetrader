<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
    'mce_0'=>FILTER_SANITIZE_STRING,
    'mce_2'=>FILTER_SANITIZE_STRING,
    'mce_3'=>FILTER_DEFAULT,
    'date'=>FILTER_SANITIZE_STRING,
    'id_category'=>FILTER_VALIDATE_INT,
    'tags' => array(
        'filter' => FILTER_SANITIZE_STRING,
        'flags'  => FILTER_FORCE_ARRAY,
    )
));

//if(!$post['id']) exit;


$post['title'] = $post['mce_0'];
$post['subtitle'] = $post['mce_2'];
$post['content'] = $post['mce_3'];
unset($post['mce_0']);unset($post['mce_2']);unset($post['mce_3']);

if(!$post['title']) $ret['required'][] = 'title';
if(!$post['tags']) $ret['required'][] = 'tags[]';

if(!isset($ret['required'])){
    if($post['id']){
        $post['tags'] = implode(',',$post['tags']);
        $sets = array();
        foreach(array_keys($post) AS $k=>$v){
            $sets[] = $v.'=:'.$v;
        }
        if($post['date']) $post['date'] = strtotime($post['date']);
        
        $dbh = new PDO('sqlite:'.DB_DIR.'blogs');
        $sth = $dbh->prepare("UPDATE blogs SET ".implode(",", $sets)." WHERE id = :id");
        $sth->execute($post);
        $_REQUEST['id'] = $post['id'];
        include 'getBlogs.php';
        $ret['id'] = $post['id'];
        $ret['success'] = 'Blog id='.$_REQUEST['id'].' changed.';
    }else{
        unset($post['id']);
        $post['tags'] = implode(',',$post['tags']);
        $post['author'] = $_SESSION['supplier']['name'].' '.$_SESSION['supplier']['family'];
        $post['date_add'] = time();
        if($post['date']) $post['date'] = strtotime($post['date']);
        
        $sets = array_keys($post);
        $dbh = new PDO('sqlite:'.DB_DIR.'blogs');
        $sth = $dbh->prepare("INSERT INTO blogs (".implode(',', $sets).") VALUES (:".implode(", :", $sets).")");
        $sth->execute($post);
        $_REQUEST['id'] = $dbh->lastInsertId();
        include 'getBlogs.php';
        $ret['success'] = 'Blog with id='.$_REQUEST['id'].' added.';
    }
}

return json_encode($ret);

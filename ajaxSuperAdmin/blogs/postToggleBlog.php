<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
    'field'=>FILTER_SANITIZE_STRING
));

if(!$post['id']) $ret['error'] = 'Wrong ID !';
if(!in_array($post['field'], array('is_active') )) $ret['error']='Wrong request!';

if(!isset($ret['error'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'blogs');
    
    $value = $dbh->query("SELECT ".$post['field']." FROM blogs WHERE id = ".$post['id'])->fetch(PDO::FETCH_COLUMN);
    $sth = $dbh->prepare("UPDATE blogs SET ".$post['field']." = ".($value?'null':1)." WHERE id = ".$post['id']);
    if( $sth->execute() ){
        include 'getBlogs.php';
        $ret['id'] = $post['id'];
        $ret['success'] = 'Success';
    } else {
        $ret['error'] = 'Cannot set this value';
    }
}

return json_encode($ret);
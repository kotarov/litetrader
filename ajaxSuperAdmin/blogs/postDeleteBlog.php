<?php

$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
));

if(!$post['id']) exit;

$dbh = new PDO('sqlite:'.DB_DIR.'blogs');
$sth = $dbh->prepare("DELETE FROM blogs WHERE id = :id");
if( $sth->execute($post) ){
    $ret['id'] = $post['id'];
    $ret['success'] = 'Article deleted';
}else {
    $ret['error'] = 'Cannot delete articl';
}

return json_encode($ret);
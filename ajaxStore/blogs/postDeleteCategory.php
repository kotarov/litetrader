<?php

$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
));

if(!$post['id']) exit;

$dbh = new PDO('sqlite:'.DB_DIR.'blogs');
$sth = $dbh->prepare("DELETE FROM categories WHERE id = :id");
if( $sth->execute($post) ){
    include 'prepareCategories.php';
    include 'getCategories.php';
    $ret['success'] = 'category deleted';
}else {
    $ret['error'] = 'Cannot delete category';
}

return json_encode($ret);
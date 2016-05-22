<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
    'description'=>FILTER_DEFAULT
));

//print_r($post);exit; 

if(!$post['id']) $ret['errors'] = 'Wrong id';

if(!isset($ret['errors'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'products');  
    $sth = $dbh->prepare("UPDATE products SET details = :description WHERE id = :id");
    $sth->execute($post);
    include 'getProducts.php';
    $ret['id'] = $post['id'];
    $ret['success'] = 'Product #'.$_REQUEST['id'].' details changed.';
}
return json_encode($ret);
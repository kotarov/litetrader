<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
    'details'=>FILTER_SANITIZE_STRING
));

if(!$post['id']) exit;

$dbh = new PDO('sqlite:'.DB_DIR.'products');
$sth = $dbh->prepare("UPDATE products SET details = :details WHERE id = :id");
$sth->execute($post);
include 'getProducts.php';
$ret['success'] = 'Product id='.$_REQUEST['id'].' changed.';

return json_encode($ret);

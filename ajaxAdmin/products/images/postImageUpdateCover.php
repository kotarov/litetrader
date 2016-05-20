<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT
));

if(!$post['id']) exit;

$dbh = new PDO('sqlite:'.DB_DIR.'products');
$_REQUEST['id'] = $dbh->query("SELECT id_product FROM images WHERE id =".$post['id'])->fetch(PDO::FETCH_COLUMN);

$sth = $dbh->query("UPDATE images SET is_cover = null WHERE id_product = ".$_REQUEST['id']);
$sth = $dbh->query("UPDATE images SET is_cover = 1 WHERE id =".$post['id']);

include '../getProducts.php';
$ret['success'] = 'Product image updated.';
$ret['id']=$_REQUEST['id'];

return json_encode($ret);

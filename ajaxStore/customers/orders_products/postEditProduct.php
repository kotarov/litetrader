<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id_parent'=> FILTER_VALIDATE_INT,
    'id_product'=>FILTER_VALIDATE_INT,
    'id_unit'=>FILTER_VALIDATE_INT,
    'note'=>FILTER_SANITIZE_STRING,
    'price'=>FILTER_VALIDATE_FLOAT,
    'qty'=>FILTER_VALIDATE_FLOAT
));

if(!$post['id_parent']) $ret['required'][] = 'Wrong request';
if(!$post['price'] || $post['price'] < 0) $ret['required'][] = 'price';
if(!$post['qty'] || $post['qty'] < 0 ) $ret['required'][] = 'qty';

if(!isset($ret['required'])){
    $post['id_order'] = $post['id_parent']; unset($post['id_parent']);

    $dbh = new PDO('sqlite:'.DB_DIR.'products');
    $post['product'] = $dbh->query("SELECT name FROM products WHERE id = ".$post['id_product'])->fetch(PDO::FETCH_COLUMN);
    $post['unit'] = $dbh->query("SELECT abbreviation FROM units WHERE id = ".$post['id_unit'])->fetch(PDO::FETCH_COLUMN);  

    $dbh = new PDO('sqlite:'.DB_DIR.'customers');
    $sets = array(); foreach(array_keys($post) AS $k=>$v){ $sets[] = $v.'=:'.$v; }
    $sth = $dbh->prepare("UPDATE orders_products SET ".implode(",", $sets)." WHERE id_order = :id_order AND id_product = :id_product");
    $sth->execute($post);

    
    $_REQUEST['id'] = $post['id_order'];
    include '../orders/getOrders.php';
    $ret['success'] = 'Added successful.';
    $ret['id'] = $_REQUEST['id'];
}

return json_encode($ret);
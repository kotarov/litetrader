<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id_parent'=>FILTER_VALIDATE_INT,
    'id_product'=>FILTER_VALIDATE_INT,
    'note'=>FILTER_SANITIZE_STRING,
    'id_unit'=>FILTER_VALIDATE_INT,
    'price'=>FILTER_VALIDATE_FLOAT,
    'qty'=>FILTER_VALIDATE_FLOAT
));

if(!$post['id_parent']) $ret['required'][] = 'id_parent';
if(!$post['id_product']) $ret['required'][] = 'id_poduct';
if(!$post['price'] || $post['price'] < 0) $ret['required'][] = 'price';
if(!$post['qty'] || $post['qty'] < 0 ) $ret['required'][] = 'qty';

if(!isset($ret['required'])){
    $post['id_customer'] = $post['id_parent'];
    unset($post['id_parent']);
    $post['is_closed'] = 0;
    
    $sets = array_keys($post);
    $dbh = new PDO('sqlite:'.DB_DIR.'customers');
    $sth = $dbh->prepare("INSERT INTO customers_products (".implode(',', $sets).") VALUES (:".implode(", :", $sets).")");
    $sth->execute($post);
    $ret['id'] = $post['id_customer'];
    $_REQUEST['id'] = $post['id_customer'];
    include '../getCustomers.php';
    $ret['success'] = 'Added successful.';
}

return json_encode($ret);
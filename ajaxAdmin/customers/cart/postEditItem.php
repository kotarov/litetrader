<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id'=> FILTER_VALIDATE_INT,
    'id_product'=>FILTER_VALIDATE_INT,
    'id_unit'=>FILTER_VALIDATE_INT,
    'note'=>FILTER_SANITIZE_STRING,
    'price'=>FILTER_VALIDATE_FLOAT,
    'qty'=>FILTER_VALIDATE_FLOAT
));

if(!$post['price'] || $post['price'] < 0) $ret['required'][] = 'price';
if(!$post['qty'] || $post['qty'] < 0 ) $ret['required'][] = 'qty';

if(!isset($ret['required'])){
    $post['is_closed'] = 0;
    
    $sets = array();
    foreach(array_keys($post) AS $k=>$v){
        $sets[] = $v.'=:'.$v;
    }
    $dbh = new PDO('sqlite:'.DB_DIR.'customers');
    $sth = $dbh->prepare("UPDATE customers_products SET ".implode(",", $sets)." WHERE id = :id AND id_product = :id_product");
    $sth->execute($post);
    
    $ret['id'] = $dbh->query("SELECT id_customer FROM customers_products WHERE id = ".$post['id'])->fetch(PDO::FETCH_COLUMN);
    $_REQUEST['id'] = $ret['id'];
    include '../getCustomers.php';
    $ret['success'] = 'Updated successful.';
}

return json_encode($ret);
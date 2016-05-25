<?php
$ret = array();
$post = filter_var_array($_POST, array(
    'id'=>FILTER_VALIDATE_INT,
    'customer'=>FILTER_SANITIZE_STRING,
    'company'=>FILTER_SANITIZE_STRING,
    'ein'=>FILTER_SANITIZE_STRING,
    'email'=>FILTER_SANITIZE_STRING,
    'phone'=>FILTER_SANITIZE_STRING,
    'country'=>FILTER_SANITIZE_STRING,
    'city'=>FILTER_SANITIZE_STRING,
    'address'=>FILTER_SANITIZE_STRING
));

$dbh = new PDO('sqlite:'.DB_DIR.'customers');
$old_data = $dbh->query("SELECT id_customer, id_company FROM orders WHERE id = ".$post['id'])->fetch(PDO::FETCH_ASSOC);

if(!$post['customer']) $ret['required'][]='customer';
if($old_data['id_company']){
    if(!$post['company']) $ret['required'][]='company';
}
if($post['company']) {
    if(!$post['ein']) $ret['required'][]='ein';
    if(!$post['country']) $ret['required'][]='country';
    if(!$post['city']) $ret['required'][]='city';
    if(!$post['address']) $ret['required'][]='address';
}
if(!$post['email'] && !$post['phone']){
    $ret['required'][]='phone';
    $ret['required'][]='email';
}



if(!isset($ret['required'])){
    $sets = array(); foreach(array_keys($post) AS $k=>$v){ $sets[] = $v.'=:'.$v; }
    $sth = $dbh->prepare("UPDATE orders SET ".implode(",", $sets)." WHERE id = :id");
    $sth->execute($post);
    
    $ret['id'] = $post['id'];
    include 'getOrders.php';
    $ret['success'] = 'Successful updated';
}

return json_encode($ret);
?>
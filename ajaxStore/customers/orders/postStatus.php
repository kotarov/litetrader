<?php
$ret = array();

$post = filter_var_array($_POST,array(
    'id' => FILTER_VALIDATE_INT,
    'id_status'=>FILTER_VALIDATE_INT
));

if(!$post['id_status']) return;
if(!$post['id']) $ret['error'] = 'Wrong request';

if(!isset($ret['error'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'customers');
    
    // orders
    $sth = $dbh->prepare("UPDATE orders SET id_status = :id_status WHERE id = :id");
    $sth->execute($post);

    // orders_statuses    
    $post['id_order'] = $post['id']; unset($post['id']);
    $post['status'] = $dbh->query("SELECT name from order_statuses WHERE id = ".$post['id_status'])->fetch(PDO::FETCH_COLUMN);
    $post['user'] = $_SESSION['supplier']['name'].' '.$_SESSION['supplier']['family'];
    $post['date_add'] = time();
    
    $sth = $dbh->prepare("INSERT INTO orders_statuses (".implode(',', array_keys($post)).") VALUES (:".implode(", :", array_keys($post)).");");
    $sth->execute($post);
    
    if(isset($NO_RETURN)) return;
    
    include "getOrders.php";
    $ret['id'] = $_REQUEST['id'];
    $ret['success'] = 'Status changed';
}
return json_encode($ret);
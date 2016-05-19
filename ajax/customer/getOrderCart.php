<?php
session_start();
$ret = array();
$get = filter_var_array($_GET,array(
    'id_order'=>FILTER_VALIDATE_INT    
));

if(isset($_SESSION['customer'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'customers');
    
    $sql = "SELECT 
        op.id_product, 
        op.product,
        op.note,
        op.unit,
        op.qty,
        op.price
    FROM orders_products op 
    LEFT JOIN orders o ON (o.id = op.id_order) 
    WHERE op.id_order = ".$get['id_order']." AND o.id_customer = ".$_SESSION['customer']['id'];
    
    $ret['data'] = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $ret['id']=$get['id_order'];
}

return json_encode($ret);
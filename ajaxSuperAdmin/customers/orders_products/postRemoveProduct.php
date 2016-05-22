<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id_parent'=>FILTER_VALIDATE_INT,
    'id_product'=>FILTER_VALIDATE_INT
));

if(!$post['id_parent'] || !$post['id_product']) $ret['error'] = 'Wrong ID !';

if(!isset($ret['error'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'customers');
    $sth = $dbh->prepare("DELETE FROM orders_products WHERE id_order = :id_parent AND id_product = :id_product");
    if( $sth->execute($post) ){
        $_REQUEST['id'] = $post['id_parent'];
        include '../orders/getOrders.php';
        $ret['success'] = 'Added successful.';
        $ret['id'] = $_REQUEST['id'];
    }else {
        $ret['error'] = 'Cannot remove';
    }

}

return json_encode($ret);
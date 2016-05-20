<?php
/// strftime('%d - %m  - %Y ', datetime(o.date_add, 'unixepoch'))

session_start();
$ret = array();
$get = filter_var_array($_GET,array(
    't'=>FILTER_SANITIZE_STRING    
));



if(isset($_SESSION['customer'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'customers');
    $where = 1;
    if($get['t'] == 'active' ) $where = "s.is_closed != 1 OR s.is_closed IS NULL"; 
    if($get['t'] == 'done' ) $where = "s.is_closed == 1";
    if($get['t'] == 'canceld' ) $where = "0"; 

    $sql = "SELECT 
            o.date_add date, 
            o.country||', '||o.city||', '||o.address address, 
            (SELECT COUNT(id) FROM orders_products WHERE id_order = o.id) products, 
            (SELECT SUM(op.qty*op.price) FROM orders_products op WHERE op.id_order = o.id) total,
            o.id id
        FROM orders o 
        LEFT JOIN order_statuses s ON (s.id = o.id_status)
        WHERE $where AND id_customer = ".$_SESSION['customer']['id']."
        ORDER BY date DESC"; 
    $ret['data'] = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

return json_encode($ret);
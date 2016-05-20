<?php

$ret = array();
if(isset($_GET['id']) && (int)$_GET['id']){
    $dbh = new PDO('sqlite:'.DB_DIR.'customers');
    
    /*print("SELECT s.icon, os.status, os.date_add, os.user, s.color 
    FROM orders_statuses os 
    LEFT JOIN order_statuses s ON (s.id = os.id_status) 
    WHERE id_order = ".(int)$_GET['id']);exit;
    */
    $ret['data']= $dbh->query("SELECT s.icon, os.status, os.date_add, os.user, s.color 
    FROM orders_statuses os 
    LEFT JOIN order_statuses s ON (s.id = os.id_status) 
    WHERE os.id_order = ".(int)$_GET['id']." ORDER BY os.date_add DESC")->fetchAll(PDO::FETCH_ASSOC);
}

return json_encode($ret);
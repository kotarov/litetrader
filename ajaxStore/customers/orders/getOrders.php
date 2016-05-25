<?php
$where = '';
if(isset($_REQUEST['id'])) $where = " WHERE o.id = ".(int)$_REQUEST['id'];

$dbh = new PDO('sqlite:'.DB_DIR.'customers');
$sth = $dbh->prepare("SELECT 
    os.icon status,
    o.id,
    o.date_add,
    o.customer, 
    o.company,
    o.city||' '||o.country||' '||o.address address,
    (SELECT SUM(op.price*op.qty) FROM orders_products op WHERE op.id_order = o.id) total, 
    o.id actions,
    o.id_customer,
    os.is_closed,
    os.color,
    os.name
FROM orders o LEFT JOIN order_statuses os ON ( o.id_status = os.id ) 
$where");

$sth->execute();
$ret['data'] = $sth->fetchAll(PDO::FETCH_NUM);

return json_encode($ret);
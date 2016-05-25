<?php
$where = '';
if(isset($_REQUEST['id'])) $where = " WHERE c.id = ".(int)$_REQUEST['id'];

$dbh = new PDO('sqlite:'.DB_DIR.'customers');
$sth = $dbh->query("SELECT 
    c.is_active,
    c.id,
    c.name || ' ' || c.family,
    c.phone,
    c.email,
    c.city || '; '|| c.address,
    (SELECT GROUP_CONCAT(co.name) FROM customers_companies cc LEFT JOIN companies co ON (co.id = cc.id_company) WHERE cc.id_customer = c.id) company,
    c.id actions,
    (SELECT COUNT(cp.id) FROM customers_products cp WHERE cp.is_closed != 1 AND cp.id_customer = c.id) cart
FROM customers c $where");


$ret['data'] = $sth->fetchAll(PDO::FETCH_NUM);
return json_encode($ret);
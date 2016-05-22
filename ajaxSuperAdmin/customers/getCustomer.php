<?php

if(!isset($_GET['id'])) exit;

$dbh = new PDO('sqlite:'.DB_DIR.'customers');
$sth = $dbh->query("SELECT 
    c.id,
    c.name,
    c.family,
    c.phone,
    c.email,
    c.country,
    c.city,
    (SELECT GROUP_CONCAT(cc.id_company) FROM customers_companies cc WHERE cc.id_customer = c.id) `id_company[]`,
    c.address
FROM customers c
WHERE c.id = ".(int)$_GET['id']);

$ret['data'] = $sth->fetchAll(PDO::FETCH_ASSOC);

return json_encode($ret);

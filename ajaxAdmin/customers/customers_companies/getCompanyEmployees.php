<?php
//die("svetlio");

if(!isset($_GET['id'])) exit;

$id_company = (int)$_GET['id'];

$dbh = new PDO('sqlite:'.DB_DIR.'customers');
$sth = $dbh->query("SELECT 
    c.is_active,
    c.id,
    c.name,
    c.phone,
    c.email,
    c.id actions
FROM customers_companies cc 
LEFT JOIN customers c ON (cc.id_customer = c.id)
WHERE cc.id_company = $id_company");


$ret['data'] = $sth->fetchAll(PDO::FETCH_NUM);

return json_encode($ret);
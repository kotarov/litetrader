<?php

if(!isset($_GET['id'])) exit;

$dbh = new PDO('sqlite:'.DB_DIR.'customers');
$dbh->query('ATTACH DATABASE "'.DB_DIR.'products" AS "pr"');

$sth = $dbh->query("SELECT 
    sp.id,
    sp.id_product,
    sp.note,
    p.id||'. '||p.name product,
    p.date_add image,
    sp.id_unit,
    sp.qty,
    sp.price
FROM orders_products sp 
LEFT JOIN pr.products p ON (p.id = sp.id_product) 
WHERE sp.id = ".(int)$_GET['id']);


$ret['data'] = $sth->fetchAll(PDO::FETCH_ASSOC);

return json_encode($ret);

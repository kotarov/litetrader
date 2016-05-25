<?php

if(!isset($_GET['id'])) exit;

$dbh = new PDO('sqlite:'.DB_DIR.'customers');
$dbh->query('ATTACH DATABASE "'.DB_DIR.'products" AS "pr"');


$sth = $dbh->query("SELECT 
    op.id_product image,
    p.name product,
    op.note,
    op.qty,
    u.abbreviation mu,
    op.price,
    (op.qty*op.price) total,
    
    op.id_order,
    op.id_product,
    op.id_unit,
    op.id
FROM orders_products op 
LEFT JOIN pr.products p ON (p.id = op.id_product) 
LEFT JOIN pr.units u ON (op.id_unit = u.id) 
WHERE op.id_order = ".(int)$_GET['id']);


$ret['data'] = $sth->fetchAll(PDO::FETCH_ASSOC);

return json_encode($ret);

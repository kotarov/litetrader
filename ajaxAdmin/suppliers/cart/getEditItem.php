<?php

if(!isset($_GET['id'])) exit;

$dbh = new PDO('sqlite:'.DB_DIR.'suppliers');
$dbh->query('ATTACH DATABASE "'.DB_DIR.'products" AS "pr"');


$sth = $dbh->query("SELECT 
    sp.id,
    sp.id_product,
    p.id||'. '||p.name product,
    p.date_add image,
    u.name mu,
    sp.qty,
    sp.price
FROM suppliers_products sp 
LEFT JOIN pr.products p ON (p.id = sp.id_product) 
LEFT JOIN pr.units u ON (sp.id_unit = u.id) 
WHERE sp.is_closed != 1 AND sp.id = ".(int)$_GET['id']);


$ret['data'] = $sth->fetchAll(PDO::FETCH_ASSOC);

return json_encode($ret);

<?php

if(!isset($_GET['id'])){
    if(isset($_GET['id_product'])){
        $_GET['id'] = $_GET['id_product'];
    }else{ exit; }
}

$dbh = new PDO('sqlite:'.DB_DIR.'products');
$sth = $dbh->prepare("SELECT 
    p.id,
    p.name,
    p.reference,
    p.id_category,
    p.id_supplier,
    p.id_unit,
    p.price,
    p.qty,
    p.description,
    p.tags AS 'tags[]',
    u.abbreviation unit 
FROM products p 
LEFT JOIN units u ON (u.id = p.id_unit) 
WHERE p.id = ".(int)$_GET['id']);
$sth->execute();
$ret['data'] = $sth->fetchAll(PDO::FETCH_ASSOC);

return json_encode($ret);

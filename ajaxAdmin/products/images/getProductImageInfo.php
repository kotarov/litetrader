<?php

if(!isset($_GET['id'])) exit;

$dbh = new PDO('sqlite:'.DB_DIR.'products');
$sth = $dbh->query("SELECT 
    i.id,
    i.id_product,
    i.name,
    i.type,
    i.size,
    i.is_cover,
    i.date_add,
    p.name product
FROM images i 
LEFT JOIN products p ON (i.id_product = p.id) 
WHERE i.id = ".(int)$_GET['id']);

$ret['data'] = $sth->fetchAll(PDO::FETCH_ASSOC);

return json_encode($ret);
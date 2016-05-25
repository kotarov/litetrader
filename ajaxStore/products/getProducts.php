<?php

$where = '';
if(isset($_REQUEST['id'])) $where = " WHERE p.id = ".(int)$_REQUEST['id'];

$dbh = new PDO('sqlite:'.DB_DIR.'products');
$dbh->query("ATTACH DATABASE '".DB_DIR."suppliers' AS sup");

$sth = $dbh->prepare("SELECT 
    p.is_visible,
    p.is_avaible,
    p.is_adv,
    p.id,
    i.id image,
    p.name,
    c.name category,
    sc.name,
    p.price,
    p.qty,
    p.id actions,
    i.date_add,
    p.reference,
    (SELECT COUNT(id) FROM images WHERE id_product = p.id) image_count,
    u.abbreviation unit
FROM products p
LEFT JOIN categories c ON (c.id = p.id_category) 
LEFT JOIN images i ON (i.id_product = p.id AND i.is_cover = 1) 
LEFT JOIN sup.companies sc ON (sc.id = p.id_supplier) 
LEFT JOIN units u ON (u.id = p.id_unit) "
."$where");
$sth->execute();
$ret['data'] = $sth->fetchAll(PDO::FETCH_NUM);

return json_encode($ret);
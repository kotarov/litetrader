<?php

$ret = array();

$search = filter_var_array($_GET,array(
    'q'=>FILTER_SANITIZE_STRING,
    'p'=>FILTER_VALIDATE_INT
));

$search['q'] = '%'.$search['q'].'%';
$search['p'] = (int)$search['p'];

$where = array();
foreach(array('p.name', 'p.id', 'p.reference','p.price','c.name') AS $k=> $f){
    $where[] = "$f LIKE :q";
}
$where = implode(" OR ",$where);

$dbh = new PDO('sqlite:'.DB_DIR.'products');

/*
$sth = $dbh->prepare("SELECT COUNT(p.id) FROM products p WHERE $where");
$sth->execute($search);
$ret['total_count'] = $sth->fetch(PDO::FETCH_COLUMN);
*/

$sth = $dbh->prepare("SELECT 
    p.id,
    p.name text,
    p.reference,
    p.price,
    p.id_unit,
    u.abbreviation unit,
    p.id_category,
    c.name category
FROM products p 
LEFT JOIN categories c ON (p.id_category = c.id) 
LEFT JOIN units u ON (p.id_unit = u.id)
WHERE $where   
LIMIT :p, 10 
");
$sth->execute($search);
$ret['results'] = $sth->fetchAll(PDO::FETCH_ASSOC);

return json_encode($ret);
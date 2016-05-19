<?php
$ret = array();
$search = filter_var_array($_GET,array(
    'q'=>FILTER_SANITIZE_STRING,
    'p'=>FILTER_VALIDATE_INT
));

$search['q'] = '%'.strtolower($search['q']).'%';
$search['p'] = (int)$search['p'];

$where = array();
foreach(array('c.id', 'c.name', 'c.family', 'c.phone', 'c.email', 'c.city', 'c.address', 'companies') AS $k=> $f){
    $where[] = "LOWER($f) LIKE :q";
} 
$where = implode(" OR ",$where);

$dbh = new PDO('sqlite:'.DB_DIR.'customers');
$sth = $dbh->prepare("SELECT 
    c.id,
    c.name||' '||c.family text,
    c.phone,
    c.email,
    (SELECT GROUP_CONCAT(co.name) FROM customers_companies cc LEFT JOIN companies co ON (co.id = cc.id_company) WHERE cc.id_customer = c.id) companies
FROM customers c 
WHERE $where    
LIMIT :p, 10 
");
$sth->execute($search);
$ret['results'] = $sth->fetchAll(PDO::FETCH_ASSOC);

return json_encode($ret);
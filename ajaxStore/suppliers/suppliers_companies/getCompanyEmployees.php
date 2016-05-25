<?php
if(!isset($_GET['id'])) exit;

$id_company = (int)$_GET['id'];

$dbh = new PDO('sqlite:'.DB_DIR.'suppliers');
$sth = $dbh->query("SELECT 
    s.is_active,
    s.id,
    s.name,
    s.phone,
    s.email,
    s.id actions
FROM suppliers_companies sc 
LEFT JOIN suppliers s ON (sc.id_supplier = s.id)
WHERE sc.id_company = $id_company");

$ret['data'] = $sth->fetchAll(PDO::FETCH_NUM);

return json_encode($ret);
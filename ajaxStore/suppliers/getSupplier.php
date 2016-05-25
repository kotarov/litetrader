<?php

if(!isset($_GET['id'])) exit;

$dbh = new PDO('sqlite:'.DB_DIR.'suppliers');
$sth = $dbh->query("SELECT 
    s.id,
    s.name,
    s.family,
    s.phone,
    s.email,
    s.skype,
    s.facebook,
    s.country,
    s.city,
    (SELECT GROUP_CONCAT(sc.id_company) FROM suppliers_companies sc WHERE sc.id_supplier = s.id) `id_company[]`,
    s.address
FROM suppliers s
WHERE id = ".(int)$_GET['id']);

$ret['data'] = $sth->fetchAll(PDO::FETCH_ASSOC);

return json_encode($ret);

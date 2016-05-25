<?php
$where = '';
if(isset($_REQUEST['id'])) $where = " WHERE s.id = ".(int)$_REQUEST['id'];

$dbh = new PDO('sqlite:'.DB_DIR.'suppliers');
$sth = $dbh->query("SELECT 
    s.is_active,
    s.id,
    s.name || ' ' || s.family,
    s.phone,
    s.email,
    s.city || '; '|| s.address,
    (SELECT GROUP_CONCAT(c.name) FROM suppliers_companies sc LEFT JOIN companies c ON (c.id = sc.id_company) WHERE sc.id_supplier = s.id) company,
    s.id actions,
    (SELECT COUNT(*) FROM suppliers_products sp WHERE sp.is_closed != 1 AND sp.id_supplier = s.id) cart
FROM suppliers s $where");

$ret['data'] = $sth->fetchAll(PDO::FETCH_NUM);
return json_encode($ret);
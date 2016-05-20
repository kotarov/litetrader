<?php
$dbh = new PDO('sqlite:'.DB_DIR.'customers');

$home = array();
$where = '';
if(isset($_GET['id_customer'])) {
    $id_companies = $dbh->query("SELECT id_company FROM customers_companies WHERE id_customer=".(int)$_GET['id_customer'])->fetchAll(PDO::FETCH_COLUMN);
    $where = 'WHERE id IN ('.implode(",",$id_companies).')';
    $home = $dbh->query("SELECT '0' id, ('Home / '||city) text, 'uk-icon-home' icon, email, country, city, address, phone FROM customers WHERE id = ".(int)$_GET['id_customer'])->fetch(PDO::FETCH_ASSOC);
}

$ret['data'] = $dbh->query("SELECT id, (name || ' / ' || city ) text, 'uk-icon-building' icon, email, country, city, address, phone, ein FROM companies $where")->fetchAll(PDO::FETCH_ASSOC);
if($home) $ret['data'] = array_merge(array($home),$ret['data']);

return json_encode($ret);
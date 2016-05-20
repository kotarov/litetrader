<?php

if(!isset($_GET['id'])) exit;

$dbh = new PDO('sqlite:'.DB_DIR.'customers');
$sth = $dbh->query("SELECT 
    id,
    name,
    mrp,
    ein,
    phone,
    email,
    country,
    city,
    address
FROM companies
WHERE id = ".(int)$_GET['id']);

$ret['data'] = $sth->fetchAll(PDO::FETCH_ASSOC);

return json_encode($ret);

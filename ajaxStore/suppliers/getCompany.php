<?php

if(!isset($_GET['id'])) exit;

$dbh = new PDO('sqlite:'.DB_DIR.'suppliers');
$sth = $dbh->query("SELECT 
    id,
    name,
    mrp,
    ein,
    phone,
    email,
    skype,
    facebook,
    country,
    city,
    address
FROM companies
WHERE id = ".(int)$_GET['id']);

$ret['data'] = $sth->fetchAll(PDO::FETCH_ASSOC);

return json_encode($ret);

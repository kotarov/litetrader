<?php

if(!isset($_GET['id'])) exit;

$dbh = new PDO('sqlite:'.DB_DIR.'products');
$sth = $dbh->prepare("SELECT 
    id,
    name,
    id_parent,
    description,
    pos,
    tags,
    children
FROM categories WHERE id = ".(int)$_GET['id']);
$sth->execute();
$ret['data'] = $sth->fetchAll(PDO::FETCH_ASSOC);
return json_encode($ret);

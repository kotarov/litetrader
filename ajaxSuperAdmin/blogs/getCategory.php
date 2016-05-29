<?php

if(!isset($_GET['id'])) exit;

$dbh = new PDO('sqlite:'.DB_DIR.'blogs');
$sth = $dbh->prepare("SELECT 
    id,
    title,
    id_parent,
    subtitle,
    position,
    tags AS `tags[]`,
    children
FROM categories WHERE id = ".(int)$_GET['id']);
$sth->execute();
$ret['data'] = $sth->fetchAll(PDO::FETCH_ASSOC);
return json_encode($ret);

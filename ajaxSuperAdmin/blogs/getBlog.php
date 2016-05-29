<?php

if(!isset($_GET['id'])) exit;

$dbh = new PDO('sqlite:'.DB_DIR.'blogs');
$sth = $dbh->prepare("SELECT 
    id,
    title,
    subtitle,
    content,
    id_category,
    strftime('%Y-%m-%d', datetime(`date`, 'unixepoch')) `date`,
    tags AS `tags[]`
FROM blogs WHERE id = ".(int)$_GET['id']);
$sth->execute();
$ret['data'] = $sth->fetchAll(PDO::FETCH_ASSOC);
return json_encode($ret);

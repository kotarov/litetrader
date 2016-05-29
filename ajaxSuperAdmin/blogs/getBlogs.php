<?php

$where = '';
if(isset($_REQUEST['id'])) $where = " WHERE b.id = ".(int)$_REQUEST['id'];

$dbh = new PDO('sqlite:'.DB_DIR.'blogs');

$sth = $dbh->prepare("SELECT 
    b.is_active,
    b.id,
    b.id image,
    c.title category,
    c.is_visible cat_is_visible,
    b.title,
    b.subtitle,
    b.author,
    
    b.date,
    b.id actions
FROM blogs b 
LEFT JOIN categories c ON (c.id = b.id_category) 
$where");
$sth->execute();
$ret['data'] = $sth->fetchAll(PDO::FETCH_ASSOC);

return json_encode($ret);
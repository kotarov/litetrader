<?php

$ret = array();
$get = filter_var_array($_GET,array(
    'id'=>FILTER_VALIDATE_INT    
));

$dbh = new PDO('sqlite:'.DB_DIR.'products');

/*
$sql = "
SELECT c.id, c.name title, c.description, c.tags, c.url_rewrite, 
(SELECT COUNT(id) FROM products WHERE id_category = c.id AND is_visible = 1) num
FROM categories c WHERE c.is_visible = 1 AND id_parent = ".(int)$get['id'];

$ret['categories'] = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);
*/

/*
$ret['current'] = $dbh->query("SELECT id, name FROM categories WHERE id = ".(int)$get['id'])->fetch(PDO::FETCH_ASSOC);
*/

$ret['data'] = $dbh->query("
SELECT 
    i.id id_image, 
    p.id, p.name, 
    p.reference, 
    p.description, 
    p.tags, 
    round(p.price,2) price, 
    i.date_add, 
    c.url_rewrite url_rewrite, 
    c.name category, 
    c.parents,
    p.details
FROM products p 
LEFT JOIN images i ON (i.id_product = p.id AND i.is_cover =1 )
LEFT JOIN categories c ON (c.id = p.id_category) 
WHERE p.id = ".(int)$get['id']." AND p.is_visible = 1"
)->fetch(PDO::FETCH_ASSOC);


//$parents = $dbh->query("SELECT parents FROM categories WHERE id = ".$get['id'])->fetch(PDO::FETCH_COLUMN);

$ret['parents'] = $dbh->query("SELECT id, name, url_rewrite FROM categories WHERE id IN (".$ret['data']['parents'].")
    ORDER BY id=".(implode(" DESC , id=",explode(",",$ret['data']['parents'])))." DESC
")->fetchAll(PDO::FETCH_ASSOC);

$ret['images'] = $dbh->query("SELECT i.id,i.date_add FROM images i WHERE i.id_product = ".(int)$get['id'])->fetchAll(PDO::FETCH_ASSOC);

return json_encode($ret);
?>
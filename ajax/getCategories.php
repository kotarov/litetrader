<?php

$ret = array();
$get = filter_var_array($_GET,array(
    'id'=>FILTER_VALIDATE_INT    
));

$dbh = new PDO('sqlite:'.DB_DIR.'products');

$sql = "
SELECT c.id, c.name title, c.description, c.tags, (CASE WHEN c.url_rewrite IS NULL THEN '/' ELSE c.url_rewrite END) url_rewrite, 
(SELECT COUNT(id) FROM products WHERE id_category = c.id AND is_visible = 1) num
FROM categories c WHERE c.is_visible = 1 AND id_parent = ".(int)$get['id'];

$ret['categories'] = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);
if($get['id']) {
    $parents = $dbh->query("SELECT parents FROM categories WHERE id = ".$get['id'])->fetch(PDO::FETCH_COLUMN);
    
    $ret['parents'] = $dbh->query("SELECT id, name, url_rewrite FROM categories WHERE id IN ($parents)
        ORDER BY id=".(implode(" DESC , id=",explode(",",$parents)))." DESC
    ")->fetchAll(PDO::FETCH_ASSOC);
    
}
$ret['current'] = $dbh->query("SELECT id, name FROM categories WHERE id = ".(int)$get['id'])->fetch(PDO::FETCH_ASSOC);

$ret['data'] = $dbh->query("
SELECT i.id id_image, p.id, p.name, p.reference, p.description, p.tags, p.price, i.date_add, c.url_rewrite url_rewrite 
FROM products p 
LEFT JOIN images i ON (i.id_product = p.id AND i.is_cover =1 )
LEFT JOIN categories c ON (c.id = p.id_category) 
WHERE p.id_category = ".(int)$get['id']." AND p.is_visible = 1"
)->fetchAll(PDO::FETCH_ASSOC);

return json_encode($ret);
?>
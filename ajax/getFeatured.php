<?php
$ret = array();
$dbh = new PDO('sqlite:'.DB_DIR.'products');

$sql = "
SELECT p.id, p.name title, p.price price, i.id img, i.date_add, p.name alt, 
(CASE WHEN c.url_rewrite IS NULL THEN '/' ELSE c.url_rewrite END)||(CASE WHEN p.url_rewrite IS NULL THEN p.id ELSE p.url_rewrite END)||'/' url_rewrite 
FROM products p 
LEFT JOIN images i ON (i.id_product = p.id AND i.is_cover = 1)
LEFT JOIN categories c ON (c.id = p.id_category) 
WHERE p.is_adv = 1 AND p.is_visible = 1 ORDER BY p.id DESC LIMIT 20";

$ret['data'] = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);
return json_encode($ret);
?>
<?php 
$ret['results'] = array();
$post = filter_var_array($_POST,array(
    'search'=>FILTER_SANITIZE_STRING    
));

include_once(LIB_DIR."URLBase.php");

$dbh = new PDO('sqlite:'.DB_DIR.'products');
$sth = $dbh->prepare("
SELECT 
    p.name AS title,
    '".URL_BASE."products/view/index.php'||c.url_rewrite||p.url_rewrite url,
    p.description text
FROM products p 
LEFT JOIN categories c ON (c.id = p.id_category) 
WHERE (p.is_visible = 1) AND (
    p.name LIKE '%".$post['search']."%' 
    OR p.reference LIKE '%".$post['search']."%'
    OR p.description LIKE '%".$post['search']."%'
    OR p.tags LIKE '%".$post['search']."%'
    OR p.details LIKE '%".$post['search']."%'
) LIMIT 10");

$sth->execute();
$ret['results'] = $sth->fetchAll(PDO::FETCH_ASSOC);

return json_encode($ret);
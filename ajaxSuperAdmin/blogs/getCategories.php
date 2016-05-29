<?php
$ret = array();
$dbh = new PDO('sqlite:'.DB_DIR.'blogs');

$ret['data'] = $dbh->query("SELECT 
    c.is_visible,
    c.id,
    c.id image,
    c.depth_html||c.title title,
    c.subtitle,
    c.position,
    c.id actions
FROM categories c 
ORDER BY c.list_order
")->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET['forselect'])) $ret['data'] = array_merge(array(array('id'=>0,'name'=>'-')),$ret['data']); 

return json_encode($ret);
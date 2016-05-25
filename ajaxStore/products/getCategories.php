<?php
$ret = array();
$dbh = new PDO('sqlite:'.DB_DIR.'products');

if(isset($_GET['getforselect'])) $fetch_type = PDO::FETCH_ASSOC;
else $fetch_type = PDO::FETCH_NUM;

$ret['data'] = $dbh->query("SELECT 
    c.is_visible,
    c.id,
    c.depth_html || c.name text,
    c.description,
    c.pos,
    c.tags,
    c.id actions
FROM categories c 
ORDER BY c.list_order
")->fetchAll($fetch_type);

if(isset($_GET['getforselect'])) $ret['data'] = array_merge(array(array('id'=>0,'name'=>'-')),$ret['data']); 

return json_encode($ret);
<?php
$ret = array();
$dbh = new PDO('sqlite:'.DB_DIR.'products');

$ret['data']= $dbh->query("SELECT id,name,url_rewrite FROM categories WHERE id_parent=0")->fetchAll(PDO::FETCH_ASSOC);

$ret['l2'] = array();
foreach($ret['data'] AS $r=>$d){
    $ret['l2'][$d['id']] = $dbh->query("SELECT id,name,url_rewrite FROM categories WHERE id_parent = ".$d['id'])->fetchAll(PDO::FETCH_ASSOC); 
}

return json_encode($ret);

?>
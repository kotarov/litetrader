<?php
$ret = array();
$dbh = new PDO('sqlite:'.DB_DIR.'products');

$ret['data']= $dbh->query("SELECT id,name,url_rewrite FROM categories WHERE id_parent=0 AND is_visible = 1")->fetchAll(PDO::FETCH_ASSOC);

$ret['l2'] = array();
foreach($ret['data'] AS $r=>$d){
    $ret['l2'][$d['id']] = $dbh->query("SELECT id,name,url_rewrite FROM categories WHERE id_parent = ".$d['id']." AND is_visible = 1")->fetchAll(PDO::FETCH_ASSOC); 
}

if(isset($NO_ENCODE) && $NO_ENCODE){
    return $ret;
}
return json_encode($ret);

?>
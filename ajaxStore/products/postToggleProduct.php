<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
    'field'=>FILTER_SANITIZE_STRING
));

if(!$post['id']) $ret['error'] = 'Wrong ID !';
if(!in_array($post['field'], array('is_visible','is_avaible','is_adv') )) $ret['error']='Wrong request!';

if(!isset($ret['error'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'products');
    
    $value = $dbh->query("SELECT ".$post['field']." FROM products WHERE id = ".$post['id'])->fetch(PDO::FETCH_COLUMN);
    $sth = $dbh->prepare("UPDATE products SET ".$post['field']." = ".($value?'null':1)." WHERE id = ".$post['id']);
    if( $sth->execute() ){
        include 'getProducts.php';
        $ret['success'] = 'Success';
        $ret['id'] = $post['id'];
    } else {
        $ret['error'] = 'Cannot set this value';
    }

}

return json_encode($ret);
<?php

$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
));

if(!$post['id']) $ret['error'] = 'Wrong ID ?';

if(!isset($ret['error'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'products');
    $sth = $dbh->prepare("DELETE FROM products WHERE id = :id");
    if( $sth->execute($post) ){
        $ret['data'] = array( $post['id'] );
        $ret['success'] = 'Product deleted';
        $ret['id'] = $post['id'];
    }else {
        $ret['error'] = 'Cannot delete product';
    }

}

return json_encode($ret);
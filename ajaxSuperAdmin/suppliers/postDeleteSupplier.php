<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIATE_INT,
));

if(!$post['id']) $ret['error'] = 'Wrong ID ?';

if(!isset($ret['error'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'suppliers');
    $sth = $dbh->prepare("DELETE FROM suppliers WHERE id = :id");
    if( $sth->execute($post) ){
        $ret['id'] = $post['id'];
        $ret['success'] = 'Supplier deleted';
        $sth = $dbh->query("DELETE FROM suppliers_companies WHERE id_supplier = ".$post['id']);
    }else {
        $ret['error'] = 'Cannot delete';
    }

}

return json_encode($ret);
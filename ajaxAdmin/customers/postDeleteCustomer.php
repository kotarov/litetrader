<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
));

if(!$post['id']) $ret['error'] = 'Wrong ID ?';

if(!isset($ret['error'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'customers');
    $sth = $dbh->prepare("DELETE FROM customers WHERE id = :id");
    if( $sth->execute($post) ){
        $ret['id'] = $post['id'];
        $ret['success'] = 'Customer deleted';
        $sth = $dbh->query("DELETE FROM customers_companies WHERE id_customer = ".$post['id']);
    }else {
        $ret['error'] = 'Cannot delete';
    }

}

return json_encode($ret);
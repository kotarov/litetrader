<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
));

if(!$post['id']) $ret['error'] = 'Wrong ID !';

if(!isset($ret['error'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'suppliers');
    $_REQUEST['id'] = $dbh->query("SELECT id_supplier FROM suppliers_products WHERE id = ".$post['id'])->fetch(PDO::FETCH_COLUMN);
    $sth = $dbh->prepare("DELETE FROM suppliers_products WHERE id = :id");
    if( $sth->execute($post) ){
        include '../getSuppliers.php';
        $ret['id'] = $_REQUEST['id'];
        $ret['success'] = 'Product removed';
    }else {
        $ret['error'] = 'Cannot remove';
    }

}

return json_encode($ret);
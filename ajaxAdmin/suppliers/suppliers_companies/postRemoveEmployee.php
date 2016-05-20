<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
    'id_parent' => FILTER_VALIDATE_INT
));

if(!$post['id']) $ret['error'] = 'Wrong ID !';
if(!$post['id_parent']) $ret['error'] = 'Wrong id_parent !';

if(!isset($ret['error'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'suppliers');
    $sth = $dbh->prepare("DELETE FROM suppliers_companies WHERE id_supplier = :id AND id_company = :id_parent");
    if( $sth->execute($post) ){
        $_REQUEST['id'] = $post['id_parent'];
        include '../getCompanies.php';
        $ret['success'] = 'Employee removed';
        $ret['id'] = $_REQUEST['id'];
    }else {
        $ret['error'] = 'Cannot remove';
    }

}

return json_encode($ret);
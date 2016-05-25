<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
    'id_supplier'=>FILTER_VALIDATE_INT
));

if(!$post['id']) $ret['error'] = 'Wrong company';
if(!$post['id_supplier']) $ret['error'] = 'Wrong employee';

if(!isset($ret['error'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'suppliers');

    $exists = $dbh->query("SELECT id_company FROM suppliers_companies WHERE id_company = ".$post['id']." AND id_supplier = ".$post['id_supplier'])->fetch(PDO::FETCH_COLUMN); 
    if(!$exists){
        $dbh->query("INSERT INTO suppliers_companies (id_supplier, id_company) VALUES (".$post['id_supplier'].", ".$post['id'].")");
        $ret['success'] = "Ok";
    }else{
        $ret['success'] = 'Already existed';
    }
    
    $_REQUEST['id'] = $post['id'];
    include '../getCompanies.php';
    $ret['id'] = $_REQUEST['id'];
}

return json_encode( $ret );
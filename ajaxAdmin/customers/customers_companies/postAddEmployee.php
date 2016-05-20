<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
    'id_customer'=>FILTER_VALIDATE_INT
));

if(!$post['id']) $ret['error'] = 'Wrong company';
if(!$post['id_customer']) $ret['error'] = 'Wrong employee';

if(!isset($ret['error'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'customers');

    $exists = $dbh->query("SELECT id_company FROM customers_companies WHERE id_company = ".$post['id']." AND id_customer = ".$post['id_customer'])->fetch(PDO::FETCH_COLUMN); 
    if(!$exists){
        $dbh->query("INSERT INTO customers_companies (id_customer, id_company) VALUES (".$post['id_customer'].", ".$post['id'].")");
        $ret['success'] = "Ok";
    }else{
        $ret['success'] = 'Already existed';
    }
    
    $_REQUEST['id'] = $post['id'];
    include '../getCompanies.php';
    $ret['id'] = $_REQUEST['id'];
}

return json_encode( $ret );
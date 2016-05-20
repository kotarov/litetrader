<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'name'=>FILTER_SANITIZE_STRING,
    'family'=>FILTER_SANITIZE_STRING,
    'phone'=>FILTER_SANITIZE_STRING,
    'email'=>FILTER_VALIDATE_EMAIL,
    'country'=>FILTER_SANITIZE_STRING,
    'city'=>FILTER_SANITIZE_STRING,
    'address'=>FILTER_SANITIZE_STRING
));

if(!$post['name']) $ret['required'][] = 'name';
if(!$post['email']) $ret['required'][] = 'email';

if(!isset($ret['required'])){
    $post['date_add'] = time();
    $sets = array_keys($post);
    $dbh = new PDO('sqlite:'.DB_DIR.'customers');
    $sth = $dbh->prepare("INSERT INTO customers (".implode(',', $sets).") VALUES (:".implode(", :", $sets).")");
    $sth->execute($post);
    $_REQUEST['id'] = $dbh->lastInsertId();
    
    ///
    if(isset($_POST['id_company']) && is_array($_POST['id_company']) ){
        $insert = '('.$_REQUEST['id'].', '. implode("), (".$_REQUEST['id'].', ', array_values($_POST['id_company'])).')'; 
        $dbh->query("INSERT INTO customers_companies (id_customer, id_company) VALUES $insert");
    }
    ///
    
    if(isset($NO_RETURN)) return;
    
    include 'getCustomers.php';
    $ret['success'] = 'Customer id='.$_REQUEST['id'].' added successful.';
    $ret['id'] = $_REQUEST['id'];
}

return json_encode($ret);
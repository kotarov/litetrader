<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id_customer'=>FILTER_VALIDATE_INT,
    'id_company'=>FILTER_VALIDATE_INT,
    'customer'=>FILTER_SANITIZE_STRING,
    'company'=>FILTER_SANITIZE_STRING,
    'ein'=>FILTER_SANITIZE_STRING,
    'register-new-customer'=>FILTER_VALIDATE_BOOLEAN,
    'email'=>FILTER_SANITIZE_STRING,
    'phone'=>FILTER_SANITIZE_STRING,
    'country'=>FILTER_SANITIZE_STRING,
    'city'=>FILTER_SANITIZE_STRING,
    'address'=>FILTER_SANITIZE_STRING
));
if(isset($_POST['non-registered'])){
    if(!$post['customer']) $ret['required'][] = 'customer';
    if($post['company'] || $post['ein']){
        if(!$post['company'] ) $ret['required'][] = 'company';
        if(!$post['ein']) $ret['required'][] = 'ein';
        if(!$post['country']) $ret['required'][] = 'country';
        if(!$post['city']) $ret['required'][] = 'city';
    }
}else{
    if(!$post['id_customer']) $ret['required'][] = 'id_customer';
    if($post['id_company']){
        if(!$post['ein']) $ret['required'][] = 'ein';
        if(!$post['country']) $ret['required'][] = 'country';
        if(!$post['city']) $ret['required'][] = 'city';
        if(!$post['address']) $ret['required'][] = 'address';
    }
}
if(!$post['email'] && !$post['phone']) {
    $ret['required'][] = 'email';
    $ret['required'][] = 'phone';
};


if(!isset($ret['required'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'customers');
    $NO_RETURN = true;

    if(isset($_POST['non-registered'])){
        if($post['register-new-customer']){
            $original_post = $post;
            
            if(isset($_POST['id_company'])) unset($_POST['id_company']);
            if($post['company']){
                $_POST['name'] = $post['company'];
                $_POST['mrp'] = $post['customer'];
                include "../postNewCompany.php";
                $original_post['id_company'] = $_REQUEST['id'];
            
                $_POST['country'] = '';
                $_POST['city'] = '';
                $_POST['address'] = '';
            }
            
            $name = explode(" ",$original_post['customer']); if(!isset($name[1])) $name[1] = '';
            $_POST['name'] = $name[0];
            $_POST['family'] = $name[1].(isset($name[2])?' '.$name[2]:'');
            if($original_post['id_company']) $_POST['id_company'] = array($original_post['id_company']);
            include '../postNewCustomer.php';
            $original_post['id_customer'] = $_REQUEST['id'];
            
            $post = $original_post;
        }else{
            $post['id_customer'] = 0;
            $post['id_company'] = 0;
        }
        unset($post['register-new-customer']);
        $company_data = array('name'=>$post['company'], 'mrp'=>$post['customer'], 'ein'=>$post['ein']);
    }else{
        unset($post['register-new-customer']);
        $post['customer'] = $dbh->query("SELECT (name||' '||family) name FROM customers WHERE id = ".$post['id_customer'])->fetch(PDO::FETCH_COLUMN);
        
        if($post['id_company']){
            $company_data = $dbh->query("SELECT name, mrp, ein FROM companies WHERE id = ".$post['id_company'])->fetch(PDO::FETCH_ASSOC);
        }else{
            $company_data = array('name'=>'', 'mrp'=>'', 'ein'=>'');
        }
    }
    $post['id_status'] = $dbh->query("SELECT id FROM order_statuses WHERE is_default = 1")->fetch(PDO::FETCH_COLUMN);
    if(!$post['id_status']) $post['id_status'] = 1;
    $post['company'] = $company_data['name'];
    $post['mrp'] = $company_data['mrp'];
    $post['ein'] = $company_data['ein'];
    $post['date_add'] = time();
    
    $sth = $dbh->prepare("INSERT INTO orders (".implode(',', array_keys($post)).") VALUES (:".implode(", :", array_keys($post)).")");
    $sth->execute($post);
    $_REQUEST['id'] = $dbh->lastInsertId();
    $_POST['id_status'] = $post['id_status'];
    $_POST['id'] = $_REQUEST['id'];
    include "postStatus.php";
    
    unset($NO_RETURN);
    include 'getOrders.php';
    $ret['success'] = 'Order id='.$_REQUEST['id'].' added successful.';
    $ret['id'] = $_REQUEST['id'];
}

return json_encode($ret);
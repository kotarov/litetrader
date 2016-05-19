<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
    'name'=>FILTER_SANITIZE_STRING,
    'family'=>FILTER_SANITIZE_STRING,
    'phone'=>FILTER_SANITIZE_STRING,
    'email'=>FILTER_VALIDATE_EMAIL,
    'country'=>FILTER_SANITIZE_STRING,
    'city'=>FILTER_SANITIZE_STRING,
    'address'=>FILTER_SANITIZE_STRING,
    'password'=>FILTER_DEFAULT
));

if(!$post['id']) $ret['required'][] = 'name';
if(!$post['name']) $ret['required'][] = 'name';
if(!$post['email']) $ret['required'][] = 'email';

if(!isset($ret['required'])){
    if(!$post['password']) unset($post['password']);
    else $post['password'] = md5($post['password']);
    
    $sets = array();
    foreach(array_keys($post) AS $k=>$v){
        $sets[] = $v.'=:'.$v;
    }
    $dbh = new PDO('sqlite:'.DB_DIR.'suppliers');

    $sth = $dbh->prepare("UPDATE suppliers SET ".implode(",", $sets)." WHERE id = :id");
    $sth->execute($post);
    
    //////
    $t = $dbh->query("SELECT id_company FROM suppliers_companies WHERE id_supplier = ".$post['id'])->fetchAll(PDO::FETCH_NUM);
    $old_companies = array(); foreach($t AS $k => $v) $old_companies[] = $v[0];
    $new_companies = (isset($_POST['id_company']) && is_array($_POST['id_company']) ) ? array_values($_POST['id_company']) : array();

    if($to_delete = array_diff($old_companies, $new_companies)){
        $delete = implode(',',$to_delete);
        $dbh->query("DELETE FROM suppliers_companies WHERE id_company IN ($delete)");
    }
    if($to_insert = array_diff($new_companies, $old_companies)){
        $insert = '('.$post['id'].', '. implode("), (".$post['id'].', ', $to_insert).')'; 
        $dbh->query("INSERT INTO suppliers_companies (id_supplier, id_company) VALUES $insert");
    }
    //////
    
    include 'getSuppliers.php';
    $ret['success'] = 'Supplier id='.$_REQUEST['id'].' changed.';
    $ret['id'] = $post['id'];
}

return json_encode($ret);
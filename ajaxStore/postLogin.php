<?php

$ret=array();
$post = filter_var_array($_POST,array(
    'email'=>FILTER_VALIDATE_EMAIL,
    'password'=>FILTER_DEFAULT
));

if(!$post['email'])     $ret['required'][]='email';
if(!$post['password'])  $ret['required'][]='password';

if(!isset($ret['required'])){
    $post['password'] = md5($post['password']);

    $dbh = new PDO('sqlite:../sqlite/suppliers');
    
    $sth = $dbh->prepare( "SELECT id FROM suppliers WHERE email LIKE :email AND password LIKE :password AND is_active = 1" );
    $sth->execute( $post );
    $exists = $sth->fetch(PDO::FETCH_COLUMN) ;
    if($exists){
        $_SESSION['supplier'] = array();
        $_SESSION['supplier'] = $dbh->query("SELECT id, name, family, phone, email, skype, facebook, country, city, address FROM suppliers WHERE id = $exists")
            ->fetch(PDO::FETCH_ASSOC);
        $dbh->query("UPDATE suppliers SET date_logged = ".time()." WHERE id = $exists");
        $ret['success'] = 'Wellcom';
    }else{
        $ret['access'] = 'Wrong email or password';    
    }
}


return json_encode($ret);
?>
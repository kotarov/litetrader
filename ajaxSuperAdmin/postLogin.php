<?php
//session_start();

$ret=array();
$post = filter_var_array($_POST,array(
    'email'=>FILTER_VALIDATE_EMAIL,
    'password'=>FILTER_DEFAULT
));

if(!$post['email'])     $ret['required'][]='email';
if(!$post['password'])  $ret['required'][]='password';

if(!isset($ret['required'])){
    $post['password'] = md5($post['password']);

    $dbh = new PDO('sqlite:../sqlite/employees');
    
    $sth = $dbh->prepare( "SELECT id FROM employees WHERE email LIKE :email AND password LIKE :password" );
    $sth->execute( $post );
    $exists = $sth->fetch(PDO::FETCH_COLUMN) ;
    if($exists){
        $_SESSION['employee'] = array();
        $_SESSION['employee'] = $dbh->query("SELECT id, name, family, email FROM employees WHERE id = $exists")
            ->fetch(PDO::FETCH_ASSOC);
        $dbh->query("UPDATE employees SET date_logged = ".time()." WHERE id = $exists");
        $ret['success'] = 'Wellcom';
    }else{
        $ret['access'] = 'Wrong email or password';    
    }
}


return json_encode($ret);
?>
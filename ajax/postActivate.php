<?php
session_start();

$post = array();
$post = filter_var_array($_POST, array(
    'email'=>FILTER_VALIDATE_EMAIL,
    'key'=>FILTER_SANITIZE_STRING
));


if( $post['key'] && $post['email']){
    $dbh = new PDO("sqlite:../sqlite/customers");
    $sth = $dbh->prepare("SELECT id FROM customers WHERE email LIKE :email AND `disabled` LIKE :key");
    $sth->execute($post);
    
    $exists = $sth->fetch(PDO::FETCH_COLUMN) ;
    if($exists){
        $dbh->query("UPDATE customers SET `disabled` = 0 WHERE id=$exists");
        header("Location:login.php");
    }
}
return "Nothing to activate";
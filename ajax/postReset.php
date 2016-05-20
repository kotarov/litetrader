<?php

$ret=array();
$post=filter_var_array($_POST,array(
    'email'=>FILTER_VALIDATE_EMAIL
));

if(!$post['email'])      $ret['required'][]='email';

if(!isset($ret['required'])){
    $dbh = new PDO('sqlite:../sqlite/customers');
    
    $sth = $dbh->prepare("SELECT id FROM customers WHERE email LIKE :email AND `disabled` = 0");
    $sth->execute( $post );
    $exists = $sth->fetch(PDO::FETCH_COLUMN) ;
    
    if($exists){
        $data = array(
            'pass' => substr(str_shuffle(md5(time())),0,5),
            'time' => time()
        );
        
        
        $sth = $dbh->prepare("UPDATE customers SET onelogin_pass = :pass, onelogin_time = :time WHERE id = $exists");
        $sth->execute( $data );
        
        include '../lib/SMTPMailer.php';
        
        if(sendmail( $post['email'], 'Reset password',"Your temporary password is: ".$data['pass'] )) {
            $ret['success'] = 'Ok! Check your email for temporary password';
        }else{
            $ret['error'] = $sendmail_error;   
        }
        
    }else{
        $ret['error']= 'This Email is not active or registered';
    }
    
}

return json_encode($ret);
?>
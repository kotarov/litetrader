<?php
$ret=array();
$post=filter_var_array($_POST,array(
    'name'=>FILTER_SANITIZE_STRING,
    'family'=>FILTER_SANITIZE_STRING,
    'email'=>FILTER_VALIDATE_EMAIL,
    'password'=>FILTER_DEFAULT,
    'phone'=>FILTER_SANITIZE_STRING,
    'city'=>FILTER_SANITIZE_STRING,
    'address'=>FILTER_SANITIZE_STRING
));

if(!$post['name'])      $ret['required'][]='name';
if(!$post['email'])     $ret['required'][]='email';
if(!$post['password'])  $ret['required'][]='password';
if(!isset($_POST['repeat']) || $post['password'] != $_POST['repeat'] ) 
                        $ret['required'][]='repeat';
if(!$post['phone'])     $ret['required'][]='phone';
if(!$post['city'])      $ret['required'][]='city';
if(!$post['address'])   $ret['required'][]='address';

if(!isset($ret['required'])){
    $dbh = new PDO('sqlite:../sqlite/customers');
    $sth = $dbh->prepare("SELECT id FROM customers WHERE email LIKE :email");
    $sth->execute( array('email'=>$post['email'] ));
    $exists = $sth->fetch(PDO::FETCH_COLUMN);
    
    if($exists){
        $ret['error'] = 'This email is already registered';    
    }else{
        $post['password'] = md5($post['password']);
        $post['date_add'] = time();
        $post['disabled'] = substr(str_shuffle(md5(time())),0,25);    
        
        $urlActivate = rtrim($_SERVER['HTTP_ORIGIN'],'/').'/'.ltrim(dirname($_SERVER['REQUEST_URI']),'/').'/activate.php';
        $urlParams = '?email='.$post['email'].'&key='.$post['disabled'];
        
        $sql = "INSERT INTO customers (".implode(',', array_keys($post) ).") VALUES (:".implode(', :', array_keys($post)).")";
        $sth = $dbh->prepare( $sql );
        $sth->execute($post);
        
    
        include '../lib/SMTPMailer.php';
        if(sendmail( $post['email'], 
                'Activate your account',
                'Your account was created successful. <br> Befor login You need to activate. <br>'
                .'<a href="'.$urlActivate.$urlParams.'" target="_null"> Click this activation link</a>'.'<br>'
                .' OR <br> Goto: "'.$urlActivate.'" and enter key = "'.$post['disabled'].'"'
        )) {
            //$sth->execute($post);
            $ret['success'] = 'Profile created successful. Check your email for activation instructions.';
        }else{
            $ret['error'] = "Cannot send mail ! ".$sendmail_error;   
        }
    }
}


return json_encode($ret);
?>
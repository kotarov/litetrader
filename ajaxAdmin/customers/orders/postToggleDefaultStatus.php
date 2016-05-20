<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT
));
if(!$post['id']) $ret['error'] = 'Wrong ID !';

if(!isset($ret['error'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'customers');
    
    $id_old = $dbh->query("SELECT id FROM order_statuses WHERE is_default = 1")->fetch(PDO::FETCH_COLUMN);
    if($id_old != $post['id']){ 
        $dbh->query("UPDATE order_statuses SET is_default = 0");
        $sth = $dbh->prepare("UPDATE order_statuses SET is_default = 1 WHERE id = ".$post['id']);
        if( $sth->execute() ){
            $ret['success'] = 'Success';
        } else {
            $ret['error'] = 'Cannot set this value';
        }
    }else{
        $ret['success'] = 'Nothing changed';
    }
}

return json_encode($ret);

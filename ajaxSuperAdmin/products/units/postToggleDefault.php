<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
    'field'=>FILTER_SANITIZE_STRING
));


if(!$post['id']) $ret['error'] = 'Wrong ID !';
if(!in_array($post['field'], array('is_default') )) $ret['error']='Wrong request!';

if(!isset($ret['error'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'products');
    
    $sth1 = $dbh->prepare("UPDATE units SET ".$post['field']." = NULL");
    $sth = $dbh->prepare("UPDATE units SET ".$post['field']." = 1 WHERE id = ".$post['id']);
    if( $sth1->execute() && $sth->execute() ){
        include 'getMeasureUnits.php';
        $ret['success'] = 'Success';
    } else {
        $ret['error'] = 'Cannot set this value';
    }

}

return json_encode($ret);

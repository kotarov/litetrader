<?php
$ret = array();

$get = filter_var_array($_GET,array(
    'id'=>FILTER_VALIDATE_INT    
));

if(!$get['id']) $ret['error'] = 'Wrong request';

if(!isset($ret['error'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'customers');
    
    $sth = $dbh->query("SELECT 
        id,
        customer,
        company,
        ein,
        email,
        phone,
        country,
        city,
        address,
        id_customer,
        id_company,
        (CASE WHEN id_customer > 0 THEN 1 ELSE 0 END) is_registered
    FROM orders
    WHERE id = ".$get['id']);

    $ret['data'] = $sth->fetchAll(PDO::FETCH_ASSOC);

    $ret['success'] = 'Ok';
}

return json_encode($ret);
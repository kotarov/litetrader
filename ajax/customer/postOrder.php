<?php
session_start();
//print_r($_SESSION);exit;
$ret = array();
$post = filter_var_array($_POST,array(
    'address'=>FILTER_SANITIZE_STRING,
    'city'=>FILTER_SANITIZE_STRING,
    'customer'=>FILTER_SANITIZE_STRING,
    'phone'=>FILTER_SANITIZE_STRING,
    'method'=>FILTER_SANITIZE_STRING,
    'email'=>FILTER_SANITIZE_EMAIL
));

if(!$post['address']) $ret['required'][] = 'address';
if(!$post['city']) $ret['required'][] = 'city';
if(!$post['customer']) $ret['required'][]='customer';
if(!$post['phone']) $ret['required'][] = 'phone';
if(!$post['email']) $ret['required'][] = 'email';
if(!$post['method']) $ret['required'][] = 'choose-method';
if(!isset($_SESSION['cart']) || !count($_SESSION['cart'])) $ret['required'][] = 'cart-container';


if(!isset($ret['required'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'customers');
    
    $post['id_customer'] = isset($_SESSION['customer']['id']) ? $_SESSION['customer']['id'] : 0;
    $post['id_status'] = $dbh->query("SELECT id FROM order_statuses WHERE is_default = 1")->fetch(PDO::FETCH_COLUMN);
    $post['date_add'] = time();
    $post['country'] = 'Bulgaria';
    $post['price'] = 0; foreach($_SESSION['cart'] AS $n => $c) $post['price'] += $c['price'] * $c['qty'];
    
    /* // Други полезни полета
    company text,
    mrp text,
    ein text,
    */

    $sth = $dbh->prepare("INSERT INTO orders (".implode(',', array_keys($post)).") VALUES (:".implode(", :", array_keys($post)).")");
    if($sth->execute($post)){
        $dbh->query('ATTACH DATABASE "'.DB_DIR.'products" AS "pr"');
        
        $status = array();
        $status['id_order'] = $dbh->lastInsertId();
        $status['id_status'] = $post['id_status'];
        $status['status'] = $dbh->query("SELECT name FROM order_statuses WHERE id = ".$post['id_status'])->fetch(PDO::FETCH_COLUMN);
        $status['user'] = $post['customer'];
        $status['date_add'] = $post['date_add'];
        $sth = $dbh->prepare("INSERT INTO orders_statuses (".implode(',', array_keys($status)).") VALUES (:".implode(", :", array_keys($status)).")");
        $sth->execute($status);
    
        $p = array();
        $p['id_order'] = $status['id_order'];
        $p['date_add'] = $post['date_add'];
        foreach($_SESSION['cart'] AS $n => $c){
            $p['id_product'] =  $c['id'];
            $p['product'] = $c['name'].' '.$c['reference'];
            $p['note'] = '';
            $p['id_unit'] = $dbh->query("SELECT id_unit FROM pr.products WHERE id = ".$c['id'])->fetch(PDO::FETCH_COLUMN);
            $p['unit'] = $c['unit'];
            $p['qty'] = $c['qty'];
            $p['price'] = $c['price'];

            $sth = $dbh->prepare("INSERT INTO orders_products (".implode(',', array_keys($p)).") VALUES (:".implode(", :", array_keys($p)).")");
            $sth->execute($p);
        }
        unset($_SESSION['cart']);
        $ret['success'] = "OK";
    }
}

return json_encode($ret);
?>
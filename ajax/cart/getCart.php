<?php
if (session_status() == PHP_SESSION_NONE) session_start();

$ret = array('data'=>array());
if(isset($_SESSION['cart'])){
    $ret['data'] = $_SESSION['cart'];

    $ret['total'] = 0;
    $ret['nb'] = 0;
    foreach($_SESSION['cart'] AS $r=>$p){
        $ret['total'] += $p['price']*$p['qty'];
        $ret['nb'] += $p['qty'];
    }
}
return json_encode($ret);
?>
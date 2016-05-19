<?php
session_start();

$post = filter_var_array($_POST,array(
    'id_product'=>FILTER_VALIDATE_INT,
    'qty'=>array(
        'filter'=>FILTER_SANITIZE_NUMBER_FLOAT,
        'flags'=>FILTER_FLAG_ALLOW_FRACTION
    ),
    'add'=>FILTER_VALIDATE_INT
));

//$_SESSION['cart'] = null;

if($post['id_product']){
    $dbh = new PDO('sqlite:'.DB_DIR.'products');
    $p = $dbh->query("
        SELECT 
            p.id, 
            i.id id_image,
            p.name, 
            p.reference, 
            p.price, 
            u.abbreviation unit,
            p.url_rewrite,
            i.date_add
        FROM products p
        LEFT JOIN units u ON (u.id = p.id_unit) 
        LEFT JOIN images i ON (i.id_product = p.id AND i.is_cover = 1) 
        WHERE p.is_avaible = 1 AND p.id = ".$post['id_product']." 
    ")->fetch(PDO::FETCH_ASSOC);
    
    //print_r($p);exit;
    if(isset($p['id'])){
        if($post['add']){
            if(isset($_SESSION['cart'][$post['id_product']]['qty']) ) {    
                $post['qty'] = $_SESSION['cart'][$post['id_product']]['qty'] + 1;
            }else{
                $post['qty'] = 1;
            }
        }
        
        if(!$post['qty'] || $post['qty'] < 0) {
            unset($_SESSION['cart'][$post['id_product']]); //$post['qty'] = 1;
        }else{
            $p['qty'] = $post['qty'];
            $_SESSION['cart'][$post['id_product']] = $p;
            return include __DIR__."/getCart.php";
        }
    }else{
        $ret['error'] = 'Product not avaible';
        return json_encode($ret);
    }
}

return include __DIR__."/getCart.php";
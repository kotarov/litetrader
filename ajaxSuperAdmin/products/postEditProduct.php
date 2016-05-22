<?php
if(isset($_POST['price']) && strpos($_POST['price'], '.') === FALSE){
    $_POST['price'] = str_replace(',', '.', $_POST['price']);
}

$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
    'name'=>FILTER_SANITIZE_STRING,
    'reference'=>FILTER_SANITIZE_STRING,
    'price'=>array(
        'filter'=>FILTER_SANITIZE_NUMBER_FLOAT,
        'flags'=>FILTER_FLAG_ALLOW_FRACTION
    ),
    'qty'=>array(
        'filter'=>FILTER_SANITIZE_NUMBER_FLOAT,
        'flags'=>FILTER_FLAG_ALLOW_FRACTION
    ),
    'id_unit'=>FILTER_VALIDATE_INT,
    'id_category'=>FILTER_VALIDATE_INT,
    'id_supplier'=>FILTER_VALIDATE_INT,
    'description'=>FILTER_SANITIZE_STRING,
    'tags' => array(
        'filter' => FILTER_SANITIZE_STRING,
        'flags'  => FILTER_FORCE_ARRAY,
    )
));

if(!$post['id']) exit;

if(!$post['name']) $ret['required'][] = 'name';
if(!$post['price']) $ret['required'][] = 'price';
//if(!$post['id_supplier']) $ret['required'][] = 'id_supplier';
if(!$post['description']) $ret['required'][] = 'description';
if(!$post['tags']) $ret['required'][] = 'tags[]';

if(!isset($ret['required'])){
    $post['tags'] = implode(',',$post['tags']);
    $post['url_rewrite'] = $post['id'].'-'.str_replace(array(" "),"-",$post['name']);
    
    $sets = array();
    foreach(array_keys($post) AS $k=>$v){
        $sets[] = $v.'=:'.$v;
    }
    $dbh = new PDO('sqlite:'.DB_DIR.'products');
    $sth = $dbh->prepare("UPDATE products SET ".implode(",", $sets)." WHERE id = :id");
    $sth->execute($post);
    include 'getProducts.php';
    $ret['id'] = $post['id'];
    $ret['success'] = 'Product id='.$_REQUEST['id'].' changed.';
}

return json_encode($ret);

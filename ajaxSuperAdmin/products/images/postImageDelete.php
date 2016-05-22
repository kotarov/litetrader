<?php
$ret = array();
$post = filter_var_array($_POST,array(
    'id'=>FILTER_VALIDATE_INT,
));

if(!$post['id']) $ret['error'] = 'Wrong ID ?';

if(!isset($ret['error'])){
    $dbh = new PDO('sqlite:'.DB_DIR.'products');
    $_REQUEST['id'] = $dbh->query("SELECT id_product FROM images WHERE id =".$post['id'])->fetch(PDO::FETCH_COLUMN);
    $sth = $dbh->prepare("DELETE FROM images WHERE id = :id");
    if( $sth->execute($post) ){
        include '../getProducts.php';
        $ret['id'] = $_REQUEST['id'];
        $ret['success'] = 'Image deleted';
    }else {
        $ret['error'] = 'Cannot delete image';
    }

}

return json_encode($ret);
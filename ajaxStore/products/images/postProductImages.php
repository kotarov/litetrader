<?php
$ret = array();

if(!isset($_FILES['images'])) exit;
if(!isset($_POST['id']) || !(int)$_POST['id']) exit;
$id_product = (int)$_POST['id'];

$dbh = new PDO('sqlite:'.DB_DIR.'products');

//print_r($_FILES);exit;

include LIB_DIR.'ResampleImage.php';
foreach($_FILES['images']['name'] AS $n=>$name){
    $sth = $dbh->prepare("
        INSERT INTO images (
            id_product, name, `type`, size, date_add, full, thumb, small 
        ) VALUES (
            :id_product, :name, :type, :size, :date_add, :full, :thumb, :small
        )");
    $s = parse_ini_file(INI_DIR.'image.ini', true);
    $image = file_get_contents($_FILES['images']['tmp_name'][$n]);
    $full = resampleimage($image, $s['full']['width'], $s['full']['height'], $s['bgcolor']);
    $sth->execute(array(
        'id_product'=>$id_product,
        'name' => $_FILES['images']['name'][$n],
        'type'=> 'image/jpeg',
        'size' => human_filesize( strlen($full) ),
        'date_add'=>time(),
        'full' => $full,
        'thumb' => resampleimage($image, $s['thumb']['width'], $s['thumb']['height'], $s['bgcolor']),
        'small' => resampleimage($image, $s['small']['width'], $s['small']['height'],$s['bgcolor'])
    ));
    $_REQUEST['id'] = $id_product;
    $ret['id'] = $id_product;
    include '../getProducts.php';
    $ret['success'] = count($_FILES['images']['name'])." File(s) uploaded";
}

return json_encode($ret);

function human_filesize($bytes, $decimals = 2) {
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

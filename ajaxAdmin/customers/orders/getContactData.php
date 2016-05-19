<?php

if(!isset($_GET['id_company'])) exit;
if(!isset($_GET['id_customer'])) exit;
if(!isset($_GET['field'])) exit;

$id_company = (int)$_GET['id_company'];
$id_customer = (int)$_GET['id_customer'];
$field = $_GET['field'];

if(!in_array($field,array('email','phone','country','city','address','ein'))) exit;
//if($field == 'ein' && !$id_company) return json_encode(array("data"=>""));

$dbh = new PDO('sqlite:'.DB_DIR.'customers');
$sth = $dbh->query("SELECT $field text FROM ".($id_company?'companies':'customers')." WHERE id = ".($id_company?$id_company:$id_customer));

$ret['data'] = $sth->fetch(PDO::FETCH_ASSOC);
return json_encode($ret);
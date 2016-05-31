<?php
include LIB_DIR.'Configuration.php';
$ret = array();
$post = filter_var_array($_POST,array(
    'name'=>FILTER_SANITIZE_STRING,
    'mrp'=>FILTER_SANITIZE_STRING,
    'ein'=>FILTER_SANITIZE_STRING,
    'phone'=>FILTER_SANITIZE_STRING,
    'email'=>FILTER_VALIDATE_EMAIL,
    'skype'=>FILTER_SANITIZE_STRING,
    'facebook'=>FILTER_SANITIZE_STRING,
    'twitter'=>FILTER_SANITIZE_STRING,
    'country'=>FILTER_SANITIZE_STRING,
    'city'=>FILTER_SANITIZE_STRING,
    'address'=>FILTER_SANITIZE_STRING
));


if(!$post['name']) $ret['required'][] = 'name';
if(!$post['ein']) $ret['required'][] = 'ein';
if(!$post['email']) $ret['required'][] = 'email';
if(!$post['address']) $ret['required'][] = 'address';


if(!isset($ret['required'])){
    file_put_contents(INI_DIR.'company.ini',arr2ini($post));
    $ret['success'] = 'Data saved successfuly';
}

return json_encode($ret);
<?php
$ret = array();
chdir(realpath(__DIR__.'/../../'));

$exec = shell_exec('git pull');
if($exec){
    $ret['success'] = $exec;
}else{
    $ret['error'] = 'Error';
}
$ret['data']['ver'] = file_get_contents("ver");

chdir(__DIR__);
return json_encode($ret);
<?php
$ret = array();
chdir(realpath(__DIR__.'/../../'));


if(isset($_POST['update'])){
	$command = 'pull origin master';
}elseif(isset($_POST['reset'])){
	$command = 'checkout --hard';
}

$exec = shell_exec('/usr/bin/git '.$command);
if($exec){
	$ret['success'] = $exec;
}else{
	$ret['error'] = 'Error';
}
$ret['data']['ver'] = file_get_contents("ver");

chdir(__DIR__);
return json_encode($ret);
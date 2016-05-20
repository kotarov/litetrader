<?php
$ret = array();

$ret['success'] = shell_exec('git pull');
$ret['data']['ver'] = file_get_contents("../../ver");

return json_encode($ret);
<?php
$where = '';
if(isset($_REQUEST['id'])) $where = " WHERE os.id = ".(int)$_REQUEST['id'];

$dbh = new PDO('sqlite:'.DB_DIR.'customers');
$sth = $dbh->prepare("SELECT 
    os.id,
    os.is_default,
    os.is_closed,
    os.icon,
    os.name, 
    os.id actions,
    os.color
FROM order_statuses os
$where");
$sth->execute();
$ret['data'] = $sth->fetchAll(PDO::FETCH_ASSOC);
foreach($ret['data'] AS $r => $d){
    if($d['is_closed'] == 1) $ret['data'][$r]['name'] .= ' <small class="uk-icon-lock"></small>';
    if($d['is_default']== 1) $ret['data'][$r]['name'] = '<small class="uk-icon-play uk-text-primary"></small> '.$ret['data'][$r]['name'];
}

if(isset($_GET['first'])){
    $ret['data'] = array_merge(array(array('id'=>0,'is_default'=>0,'is_closed'=>0,'icon'=>'','name'=>$_GET['first'],'actions'=>0,'color'=>'')),$ret['data']);
}

return json_encode($ret);
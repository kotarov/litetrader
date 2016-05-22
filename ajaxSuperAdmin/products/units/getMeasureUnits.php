<?php
$where = '';
if(isset($_REQUEST['id'])) $where = " WHERE mu.id = ".(int)$_REQUEST['id'];

$dbh = new PDO('sqlite:'.DB_DIR.'products');
$sth = $dbh->prepare("SELECT 
    mu.id,
    mu.name,
    mu.name||', '||mu.abbreviation text,
    mu.abbreviation,
    mu.position,
    mu.is_default
FROM units mu 
$where ORDER BY mu.position ASC");
$sth->execute();
$ret['data'] = $sth->fetchAll(PDO::FETCH_ASSOC);

return json_encode($ret);
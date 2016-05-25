<?php

$dbh = new PDO('sqlite:'.DB_DIR.'suppliers');

$sql = "SELECT GROUP_CONCAT(id_company) FROM suppliers_companies WHERE id_supplier = ".$_SESSION['supplier']['id'];
$companies = $dbh->query($sql)->fetch(PDO::FETCH_COLUMN);
$ret['data'] = $dbh->query("SELECT id, (name || ' / ' || city ) text, email FROM companies WHERE id IN ($companies)")->fetchAll(PDO::FETCH_ASSOC);

return json_encode($ret);
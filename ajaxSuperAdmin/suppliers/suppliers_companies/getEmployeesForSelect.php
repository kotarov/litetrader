<?php

$dbh = new PDO('sqlite:'.DB_DIR.'suppliers');

$ret['data'] = $dbh->query("SELECT id, name, family, email, city, phone, is_active FROM suppliers")->fetchAll(PDO::FETCH_ASSOC);

return json_encode($ret);
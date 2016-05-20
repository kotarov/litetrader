<?php

$dbh = new PDO('sqlite:'.DB_DIR.'suppliers');

$ret['data'] = $dbh->query("SELECT id, (name || ' / ' || city ) text, email FROM companies")->fetchAll(PDO::FETCH_ASSOC);

return json_encode($ret);
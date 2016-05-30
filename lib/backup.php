<?php
echo "\n *** BACKUP START *** \n\n";


$src = realpath(__DIR__.'/../');

$dest = realpath(__DIR__."/../../").'/backup_litetrader/';
@mkdir($dest, 0777, true);

/** INI */

$dest_ini = realpath(__DIR__."/../../").'/backup_litetrader/ini/';
@mkdir($dest_ini, 0777, true);
echo "cp -r $src/ini/* $dest_ini \n";
shell_exec("cp -r $src/ini/* $dest_ini");

/** DB */

$dest_sqlite = realpath(__DIR__."/../../").'/backup_litetrader/sqlite/';
@mkdir($dest_sqlite, 0777, true);
echo "cp -r $src/sqlite/* $dest_sqlite \n";
shell_exec("cp -r $src/sqlite/* $dest_sqlite");

echo "\n *** // BACKUP END *** \n\n";
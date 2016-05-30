<?php 
echo "\n *** INSTALLATION BRGIN *** \n\n";

/** DB */ 

$src = realpath(__DIR__.'/../sqlite/schema/');
$dest = realpath(__DIR__.'/../sqlite/');

foreach (glob("$src/*.sql") as $file) {
    $db = basename(substr($file,0,-4));
    echo 'sqlite3 '.$dest.'/'.$db.' < '.$file."\n";
    shell_exec('sqlite3 '.$dest.'/'.$db.' < '.$file);
}


echo "\n";

/** INI */

$src = realpath(__DIR__.'/../ini/schema/');
$dest = realpath(__DIR__.'/../ini/');

foreach (glob("$src/*.ini") as $file) {
    $filename = basename($filename);
    echo 'cp '.$file.' '.$dest.'/'.$filename."\n";
    shell_exec('cp '.$file.' '.$dest.'/'.$filename);
}

echo "\n *** // INSTALLATION END *** \n\n";
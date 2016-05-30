<!DOCTYPE html>
<html>
    <head>
        
    </head>
    <body>
        <?php
            if(isset($_GET['backup'])){
                $src = realpath(__DIR__.'/../');
                
                $dest = realpath(__DIR__."/../../").'/backup_litetrader/';
                echo '1. Assure directory "backup_litetrder" ... ';
                @mkdir($dest, 0777, true);
                echo '<b style="color:green">ok</b> <br>';
                
                
                echo "<br>";
                
                
                $dest_ini = realpath(__DIR__."/../../").'/backup_litetrader/ini/';
                echo '2. Assure directory "backup_litetrder/ini" ... ';
                @mkdir($dest_ini, 0777, true);
                echo '<b style="color:green">ok</b> <br>';
                
                echo '3. Copying INI files ... ';
                shell_exec("cp $src/ini/*.ini $dest_ini");
                echo '<b style="color:green">ok</b> <br>';
                
                echo "<br>";
                
                $dest_sqlite = realpath(__DIR__."/../../").'/backup_litetrader/sqlite/';
                echo '4. Assure directory "backup_litetrder/sqlite" ...';
                @mkdir($dest_sqlite, 0777, true);
                echo '<b style="color:green">ok</b> <br>';
                
                echo '5. Copying DB files ... ';
                shell_exec("cp $src/sqlite/* $dest_sqlite");
                echo '<b style="color:green">ok</b> <br>';
            }
            
            if(isset($_GET['install'])){
                $src = realpath('../sqlite/schema/');
                $dest = realpath('../sqlite/');
                
                foreach (glob("$src/*.sql") as $filename) {
                    $db = basename(substr($filename,0,-4));
                    //echo 'sqlite3 '.$dest.'/'.$db.' < '.$filename."<br>";
                    echo 'Install DB <b>"'.$db.'"</b> ... ';
                    shell_exec('sqlite3 '.$dest.'/'.$db.' < '.$filename);
                    echo '<b style="color:green">ok</b> <br>';
                }
            }
            
            
        ?>
        <h1> Install</h1>
        <hr>
        <form>
            <button type="submit" name="backup">Backup settings and data</button>
        </form>
        <hr>
        <form>
            <button type="submit" name="install">Install db</button> 
        </form>
        <hr>
        <form>
            <button type="submit" name="update" disabled>Update to v.<?php include "../ver";?></button>
        </form>
    </body>
</html>
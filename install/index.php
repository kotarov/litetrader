<!DOCTYPE html>
<html>
    <head>
        
    </head>
    <body>
        <?php
            if(isset($_GET['install'])){
                foreach (glob("../sqlite/*.sql") as $filename) {
                    shell_exec('sqlite3 '.substr($filename,0,-4).' < '.$filename);
                    echo '<p> Databse <b>"'.basename(substr($filename,0,-4)).'"</b> is <i>INSTALLED / RESETED</i></p>';
                }
                exit;
            }
        ?>
        <h1> Install/Reset DB</h1>
        
        <p> Click "INSTALL" button to <i>Install</i> or <i>Reset</i> Dabase.</p>
        <p> <b>Warning all data will be removed !!!</b></p>
        
        <form>
            <button type="submit" name="install">INSTALL</button>
        </form>
    </body>
</html>
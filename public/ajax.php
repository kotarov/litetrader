<?php
define( 'DB_DIR', realpath('../sqlite/').'/' );
define('LIB_DIR', realpath('../lib/'   ).'/' );
define('INI_DIR', realpath('../'   ).'/' );

if( isset($_GET['f']) 
    && file_exists('../ajax/'.$_GET['f'].'.php') 
    && chdir(dirname('../ajax/'.$_GET['f'])) 
){
    echo include basename($_GET['f']).'.php' ;
}

<?php
session_start();

define('DIR_BASE', realpath('../'       ).'/' );
define(  'DB_DIR', realpath('../sqlite/').'/' );
define( 'LIB_DIR', realpath('../lib/'   ).'/' );
define( 'INI_DIR', realpath('../ini/'   ).'/' );


if( isset($_SESSION['employee']['id']) 
    && isset($_GET['f']) 
    && file_exists('../ajaxSuperAdmin/'.$_GET['f'].'.php') 
    && chdir(dirname('../ajaxSuperAdmin/'.$_GET['f'])) 
){
    
    echo include rtrim(basename($_GET['f'] ), '.php') . '.php' ;
    
}elseif(isset($_GET['f']) && $_GET['f'] == 'postLogin'){
    chdir('../ajaxSuperAdmin');
    echo include 'postLogin.php';
}else{
    echo json_encode( array('access_denided'=>true) );
}
?>
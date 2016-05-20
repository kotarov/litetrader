<?php 
    $_ASSETS = parse_ini_file('../../assets.ini');
    $_COMPANY = parse_ini_file('../../company.ini'); 
    $ver = file_get_contents('../../ver');
    $new_ver = file_get_contents('https://raw.githubusercontent.com/kotarov/litetrader/master/ver');
?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>*Update</title>
        <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="../img/apple-touch-icon.png">
        
        <script src="<?=$_ASSETS['jquery.js']?>"></script>
        
        <link  href="<?=$_ASSETS['uikit.css']?>" rel="stylesheet"/>
        <script src="<?=$_ASSETS['uikit.js']?>"></script>
        <script src="<?=$_ASSETS['uikit.offcanvas.js']?>"></script>
        
        <link  href="<?=$_ASSETS['uikit.notify.css']?>" rel="stylesheet" />
        <script src="<?=$_ASSETS['uikit.notify.js']?>"></script>
        
        <link  href="<?=$_ASSETS['dataTables.uikit.css']?>" rel="stylesheet">
        <script src="<?=$_ASSETS['dataTables.js']?>"></script>
        <script src="<?=$_ASSETS['dataTables.uikit.js']?>"></script>
        <script src="<?=$_ASSETS['dataTables.buttons.js']?>"></script>
        
        <link  href="../<?=$_ASSETS['application.css']?>" rel="stylesheet">
        <link  href="../<?=$_ASSETS['theme.css']?>" rel="stylesheet">
    </head>
    
    <body id="page-tools"> 
        <?php //include '../snipps/head.php'; ?>
        
        <h2 class="page-header">Update</h2>
        <div class="uk-container">
        
        <p>Your version is: <b><?=$ver?></b></p>
        <p>Avaible last version is: <b><?=$new_ver?></b></p>
        
        <form class="uk-form">
            <button class="uk-button uk-button-large"> Update ? </button> 
        </form>
        
        <?php /* <script src="../<?=$_ASSETS['application.js']?>"></script> */ ?>
        
        </div>
        <?php //include '../snipps/foot.php'; ?>
    </body>
</html>
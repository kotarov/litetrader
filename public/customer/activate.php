<?php include '../snipps/init.php'; ?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Customer Login</title>
        <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="../img/apple-touch-icon.png">
        
        <script src="../<?=$_ASSETS['jquery.js']?>"></script>
        <link rel="stylesheet" href="<?=$_ASSETS['uikit.css']?>" />
    </head>

    <body class="uk-height-1-1">

        <div class="uk-vertical-align uk-text-center uk-height-1-1">
            
            <div class="uk-vertical-align-middle uk-grid" style="width: 300px;">
                
                <div class="uk-width-1-1">
                    <i class="uk-icon-user-times uk-margin-bottom uk-text-primary" style="font-size:6em"></i>
                    <br>
                    <form method="post" action="../ajax.php?f=postActivate">
                        <div class="uk-form-row">
                            <input class="uk-width-1-1 uk-form-large" type="text" placeholder="Email" name="email" value="<?=isset($_GET['email'])?$_GET['email']:''?>">
                        </div>
                        <div class="uk-form-row">
                            <input class="uk-width-1-1 uk-form-large" type="text" placeholder="Key" name="key" value="<?=isset($_GET['key'])?$_GET['key']:''?>">
                        </div>
                        <div class="uk-form-row">
                            <button type="submit" class="uk-width-1-1 uk-button uk-button-secondary uk-button-large"> Activate account</button>
                        </div>
                    </form>
                    <div class="uk-margin-top">
                     <a href="../index.php"><i class="uk-icon-home"></i> Home page</a>
                    </div>
                
                
                </div>
                
            </div>
            
        </div>
<br><br>
</div>

</body>
</html>

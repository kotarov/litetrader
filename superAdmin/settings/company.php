<?php $exp=0; include '../snipps/init.php'; ?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SETTINGS - Company</title>
        <link rel="shortcut icon" href="<?=URL_BASE?>img/favicon.png" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="<?=URL_BASE?>img/apple-touch-icon.png">
        
        <script src="<?=$_ASSETS['jquery.js']?>"></script>
        
        <link  href="<?=$_ASSETS['uikit.css']?>" rel="stylesheet"/>
        <script src="<?=$_ASSETS['uikit.js']?>"></script>
        <script src="<?=$_ASSETS['uikit.offcanvas.js']?>"></script>
        
        <link  href="<?=$_ASSETS['uikit.notify.css']?>" rel="stylesheet" />
        <script src="<?=$_ASSETS['uikit.notify.js']?>"></script>
        
        <link  href="<?=$_ASSETS['application.css']?>" rel="stylesheet">
        <link  href="<?=URL_BASE.$_ASSETS['theme.css']?>" rel="stylesheet">
        
        <script src="<?=URL_BASE.$_ASSETS['lang.js']?>"></script>
    </head>
    
    <body id="page-settings"> 
            <?php include '../snipps/head.php'; ?>
        
            <h2 class="page-header"><i class="uk-icon-gear"></i> <span data-lang>Company data</span></h2>
            <div class="uk-container uk-container">
                    <?php $data = parse_ini_file(INI_DIR.'company.ini'); ?>
                
                    <form class="uk-form uk-form-horizontal uk-width-medium-1-2 uk-container-center" action="<?=URL_BASE?>ajax.php?f=settings/postCompany" data-trigger="companydata-changed">
                        <div class="uk-form-row">
                            <label class="uk-form-label" data-lang>Name</label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="name" value="<?=$data['name']?>"></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" data-lang>EIN</label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="ein" value="<?=$data['ein']?>"></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" data-lang>MRP</label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="mrp" value="<?=$data['mrp']?>"></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" data-lang>Email</label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="email" value="<?=$data['email']?>"></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" data-lang>Phone</label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="phone" value="<?=$data['phone']?>"></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" data-lang>Skype</label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="skype" value="<?=$data['skype']?>"></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" data-lang>Facebook</label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="facebook" value="<?=$data['facebook']?>"></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" data-lang>Twitter</label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="twitter" value="<?=$data['twitter']?>"></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" data-lang>Country</label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="country" value="<?=$data['country']?>"></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" data-lang>City</label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="city" value="<?=$data['city']?>"></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" data-lang>Address</label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="address" value="<?=$data['address']?>"></div>
                        </div>
                        
                        <br>
                        <div class="uk-modal-footer">
                            <button class="uk-button uk-button-primary" data-lang>Save</button>
                            <button type="reset" class="uk-button" data-lang>Reset</button>
                        </div>
                    </form>
            </div>
            <?php include '../snipps/foot.php'; ?>
            <script src="<?=$_ASSETS['application.js']?>"></script>
    </body>

</html>
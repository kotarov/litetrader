<?php $exp=0; include '../snipps/init.php'; ?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SETTINGS - Slider</title>
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
        
            <h2 class="page-header"><i class="uk-icon-gear"></i> <span data-lang="Home Slider"></span></h2>
            
            <div class="uk-container uk-container">
                
                
                <table>
                    <tr><th>File</th><th>Size</th></tr>
                    <?php foreach (glob(__DIR__."/../../public/img/slide/*.*") as $filename) {
                        echo "<tr><td>$filename</td><td> " . filesize($filename) . "</td></tr>";
                    } ?>    
                </table>
                <form class="uk-form uk-form-horizontal uk-width-medium-1-2 uk-container-center" action="<?=URL_BASE?>ajax.php?f=settings/postHomeslider">
                </form>
            </div>
            
            
            <div class="uk-container uk-container">
                    <?php $data = parse_ini_file(INI_DIR.'homeslider.ini',true);?>
                <?php $sl = 'slide1'; foreach($data[$sl]['title'] AS $n=>$d) { ?>
                    <form class="uk-form uk-form-horizontal uk-width-medium-1-2 uk-container-center" action="<?=URL_BASE?>ajax.php?f=settings/postHomeslider">
                        <div class="uk-form-row">
                            <label class="uk-form-label" data-lang="Image"></label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="src" value="<?=$data[$sl]['src'][$n]?>"></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" data-lang="Title"></label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="title" value="<?=$data[$sl]['title'][$n]?>"></div>
                        </div>
                        
                        <div class="uk-form-row">
                            <label class="uk-form-label" data-lang>Alt. Text</label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="alt" value="<?=$data[$sl]['alt'][$n]?>"></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" data-lang>Link</label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="href" value="<?=$data[$sl]['href'][$n]?>"></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" data-lang>Caption</label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="caption" value="<?=$data[$sl]['caption'][$n]?>"></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" data-lang>Text</label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="text" value="<?=$data[$sl]['text'][$n]?>"></div>
                        </div>
                        
                        <br>
                        <div class="uk-modal-footer">
                            <button class="uk-button uk-button-primary" data-lang>Save</button>
                            <button type="reset" class="uk-button" data-lang>Reset</button>
                        </div>
                    </form>
                <?php } ?>
            </div>
            <?php include '../snipps/foot.php'; ?>
            <script src="<?=$_ASSETS['application.js']?>"></script>
    </body>

</html>
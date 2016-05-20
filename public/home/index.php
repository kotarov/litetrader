<?php include '../snipps/init.php'; ?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>
        <link rel="shortcut icon" href="<?=URL_BASE?>img/favicon.png" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="<?=URL_BASE?>img/apple-touch-icon.png">
        
        <script src="<?=$_ASSETS['jquery.js']?>"></script>
        
        <link  href="<?=$_ASSETS['uikit.css']?>" rel="stylesheet"/>
        <script src="<?=$_ASSETS['uikit.js']?>"></script>
        <script src="<?=$_ASSETS['uikit.offcanvas.js']?>"></script>
        <link rel="stylesheet" href="<?=$_ASSETS['uikit.search.css']?>">
        <script src="<?=$_ASSETS['uikit.search.js']?>"></script>
        
        <link rel="stylesheet" href="<?=$_ASSETS['uikit.dotnav.css']?>" />
        <script src="<?=$_ASSETS['uikit.slideset.js']?>"></script>

        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/components/slideshow.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/slideshow.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/slideshow-fx.min.js"></script> -->
    </head>
    <body id="page-home"> 
            <?php include '../snipps/head.php'; ?>
            
            <!-- Jumbo -->
            <div class="uk-grid uk-grid-collapse">
                
                <div class="uk-width-medium-3-4">
                    <div id="slideshow">
                        <div class="uk-slidenav-position">
                            <ul class="uk-slideset uk-grid uk-flex-center">
                                <li>
                                    <img src="../img/slide/photo4.jpg" width="100%" alt="" hidden>
                                </li>
                                <li>
                                    <img src="../img/slide/photo3.jpg" width="100%" alt="" hidden>
                                </li>
                                <li>
                                    <img src="../img/slide/photo2.jpg" width="100%" alt="" hidden>
                                </li>
                                <li>
                                    <img src="../img/slide/photo1.jpg" width="100%" alt="" hidden>
                                </li>
                            </ul>
                            <a href="#" class="uk-slidenav uk-slidenav-previous" data-uk-slideset-item="previous"></a>
                            <a href="#" class="uk-slidenav uk-slidenav-next" data-uk-slideset-item="next"></a>
                        </div>
                        <ul class="uk-slideset-nav uk-dotnav uk-flex-center uk-margin-top"></ul>
                    </div>
                    <script>UIkit.slideset("#slideshow", { default:1, animation:'flip-horizontal', duration: 200, autoplay: false }); $("#slideshow [hidden]").show()</script>

                </div>
                
                <div class="uk-width-medium-1-4 uk-panel uk-panel-box uk-vertical-align uk-text-center" style="margin-bottom:65px">
                   <div class="uk-vertical-align-middle">
                       <h1>Your Brand</h1>
                       <p><b>Moneyback garantee</b></p>
                       <img style="max-width:50%" src="../img/certificate.ico">
                       <div>100% satisfaction</div>
                    </div>
                </div>

            </div>
            <!-- //Jumbo -->
            
            
            
            <!-- Advertize -->
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-3">
                    <div class="uk-grid">
                        <div class="uk-width-1-6">
                            <i class="uk-icon-cog uk-icon-large uk-text-primary"></i>
                        </div>
                        <div class="uk-width-5-6">
                            <h2 class="uk-h3">Sample Heading</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                </div>

                <div class="uk-width-medium-1-3">
                    <div class="uk-grid">
                        <div class="uk-width-1-6">
                            <i class="uk-icon-thumbs-o-up uk-icon-large uk-text-primary"></i>
                        </div>
                        <div class="uk-width-5-6">
                            <h2 class="uk-h3">Sample Heading</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                </div>

                <div class="uk-width-medium-1-3">
                    <div class="uk-grid">
                        <div class="uk-width-1-6">
                            <i class="uk-icon-cloud-download uk-icon-large uk-text-primary"></i>
                        </div>
                        <div class="uk-width-5-6">
                            <h2 class="uk-h3">Sample Heading</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-3">
                    <div class="uk-grid">
                        <div class="uk-width-1-6">
                            <i class="uk-icon-dashboard uk-icon-large uk-text-primary"></i>
                        </div>
                        <div class="uk-width-5-6">
                            <h2 class="uk-h3">Sample Heading</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                </div>

                <div class="uk-width-medium-1-3">
                    <div class="uk-grid">
                        <div class="uk-width-1-6">
                            <i class="uk-icon-comments uk-icon-large uk-text-primary"></i>
                        </div>
                        <div class="uk-width-5-6">
                            <h2 class="uk-h3">Sample Heading</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                </div>

                <div class="uk-width-medium-1-3">
                    <div class="uk-grid">
                        <div class="uk-width-1-6">
                            <i class="uk-icon-briefcase uk-icon-large uk-text-primary"></i>
                        </div>
                        <div class="uk-width-5-6">
                            <h2 class="uk-h3">Sample Heading</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- //Advertize -->
            
            
            <?php include '../snipps/featured.php';?>

           
            
            <!-- Well -->
            <br>
            <div class="uk-grid uk-margin-top" data-uk-grid-margin="">
                <div class="uk-width-medium-1-1 uk-row-first">
                    <div class="uk-panel uk-panel-box uk-text-center">
                        <p><strong>Phasellus viverra nulla ut metus.</strong> Quisque rutrum etiam ultricies nisi vel augue. <a class="uk-button uk-button-primary uk-margin-left" href="#">Button</a></p>
                    </div>
                </div>
            </div>
            <!-- //well -->

        </div>

    <?php include '../snipps/foot.php';?>
    </body>
</html>
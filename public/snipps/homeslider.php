<!-- slider -->
<?php $slider = parse_ini_file(INI_DIR."homeslider.ini",true);?>
<div class="uk-grid uk-grid-collapse">
    
    <div class="uk-width-medium-3-4">
        <div class="fotorama" data-loop="true" data-autoplay="true" data-allowfullscreen="true">
                <?php $sl = 'slide1'; foreach($slider[$sl]['src'] AS $k => $src){ ?>
                    <?php if($slider[$sl]['title'][$k] || $slider[$sl]['text'][$k]) 
                            $class="uk-text-center uk-overlay-background uk-overlay-panel uk-overlay-bottom"; 
                        else 
                            $class="uk-hidden"; 
                    ?>
                    
                    <div class="<?=$class?>" data-img="../img/slide/<?=$src?>"> 
                        <?php if($slider[$sl]['title'][$k]) { ?>
                            <h1 class=""> <?=$slider[$sl]['title'][$k]?> </h1>
                        <?php } ?>
                        <?php if($slider[$sl]['text'][$k]) { ?>
                            <h2 class=""> <?=$slider[$sl]['text'][$k]?>  </h2>
                        <?php } ?>
                    </div>
                <?php } ?>
        </div>
        
        <?php /*                    
        <div id="slideshow">
            <div class="uk-slidenav-position">
                <ul class="uk-slideset uk-grid uk-flex-center">
                    <?php $sl = 'slide1'; foreach($slider[$sl]['src'] AS $k => $src){ ?>
                        <li> 
                        <?php if($slider[$sl]['href'][$k]) { ?> <a href="<?=$slider[$sl]['href'][$k]?>">  <?php } ?>
                            <img src="../img/slide/<?=$src?>" style="width:100%" alt="<?=$slider[$sl]['alt'][$k]?>">
                        <?php if($slider[$sl]['href'][$k]) { ?>  </a> <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
                <a href="#" class="uk-slidenav uk-slidenav-previous" data-uk-slideset-item="previous"></a>
                <a href="#" class="uk-slidenav uk-slidenav-next" data-uk-slideset-item="next"></a>
            </div>
            <ul class="uk-slideset-nav uk-dotnav uk-flex-center uk-margin-top"></ul>
        </div>
        <script>//UIkit.slideset("#slideshow", { default:1, animation:'flip-horizontal', duration: 200, autoplay: false }); $("#slideshow [hidden]").show()</script>
        */ ?>
    </div>
    
    
    
    <div class="uk-width-medium-1-4 uk-panel uk-panel-box uk-vertical-align " style="margin-bottom:30px">
       <div class="uk-vertical-align-middle uk-text-center">
           <div>
               <h1>Promo</h1>
               <div>
                   <ul id="featured-content" class="uk-slideset uk-grid uk-flex-center uk-grid-width-1-1 uk-grid-width-large-1-5 uk-grid-width-medium-1-4 uk-grid-width-small-1-2"><li style="" class="uk-active"><a class="uk-thumbnail uk-overlay-hover" href="https://internet-skotarov.c9users.io/lite/public/products/view/index.php/1-Продукт-едно/">  <figure class="uk-overlay">      <img src="https://internet-skotarov.c9users.io/lite/public/image.php/1/small/1464699240" alt="Продукт едно">      <div class="uk-overlay-panel uk-overlay-background uk-overlay-bottom uk-overlay-slide-bottom">10.0</div>  </figure>  <div class="uk-thumbnail-caption">Продукт едно</div></a></li></ul>
               </div>
           </div>
           <div>
               <h1><?=$slider['slide1']['adv.brand']?></h1>
               <p><b>Moneyback garantee</b></p>
               <img style="max-width:50%" src="../img/certificate.ico" alt="certificate">
               <div>100% satisfaction</div>
            </div>
            
        </div>
    </div>

</div>
<!-- //slider -->
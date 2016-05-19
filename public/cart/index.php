<?php include '../snipps/init.php'; ?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Shopping cart</title>
        <link rel="shortcut icon" href="<?=URL_BASE?>img/favicon.png" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="<?=URL_BASE?>img/apple-touch-icon.png">
        
        <script src="<?=$_ASSETS['jquery.js']?>"></script>

        <link  href="<?=$_ASSETS['uikit.css']?>" rel="stylesheet"/>
        <script src="<?=$_ASSETS['uikit.js']?>"></script>
        <script src="<?=$_ASSETS['uikit.offcanvas.js']?>"></script>
        <link rel="stylesheet" href="<?=$_ASSETS['uikit.search.css']?>">
        <script src="<?=$_ASSETS['uikit.search.js']?>"></script>
        
        <link  href="<?=$_ASSETS['dataTables.uikit.css']?>" rel="stylesheet">
        <script src="<?=$_ASSETS['dataTables.js']?>"></script>
        <script src="<?=$_ASSETS['dataTables.uikit.js']?>"></script>

        
        <link rel="stylesheet" href="<?=$_ASSETS['uikit.dotnav.css']?>" />
        <script src="<?=$_ASSETS['uikit.slideset.js']?>"></script>

        <link rel="stylesheet" href="<?=URL_BASE?>css/easyzoom.css" />
        <script src="<?=URL_BASE?>js/easyzoom.js"></script>
        
    </head>
    <body id="page-product"> 
        <?php include '../snipps/head.php'; ?>
       
       
        <ul class="uk-breadcrumb"></ul>
       
       
       <div class="uk-grid uk-margin-bottom" data-uk-grid-margin>
           <div class="uk-width-medium-1-3">
                <div id="wrap-main-image" class="uk-overlay uk-width-1-1">
                    <a class="jqzoom" href="">
                        <img id="main-image" class="uk-width-1-1 uk-margin-bottom" style="max-height:100%" src="">
                    </a>
                </div>
                <?php /*
                <div class="easyzoom">
                    <a href="images/zoom.jpg">
                        <img id="main-image2" src="" alt="" />
                    </a>
                </div>
                */?>
                <ul id="product-images" class="uk-thumbnav uk-grid-width-1-5"></ul>
                <script>
                    $("#product-images").on("mouseover","img",function(e){
                        $("#main-image").attr("src", $(this).attr("src") );//.next().attr("src", $(this).attr("src"));
                    });
                </script>
                
           </div>
           <div class="uk-width-medium-2-3 uk-grid ">
               <div class="uk-width-2-3">
                    <h2 id="name" style="margin-bottom:0"></h2>
                    <div id="reference" class="uk-text-muted"></div>
                    <p id="description" class="uk-panel uk-panel-box uk-panel-box-primary"></p>
                    <div>Price: <b><big id="price"></big></b></div>

                    <hr>
                    <div> <button class="uk-button uk-button-primary buy-product">Buy</button> </div>
                </div>
                <div class="uk-width-1-3">
                    
                </div>
           </div>
           
           <div id="details" class="uk-width-medium-1-1"></div>
        </div>
        
        <script>
            $("body").on("click",".buy-product",function(e){
                e.preventDefault();
                $.post("<?=URL_BASE?>ajax.php?f=cart/postAdd",{"id_product":window['id_product']}).done(function(cart){
                    $(document).trigger("shopping-cart-changed",$.parseJSON(cart));
                });
            });


            url = decodeURIComponent(window.location).split("/");
            window['id_product'] = parseInt(url[ url.length-2 ].split("-")[0], 10);
            $.getJSON("<?=URL_BASE?>ajax.php?f=getProduct&id="+window['id_product']).done(function(ret){
                $(".uk-breadcrumb").html('<li><a href="<?=URL_BASE?>products/"><i class="uk-icon-home"></i> Home</a></li>');
                $.each(ret.parents, function(r,c){
                    $(".uk-breadcrumb").append('<li><a href="<?=URL_BASE?>products'+c.url_rewrite+'">'+c.name+'</a></li>');
                });
                $(".uk-breadcrumb").append('<li class="uk-active"><a href="<?=URL_BASE?>products'+ret.data.url_rewrite+'">'+ret.data.category+'</a></li>');
                //$(".uk-breadcrumb").append('<li></li>');
                
                var imgSRC = "<?=URL_BASE?>image.php/"+ret.data.id_image+"/"+ret.data.date_add+"/";
                $("#main-image").attr("src",imgSRC);//.parent().attr("data-zoom-image",imgSRC);
                
                //$("#main-image2").attr("src",imgSRC).parent().attr("href",imgSRC);
                
                //var $easyzoom = $(".easyZoom").easyZoom();
                
                //$("#main-image").addimagezoom();
            	
                //$("#main-image").attr("src",imgSRC).attr("data-zoom",imgSRC);
                /*
                new Drift(document.querySelector('#main-image'), {
                    containInline: true,
                    paneContainer: document.querySelector('.description'),
                    inlineOffsetX: 0,
                    inlineOffsetY: 0,
                });
                */
                
                
                $("#crumb-product").html(ret.data.name);
                $.each(ret.data, function(id,value){ $("#"+id).html(value) });
                
                $("#product-images").html("");
                $.each(ret.images, function(k,v){
                    $("#product-images").append('<li class="uk-width-1-5"><a href=""><img src="<?=URL_BASE?>image.php/'+v.id+'/full/'+v.date_add+'"> </a></li>');
                });
                
                
                
                
            });    
        </script>
        
        
        <br>        
        <?php include '../snipps/featured.php';?>        
        
        <div class="uk-margin"> </div>
        
        <script src="<?=URL_BASE.$_ASSETS['application.js']?>"></script>
        <?php include '../snipps/foot.php'; ?>
        
    </body>
</html>
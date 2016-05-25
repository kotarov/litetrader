<?php include '../../snipps/init.php'; ?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Product</title>
        <link rel="shortcut icon" href="<?=URL_BASE?>img/favicon.png" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="<?=URL_BASE?>img/apple-touch-icon.png">
        
        <script src="<?=$_ASSETS['jquery.js']?>"></script>

        <link  href="<?=$_ASSETS['uikit.css']?>" rel="stylesheet"/>
        <script src="<?=$_ASSETS['uikit.js']?>"></script>
        <script src="<?=$_ASSETS['uikit.offcanvas.js']?>"></script>
        <link rel="stylesheet" href="<?=$_ASSETS['uikit.search.css']?>">
        <script src="<?=$_ASSETS['uikit.search.js']?>"></script>
        <link  href="<?=$_ASSETS['uikit.notify.css']?>" rel="stylesheet"/>
        <script src="<?=$_ASSETS['uikit.notify.js']?>"></script>
        <link rel="stylesheet" href="<?=$_ASSETS['uikit.dotnav.css']?>" />
        <script src="<?=$_ASSETS['uikit.slideset.js']?>"></script>
        
        <!--script src="<?=$_ASSETS['uikit.lightebox.js']?>"></script-->
        
        <link  href="<?=$_ASSETS['dataTables.uikit.css']?>" rel="stylesheet">
        <script src="<?=$_ASSETS['dataTables.js']?>"></script>
        <script src="<?=$_ASSETS['dataTables.uikit.js']?>"></script>
        
        <script src="<?=$_ASSETS['elevatezoom.js']?>"></script>
        
        <style>
            .zoomGalleryActive { border: 1px solid red;}
            .buy-product,.cannot-buy-poduct {display:none}
        </style>
    </head>
    <body id="page-product"> 
        <?php include '../../snipps/head.php'; ?>
       
       
        <ul class="uk-breadcrumb"></ul>
       
       
        <h2 id="name" style="margin-top:0"></h2>
       <div class="uk-grid uk-margin-bottom" data-uk-grid-margin>
           <div class="uk-width-medium-1-2">
                <div class="uk-overlay uk-width-1-1 uk-thumbnail">
                    <a data-uk-lightbox="{group:'main-image'}" href="#">
                        <img id="main-image" class="uk-width-1-1" style="max-height:100%" src="">
                    </a>
                </div>
                
                <div id="product-images" class="uk-thumbnav uk-grid-width-1-5"></div>
           </div>
           <div class="uk-width-medium-1-2 uk-grid ">
                
                <div class="uk-width-1-1">
                    <div>Price: <b class="uk-text-primary uk-text-large" id="price"></b></div>
                    <div id="reference" class="uk-text-muted"></div>
                    <p id="description" class="uk-panel uk-panel-box uk-panel-box-primary"></p>

                    
                    <div class="uk-panel"> 
                        <button class="uk-button uk-button-primary buy-product uk-button-large">
                            <i class="uk-icon-shopping-bag"></i>&nbsp;&nbsp; Buy
                        </button> 
                        <i class="cannot-buy-poduct uk-text-muted">Out of stock</i>
                    </div>
                    <script> 
                        $("body").on("click",".buy-product",function(e){ e.preventDefault();
                            $.post("<?=URL_BASE?>ajax.php?f=cart/postAdd",{"id_product":window['id_product'],"add":"1"}).done(function(cart){
                                cart = $.parseJSON(cart);
                                if(cart.error){ UIkit.notify(cart.error,"warning");
                                }else{
                                    $(document).trigger("shopping-cart-changed",cart);
                                    UIkit.modal("#modal-cart").show();
                                }
                            });
                        }); 
                    </script>
                    
                    
                    <h3 class="uk-text-primary">Details</h3>
                    <hr>
                    <div id="details" class="uk-width-medium-1-1"></div>

                    <h3 class="uk-text-primary">Contacts</h3>
                    <hr>
                    <div id="contacts"></div>

                </div>


                
           </div>
           
           
           
        </div>
        
        <script>
            

            /*** INIT */
            url = decodeURIComponent(window.location).split("/");
            window['id_product'] = parseInt(url[ url.length-2 ].split("-")[0], 10);
            $.getJSON("<?=URL_BASE?>ajax.php?f=getProduct&id="+window['id_product']).done(function(ret){
                $(".uk-breadcrumb").html('<li><a href="<?=URL_BASE?>products/"><i class="uk-icon-home"></i> Home</a></li>');
                $.each(ret.parents, function(r,c){
                    $(".uk-breadcrumb").append('<li><a href="<?=URL_BASE.URL_PRODUCTS;?>'+c.url_rewrite+'">'+c.name+'</a></li>');
                });
                $(".uk-breadcrumb").append('<li class="uk-active"><a href="<?=URL_BASE.URL_PRODUCTS;?>'+ret.data.url_rewrite+'">'+ret.data.category+'</a></li>');
                
                var imgSRC = "<?=URL_BASE?>image.php/"+ret.data.id_image+"/"+ret.data.date_add+"/";
                $("#main-image").attr("src",imgSRC);
                
                $("#crumb-product").html(ret.data.name);
                $.each(ret.data, function(id,value){ $("#"+id).html(value) });
                
                $("#product-images").html("");
                $.each(ret.images, function(k,v){
                    var url = '<?=URL_BASE?>image.php/'+v.id+'/full/'+v.date_add;
                    $("#product-images").append('<a href="#" data-image="'+url+'" data-uk-lightbox="{group:\'main-image\'}" class="uk-width-1-5"><img src="'+url+'"> </a>');
                });
                
                if(ret.data.is_avaible == 1) {
                    $(".buy-product").show();
                    $(".cannot-buy-poduct").hide();
                    
                }else {
                    $(".buy-product").hide();
                    $(".cannot-buy-poduct").show();
                }
                
                $("#main-image").elevateZoom({
                    tint:true, tintColour:'black', tintOpacity:0.5,
                    gallery:"product-images", 
                });
                
            });    
        </script>
        
        
        <br>        
        <?php include '../../snipps/featured.php';?>        
        
        <div class="uk-margin"> </div>
        
        <script src="<?=URL_BASE?>js/application.js"></script>
        <?php include '../../snipps/foot.php'; ?>
        
    </body>
</html>
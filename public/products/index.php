<?php include '../snipps/init.php'; ?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>List Products</title>
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
    </head>
    
    <body id="page-products"> 
        <?php include '../snipps/head.php'; ?>
        
        <ul class="uk-breadcrumb"> 
            <li><a href="<?=URL_BASE?>products/"><i class="uk-icon-home"></i> Home</a></li>
        </ul>
        
        
        <div id="categories-list" class="uk-grid" data-uk-grid-margin></div>
        <br><br>
        <div id="products" class=""></div>
        
        <script>
        function initProducts(){
            url = decodeURIComponent(window.location).split("/");
            id = parseInt(url[ url.length-2 ].split("-")[0], 10);
            $.getJSON("<?=URL_BASE?>ajax.php?f=getCategories&id="+id).done(function(ret){
                $(".uk-breadcrumb").html('<li><a data-live href="<?=URL_BASE.URL_PRODUCTS?>/"><i class="uk-icon-home"></i> Home</a></li>');
                $.each(ret.parents, function(k,v){
                    $(".uk-breadcrumb").append('<li><a data-live href="<?=URL_BASE.URL_PRODUCTS?>'+v.url_rewrite+'">'+v.name+'</a></li>');
                });
                if(typeof ret.current.name !== "undefined") $(".uk-breadcrumb").append('<li><span>'+ret.current.name+'</span></li>');
                
                $("#categories-list").html("");
                $.each(ret.categories, function(k,v){
                    $("#categories-list").append(''
                    +'<div class="uk-width-medium-1-2 uk-width-large-1-3">'
                        +'<div class="uk-panel uk-panel-hover uk-panel-header">'
                            +'<div class="uk-panel-badge uk-badge">'+v.num+'</div>'
                            +'<h3 class="uk-panel-title"><a data-live href="<?=URL_BASE.URL_PRODUCTS?>'+v.url_rewrite+'">'+v.title+'</a></h3>'
                            +'<p>'+v.description+'</p>'
                        +'</div>'
                    +'</div>'
                    );
                });
                
                $("#products").html("");
                $.each(ret.data, function(r,p){
                    $("#products").append(''
                        +'<a class="uk-thumbnail uk-thumbnail-mini" href="<?=URL_BASE.URL_PRODUCT?>'+p.url_rewrite+''+p.id+'-'+p.name.replace(/\ /g,"-")+'/">'
                            +'<img src="<?=URL_BASE?>image.php/'+p.id_image+'/small/'+p.date_add+'" alt="">'
                            +'<div class="uk-thumbnail-caption">'
                                +'<div>'+p.name+'</div>'
                                +'<div>'+p.price+'</div>'
                            +'</div>'
                        +'</a>'
                    );
                });
            });
        }
        initProducts();
        </script>
            
        <script>
            $("body").on("click","a[data-live]",function(e){
                e.preventDefault();
                history.pushState(null, null, $(this).attr("href"));
                initProducts();
            });
            
            $(window).on('popstate', function() {
                initProducts();
            });
        </script>
        
        
        <br>   
        <?php include '../snipps/featured.php';?>
            
            
        <br><br>
        <?php include '../snipps/foot.php'; ?>
        <script src="<?=URL_BASE?>js/application.js"></script>
    </body>
    
</html>
<?php 

$NO_ENCODE = true;
$me = parse_ini_file(INI_DIR.'menus.ini', true);
if($me['public']['products']) $menu = include __DIR__.'/../../ajax/getMenu.php';
?>

        <div class="uk-container uk-container-center uk-margin-large-bottom">
            <div class="uk-panel uk-margin-top">
                <div class="uk-float-left"><h1><?=$_COMPANY['name']?></h1></div>
                <div class="uk-navbar-content uk-hidden-small">
                    <form class="uk-search no-ajax" action="<?=URL_BASE?>products/search/" data-uk-search="{source:'<?=URL_BASE?>ajax.php?f=products/search'}">
                        <input class="uk-search-field" type="search" placeholder="search..." autocomplete="off">
                    </form>
                </div>

                

                <!-- Shopping cart -->
                <div class="uk-float-right">
                    <span id="shopping-cart" href="" class="uk-grid" style="min-width:13em" hidden>
                        <h1 class="uk-width-2-6">
                            <a href="#modal-cart" data-uk-modal><i class="uk-icon-shopping-bag uk-text-primary" style="position:relative">
                                <span style="position:absolute;margin-top:-1em;margin-left:2em;display:none" class="shopping-cart-badge uk-badge uk-badge-notification uk-badge-danger">0</span>
                            </i></a>
                        </h1>
                        <div class="uk-width-4-6 uk-text-right">
                            <div class="uk-text-muted">Shopping cart</div>
                            <big class="uk-text-primary uk-text-bold shopping-cart-price" style="margin-top:0;display:none">0.00</big>
                        </div>
                    </span>
                </div>
                <script>
                    $(document).on("shopping-cart-changed", function(e, cart){
                        if(cart.nb > 0){
                            $(".shopping-cart-badge").html(cart.nb).show();
                            $(".shopping-cart-price").html(cart.total.toFixed(2)).show();
                        }else{
                            $(".shopping-cart-badge").html("").hide();
                            $(".shopping-cart-price").html("").hide();
                        }
                    });
                </script>
                <!-- //shopping cart -->
                
                <h2 class="uk-margin-small-top uk-margin-large-right uk-align-right"><i class="uk-icon-phone"></i> <?=$_COMPANY['phone']?></h2>
                
            </div>

            <!-- menu -->
            <nav class="uk-navbar uk-margin-bottom">
                <ul class="uk-navbar-nav uk-hidden-small">
                    <?php if($me['public']['home']) { ?>
                    <li data-active="page-home">
                        <a href="<?=URL_BASE?>home/"><i class="uk-icon-home"></i> Home</a>
                    </li>
                    <?php } ?>

                    <?php if($me['public']['products']) { ?>
                    <li data-active="page-products" data-uk-dropdown>
                            <a href="<?=URL_BASE?>products/" class="uk-button-dropdown" aria-haspopup="true" data-uk-dropdown="" aria-expanded="falae" >Products</a>
                            <div class="uk-dropdown uk-dropdown-width-3 uk-dropdown-bottom" style="top: 30px; left: 0px;">
                                <div class="uk-grid uk-dropdown-grid">
                                    <?php foreach($menu['data'] AS $r=>$m){ ?>
                                        <div class="uk-width-1-3">
                                            <a class="uk-text-primary" href="<?=URL_BASE.URL_PRODUCTS.$m['url_rewrite']?>"><?=$m['name']?></a>
                                            <ul class="uk-nav uk-nav-dropdown uk-panel">
                                                <?php foreach($menu['l2'][$m['id']] as $kk=>$mm) { ?>
                                                <li><a href="<?=URL_BASE.URL_PRODUCTS.$mm['url_rewrite']?>"><?=$mm['name']?></a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                    </li>
                    <?php } ?>
                    
                    <?php if($me['public']['articles']) { ?>
                    <li data-active="page-articles">
                        <a href="<?=URL_BASE?>articles/">Articles</a>
                    </li>
                    <?php } ?>
                    
                    <?php if($me['public']['contacts']) { ?>
                    <li data-active="page-contacts">
                        <a href="<?=URL_BASE?>contacts/">Contacts</a>
                    </li>
                    <?php } ?>
                    
                    <?php if($me['public']['order']) { ?>
                    <li data-active="page-order" class="checkout" hidden>
                        <a href="<?=URL_BASE?>order/"> ORDER <b class="shopping-cart-badge uk-badge uk-badge-notification uk-badge-danger"></b></a>
                    </li>
                    <?php } ?>
                    
                </ul>
                
                
                <div class="uk-navbar-flip">
                    <ul class="uk-navbar-nav uk-hidden-small customer-nav-menu">
                        <li data-active="page-profile"><a href="<?=URL_BASE?>customer/"><i class="uk-icon-user"></i> Login</a></li>
                    </ul>
                </div>
                <a href="#offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas></a>
                <div class="uk-navbar-brand uk-navbar-center uk-visible-small">
                    <form class="uk-search uk-text-left no-ajax" action="<?=URL_BASE?>products/search/" data-uk-search="{source:'<?=URL_BASE?>ajax.php?f=products/search'}">
                        <input class="uk-search-field" type="search" placeholder="search..." autocomplete="off">
                    </form>
                </div>
            </nav>
            
            <div id="offcanvas" class="uk-offcanvas">
                <div class="uk-offcanvas-bar uk-offcanvas-bar-show">
                    <ul class="uk-nav uk-nav-offcanvas uk-nav-parent-icon" data-uk-nav>
                        <li class="uk-nav-divider"></li>

                        <?php if($me['public']['home']) { ?>
                        <li data-active="page-home">
                            <a href="<?=URL_BASE?>home/">Home</a>
                        </li>
                        <?php } ?>

                        <?php if($me['public']['products']) { ?>
                        <li data-active="page-category" class="uk-parent">
                            <a href="#">Products</a>
                            <ul class="uk-nav-sub" >
                                <?php foreach($menu['data'] AS $k=>$m){ ?>
                                    <li class="uk-margin-left">
                                        <a class="uk-text-primary" href="<?=URL_BASE.URL_PRODUCTS.$m['url_rewrite']?>"><?=$m['name']?></a>
                                        <?php foreach($menu['l2'][$m['id']] AS $kk=>$mm){ ?>
                                            <a class="uk-margin-left" href="<?=URL_BASE.URL_PRODUCTS.$mm['url_rewrite']?>"><?=$mm['name']?></a>
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>
                        
                        <?php if($me['public']['articles']) { ?>
                        <li data-active="page-articles">
                            <a href="<?=URL_BASE?>articles/">Articles</a>
                        </li>
                        <?php } ?>
                        
                        <?php if($me['public']['contacts']) { ?>
                        <li data-active="page-contacts">
                            <a href="<?=URL_BASE?>contacts/">Contacts</a>
                        </li>
                        <?php } ?>
                        
                        <?php if($me['public']['order']) { ?>
                        <li data-active="page-order" class="checkout">
                            <a href="<?=URL_BASE?>order/">Order <b class="shopping-cart-badge uk-badge uk-badge-notification uk-badge-danger"></b></a>
                        </li>
                        <?php } ?>
                        
                        <li class="uk-nav-divider"></li>
                        <li>
                            <ul class="uk-nav customer-nav-menu">
                                <li><a href="<?=URL_BASE?>customer/">Login</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
             <script>
                $.getJSON("<?=URL_BASE?>ajax.php?f=getLogged").done(function(d){ if(d.id){
                    var active = "";
                    if($("body").attr("id") == "page-profile") active = ' class="uk-active"'
                    $(".customer-nav-menu").html(''
                        +'<li'+active+'><a href="<?=URL_BASE?>customer/profile.php"> '+ d.name+' '+ d.family +' </a></li>'
                        +'<li><a onclick="$.get(\'<?=URL_BASE?>ajax.php?f=login/postLogout\').done(window.location.replace(\'<?=URL_BASE?>home/\'))"><i class="uk-icon-power-off"></i> Exit</a></li>'
                    );
                }});
                $("[data-active='"+$("body").attr("id")+"']").addClass("uk-active");
            </script>
            <!-- //menu -->

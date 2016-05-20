        <div class="uk-container uk-container-center uk-margin-large-bottom">
            <div class="uk-panel uk-margin-top">
                <div class="uk-float-left"><h1><?=$_COMPANY['name']?></h1></div>
                <div class="uk-navbar-content uk-hidden-small">
                    <form class="uk-search" data-uk-search="{flipDropdown:true, source:'_searchautocomplete.json'}">
                        <input class="uk-search-field" type="search" placeholder="search..." autocomplete="off">
                        <div class="uk-dropdown uk-dropdown-flip uk-dropdown-search" aria-expanded="false"></div>
                    </form>
                </div>

                

                <!-- Shopping cart -->
                <div class="uk-float-right">
                    <span id="shopping-cart" href="" class="uk-grid" style="min-width:13em" hidden>
                        <h1 class="uk-width-2-6">
                            <a href="#modal-cart" data-uk-modal><i class="uk-icon-shopping-bag uk-text-primary" style="position:relative">
                                <span id="shcart-badge" style="position:absolute;margin-top:-1em;margin-left:2em;display:none" class="uk-badge uk-badge-notification uk-badge-danger">0</span>
                            </i></a>
                        </h1>
                        <div class="uk-width-4-6 uk-text-right">
                            <div class="uk-text-muted">Shopping cart</div>
                            <big id="shcart-price" class="uk-text-primary uk-text-bold" style="margin-top:0;display:none">0.00</big>
                        </div>
                    </span>
                </div>
                <script>
                    $(document).on("shopping-cart-changed", function(e, cart){
                        if(cart.nb > 0){
                            //$("#shopping-cart").hide();
                            $("#shcart-badge").html(cart.nb).show();
                            $("#shcart-price").html(cart.total.toFixed(2)).show();
                            //$("#shopping-cart").fadeIn("slow");
                        }else{
                            $("#shcart-badge").html("").hide();
                            $("#shcart-price").html("").hide();
                        }
                    });
                    //$.getJSON("<?=URL_BASE?>ajax.php?f=cart/getCart",function(cart){ $(document).trigger("shopping-cart-changed",cart);});
                </script>
                <!-- //shopping cart -->
                
                <h2 class="uk-margin-small-top uk-margin-large-right uk-align-right"><i class="uk-icon-phone"></i> <?=$_COMPANY['phone']?></h2>
                
            </div>

            <!-- menu -->
            <nav class="uk-navbar uk-margin-bottom">
                <!--a class="uk-navbar-brand uk-hidden-small" href="layouts_frontpage.html">Brand</a-->
                <ul class="uk-navbar-nav uk-hidden-small">
                    <li data-active="page-home">
                        <a href="<?=URL_BASE?>index.php"><i class="uk-icon-home"></i> Home</a>
                    </li>
    
                    
                    <li data-active="page-products" class="uk-button-dropdown" data-uk-dropdown="" aria-haspopup="true" aria-expanded="falae">
                            <a href="<?=URL_BASE?>products/" class="uk-button">Products</a>
                            <div class="uk-dropdown uk-dropdown-width-3 uk-dropdown-bottom" style="top: 30px; left: 0px;">
        
                                <div id="categories-menu-list" class="uk-grid uk-dropdown-grid">
                                    <?php /*
                                    <div class="uk-width-1-3">
        
                                        <ul class="uk-nav uk-nav-dropdown uk-panel">
                                            <li><a href="#">Item</a></li>
                                            <li><a href="#">Another item</a></li>
                                            <li class="uk-nav-header">Header</li>
                                            <li><a href="#">Item</a></li>
                                            <li><a href="#">Another item</a></li>
                                            <li class="uk-nav-divider"></li>
                                            <li><a href="#">Separated item</a></li>
                                        </ul>
        
                                        <div class="uk-panel">Lorem ipsum dolor sit amet, consectetur <a href="">adipisicing</a> elit, sed do eiusmod tempor incididunt.</div>
        
                                    </div>
                                    <div class="uk-width-1-3">
        
                                        <ul class="uk-nav uk-nav-dropdown uk-panel">
                                            <li><a href="#">Item</a></li>
                                            <li><a href="#">Another item</a></li>
                                            <li class="uk-nav-header">Header</li>
                                            <li><a href="#">Item</a></li>
                                            <li><a href="#">Another item</a></li>
                                            <li class="uk-nav-divider"></li>
                                            <li><a href="#">Separated item</a></li>
                                        </ul>
        
                                        <div class="uk-panel">Lorem ipsum dolor sit amet, consectetur <a href="">adipisicing</a> elit, sed do eiusmod tempor incididunt.</div>
        
                                    </div>
                                    <div class="uk-width-1-3">
                                        <div class="uk-panel">Lorem ipsum dolor sit amet, consectetur <a href="">adipisicing</a> elit, sed do eiusmod tempor incididunt.</div>
                                        <div class="uk-panel">Lorem ipsum dolor sit amet, consectetur <a href="">adipisicing</a> elit, sed do eiusmod tempor incididunt.</div>
                                    </div>
                                    */ ?>
                                </div>
        
                            </div>
                    </li>
                    <li data-active="page-contacts">
                        <a href="<?=URL_BASE?>contacts/">Contacts</a>
                    </li>
                    
                    <li data-active="page-order">
                        <a href="<?=URL_BASE?>order/"> ORDER</a>
                    </li>
                    
                </ul>
                <script>
                    $.getJSON("<?=URL_BASE?>ajax.php?f=getMenu").done(function(ret){
                        $.each(ret.data,function(k,v){
                            var sub = '<ul class="uk-nav uk-nav-dropdown uk-panel">';
                            $.each(ret['l2'][v.id],function(r2,v2){
                                sub += '<li><a href="<?=URL_BASE?>products'+v2.url_rewrite+'">'+v2.name+'</a></li>'
                            });
                            sub += '</ul>';
                            
                            $("#categories-menu-list").append(''
                            +'  <div class="uk-width-1-3">'
                            +'      <a href="<?=URL_BASE?>products'+v.url_rewrite+'">'+v.name+'</a>'
                            +'      '+sub
                            +'  </div>'
                            );
                        });
                    });
                </script>
                
                
                
                <div class="uk-navbar-flip">
                    <ul class="uk-navbar-nav uk-hidden-small customer-nav-menu">
                        <li data-active="page-profile"><a href="<?=URL_BASE?>customer/"><i class="uk-icon-user"></i> Login</a></li>
                    </ul>
                </div>
                <a href="#offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas></a>
                <div class="uk-navbar-brand uk-navbar-center uk-visible-small">
                    <form class="uk-search">
                        <input class="uk-search-field" type="search" placeholder="search...">
                    </form>
                </div>
            </nav>
            <div id="offcanvas" class="uk-offcanvas">
                <div class="uk-offcanvas-bar uk-offcanvas-bar-show">
                    <ul class="uk-nav uk-nav-offcanvas uk-nav-parent-icon" data-uk-nav>
                        <li>
                            <form class="uk-search">
                                <input class="uk-search-field" type="search" placeholder="search...">
                            </form>
                        </li>
                        <li data-active="page-home">
                            <a href="<?=URL_BASE?>home/">Home</a>
                        </li>
                        
                        <li data-active="page-category" class="uk-parent">
                            <a href="#">Products</a>
                            <ul class="uk-nav-sub">
                                <li><a href="#">Sub item</a></li>
                                <li><a href="#">Sub item</a>
                                    <ul>
                                        <li><a href="#">Sub item</a></li>
                                        <li><a href="#">Sub item</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        
                                      
                        <li data-active="page-contacts">
                            <a href="<?=URL_BASE?>contacts/">Contacts</a>
                        </li>
                        
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
                        +'<li><a onclick="$.get(\'<?=URL_BASE?>ajax.php?f=postLogout\').done(window.location.replace(\'<?=URL_BASE?>home/\'))"><i class="uk-icon-power-off"></i> Exit</a></li>'
                    );
                }});
                $("[data-active='"+$("body").attr("id")+"']").addClass("uk-active");
            </script>
            <!-- //menu -->

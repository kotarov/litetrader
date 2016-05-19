<script>
    $.ajaxSetup({ dataFilter: function(data,type){
        try{var a = data; if(typeof data != "object") a=$.parseJSON(data); 
            if(a.access_denided) window.location.href="login.php";
            else if(a.redirect) widow.location.href = a.redirect;
            else if(a.error) window.UIkit.notify("<b>Error</b> "+a.error,"warning");
        } catch(e){} return data;
    }});
</script>

        <div class="uk-margin-large-bottom">

            <!-- menu -->
            <nav class="uk-navbar uk-margin-bottom1">
                <a class="uk-navbar-brand uk-hidden-small" href="#"><?=$_COMPANY['name']?></a>
                <ul class="uk-navbar-nav uk-hidden-small">
                    
                    <li data-active="page-home">
                        <a href="index.php"><i class="uk-icon-home"></i> Home</a>
                    </li>
                    
                    <li data-uk-dropdown data-active="page-products">
                        <a href="products.php">Products <i class="uk-icon-caret-down"></i></a>
                        <div class="uk-dropdown">
                            <ul class="uk-nav uk-nav-navbar">
                                <li><a href="products.php">Products</a></li>
                                <li><a href="categories.php">Categories</a></li>
                                <li class="uk-nav-divider"></li>
                                <li class="nav-settings"><a href="productsunits.php">Measure units</a></li>
                            </ul>
                        </div>
                    </li>
                    
                    <li data-uk-dropdown data-active="page-customers">
                        <a href="customers.php">Customers <i class="uk-icon-caret-down"></i></a>
                        <div class="uk-dropdown">
                            <ul class="uk-nav uk-nav-navbar">
                                <li><a href="customersorders.php">Sales Orders</a></li>
                                <li><a href="customers.php">Customers</a></li>
                                <li><a href="customerscompanies.php">Companies</a></li>
                                <li class="uk-nav-divider"></li>
                                <li class="nav-settings"><a href="customersorderstatuses.php">Order statuses</a></li>
                            </ul>
                        </div>
                    </li>
                    
                    <li data-uk-dropdown data-active="page-suppliers">
                        <a href="suppliers.php">Suppliers <i class="uk-icon-caret-down"></i></a>
                        <div class="uk-dropdown">
                            <ul class="uk-nav uk-nav-navbar">
                                <li><i href="suppliersorders.php" class="uk-text-muted">&nbsp;&nbsp;&nbsp;&nbsp;Purchase Orders</i></li>
                                <li><a href="suppliers.php">Suppliers</a></li>
                                <li><a href="supplierscompanies.php">Companies</a></li>
                                <li class="uk-nav-divider"></li>
                                <li class="nav-settings uk-text-muted">&nbsp;&nbsp;&nbsp;&nbsp;<i href="suppliersorderstatuses.php">Order statuses</i></li>
                            </ul>
                        </div>
                    </li>
                    
                    <li data-active="page-tools" data-uk-dropdown>
                        <a href="tools.php"><i class="uk-icon-wrench"></i> Tools</a>
                        <div class="uk-dropdown">
                            <ul class="uk-nav uk-nav-navbar">
                                <li><a>Images</a></li>
                                <li><a>Transltes</a></li>
                            </ul>
                        </div>
                    </li>
                    
                </ul>
                <div class="uk-navbar-flip">
                    <ul class="uk-navbar-nav uk-hidden-small customer-nav-menu"></ul>
                </div>
                <a href="#offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas></a>
                <div class="uk-navbar-brand uk-navbar-center uk-visible-small">
                   Your Brand
                </div>
            </nav>
            <div id="offcanvas" class="uk-offcanvas">
                <div class="uk-offcanvas-bar uk-offcanvas-bar-show">
                    <div class="uk-navbar-brand uk-navbar-center uk-visible-small">Admin panel</div>
                    <ul class="uk-nav uk-nav-offcanvas uk-nav-parent-icon" data-uk-nav>
                        <li data-active="page-home">
                            <a href="home.php"><i class="uk-icon-home"></i> Home</a>
                        </li>
                        
                        <?php /*
                        <li data-active="page-category" class="uk-parent">
                            <a href="#">Test</a>
                            <ul class="uk-nav-sub">
                                <li><a href="#">Sub item</a></li>
                                <li><a href="#">Sub item</a>
                                    <ul>
                                        <li><a href="#">Sub item</a></li>
                                        <li><a href="#">Sub item</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li> */?>
                        
                        <li class="uk-nav-divider"></li>              
                        
                        <li data-active="page-products" class="uk-parent">
                            <a href="#">Products</a>
                            <ul class="uk-nav-sub">
                                <li><a href="products.php" data-active="page-products">Products</a></li>
                                <li><a href="categories.php" data-active="page-categories">Categories</a></li>    
                                <li class="uk-nav-divider"></li>
                                <li class="nav-settings"><a href="productsunits.php">Measure units</a></li>
                            </ul>
                        </li>
                        
                        <li class="uk-nav-divider"></li>
                        
                        <li data-active="page-customers" class="uk-parent">
                            <a href="#">Customers</a>
                            <ul class="uk-nav-sub">
                                <li><a href="customersorders.php">Sales Orders</a></li>
                                <li><a href="customers.php">Customers</a></li>
                                <li><a href="customerscompanies.php">Companies</a></li>
                                <li class="uk-nav-divider"></li>
                                <li class="nav-settings"><a href="customersorderstatuses.php">Order statuses</a></li>
                            </ul>
                        </li>
                         
                        <li class="uk-nav-divider"></li>
                         
                        <li data-active="page-suppliers" class="uk-parent">
                            <a href="#" >Suppliers</a>
                            <ul class="uk-nav-sub">
                                <li><i href="suppliersorders.php" class="uk-text-muted">Purchase Orders</i></li>
                                <li><a href="suppliers.php">Suppliers</a>
                                <li><a href="supplierscompanies.php">Companies</a></li>
                                <li class="uk-nav-divider"></li>
                                <li class="nav-settings uk-text-muted"><i href="suppliersorderstatuses.php">Order statuses</i></li>
                            </ul>
                        </li>
                        
                        <li class="uk-nav-divider"></li>
                         
                        <li data-active="page-tools" class="uk-parent">
                            <a href="#">Tools</a>
                            <ul class="uk-nav-sub">
                                <li><a href="images.php">Images</a></li>
                                <li><a href="translate.php">Translate</a></li>
                            </ul>
                        </li>
                        
                        
                        <li class="uk-nav-divider"></li>
                        
                        <li class="uk-nav customer-nav-menu"></li>
                    </ul>
                </div>
            </div>
            
             <script>
                $.getJSON("ajax.php?f=getLogged").done(function(d){ if(d.id){
                    var active = "";
                    if($("body").attr("id") == "page-profile") active = ' class="uk-active"'
                    $(".customer-nav-menu").html(''
                        +'<li'+active+'><a href="profile.php"> '+ d.name+' '+ d.family +' </a></li>'
                        +'<li><a onclick="$.get(\'ajax.php?f=postLogout\').done(window.location.replace(\'index.php\'))"><i class="uk-icon-power-off"></i> Exit</a></li>'
                    );
                }});
                $("[data-active='"+$("body").attr("id")+"']").addClass("uk-active");
            </script>
            <!-- //menu -->


<?php
    $menu = array(
        'home'=>array(
            'title'=>'<i class="uk-icon-home"></i> Home',
            'url'=>'index.php',
            'data-active'=>'page-home'
        ),
        'products'=>array(
            'title'=>'Products',
            'url'=>'products.php',
            'data-active'=>'page-products',
            'children'=>array(
                'products'=>array('title'=>'Products', 'url'=>'products.php'),
                'categories'=>array( 'title'=>'Categories', 'url'=>'categories.php'),
                '-1-'=>array(),
                'measure-units'=>array( 'title'=>'Measure Units', 'url'=>'productsunits.php')
            )
        ),
        'customers'=>array(
            'title'=>'Customers',
            'url'=>'customers.php',
            'data-active'=>'page-customers',
            'children'=>array(
                'orders'=>array('title'=>'Sales Orders','url'=>'customersorders.php'),
                'customers'=>array('title'=>'Customers', 'url'=>'customers.php'),
                'companies'=>array('title'=>'Companies','url'=>'customerscompanies.php'),
                '-1-'=>array(),
                'statuses'=>array('title'=>'Order Statuses','url'=>'customersorderstatuses.php')
            )
        ),
        'suppliers'=>array(
            'title'=>'Suppliers',
            'url'=>'suppliers.php',
            'data-active'=>'page-supplier',
            'children'=>array(
                //'orders'=>array('title'=>'Purchase Orders','url'=>'suppliersorders.php'),
                'customers'=>array('title'=>'Suppliers', 'url'=>'suppliers.php'),
                'companies'=>array('title'=>'Companies','url'=>'supplierscompanies.php'),
                //'-1-'=>array(),
                ///'statuses'=>array('title'=>'Purchase Statuses','url'=>'suppliersorderstatuses.php')   
            )
        ),
        'tools'=>array(
            'title'=>'<i class="uk-icon-wrench"></i> Tools',
            'data-active'=>'page-tools',
            'children'=>array(
                'update'=>array('title'=>'Git Updater','url'=>'tools-update.php')    
            )
        )
    );
?>
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
                    <?php foreach($menu AS $k=>$v){
                        if(isset($v['children'])){
                            echo '<li data-uk-dropdown data-active="'.$v['data-active'].'">';
                            echo '  <a href="'.(isset($v['url']) ? $v['url'] : '#').'">'.$v['title'].' <i class="uk-icon-caret-down"></i></a>';
                            echo '<div class="uk-dropdown"> <ul class="uk-nav uk-nav-navbar">';
                            foreach($v['children'] AS $kk=>$ch ){
                                if(substr($kk,0,1) == '-') echo '<li class="uk-nav-divider"></li>';
                                else echo '<li><a href="'.$ch['url'].'">'.$ch['title'].'</a></li>';
                            }
                            echo '</ul></div></li>';
                        }else{
                            echo '<li data-active="'.$v['data-active'].'"><a href="'.$v['url'].'">'.$v['title'].'</a></li>'; 
                        }
                        
                    }?>
                </ul>
                <div class="uk-navbar-flip">
                    <ul class="uk-navbar-nav uk-hidden-small customer-nav-menu"></ul>
                </div>
                <a href="#offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas></a>
                <div class="uk-navbar-brand uk-navbar-center uk-visible-small">
                   <?=$_COMPANY['name']?>
                </div>
            </nav>
            <div id="offcanvas" class="uk-offcanvas">
                <div class="uk-offcanvas-bar uk-offcanvas-bar-show">
                    <div class="uk-navbar-brand uk-navbar-center uk-visible-small uk-text-nowrap"><?=$_COMPANY['name']?></div>
                    <ul class="uk-nav uk-nav-offcanvas uk-nav-parent-icon" data-uk-nav>
                        <li class="uk-nav-divider"></li>
                        <?php foreach($menu AS $k=>$v){
                            if(isset($v['children'])){
                                echo '<li data-active="'.$v['data-active'].'" class="uk-parent">';
                                echo '  <a href="#">'.$v['title'].'</a>';
                                echo '  <ul class="uk-nav-sub">';
                                foreach($v['children'] AS $kk=>$ch ){
                                    if(substr($kk,0,1) == '-') echo '<li class=""></li>';
                                    else echo '<li><a href="'.$ch['url'].'">'.$ch['title'].'</a></li>';
                                }
                                echo ' </ul></li>';
                            }else{
                                echo '<li data-active="'.$v['data-active'].'"><a href="'.$v['url'].'">'.$v['title'].'</a></li>'; 
                            }
                             echo '<li class="uk-nav-divider"></li>'; 
                        }?>
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


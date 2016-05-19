<?php include '../snipps/init.php'; ?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>
        <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon.png">
        
        <script src="<?=$_ASSETS['jquery.js']?>"></script>
        
        <link  href="<?=$_ASSETS['uikit.css']?>" rel="stylesheet"/>
        <script src="<?=$_ASSETS['uikit.js']?>"></script>
        <script src="<?=$_ASSETS['uikit.offcanvas.js']?>"></script>
        <link rel="stylesheet" href="<?=$_ASSETS['uikit.search.css']?>">
        <script src="<?=$_ASSETS['uikit.search.js']?>"></script>
        
        <link  href="<?=$_ASSETS['dataTables.uikit.css']?>" rel="stylesheet">
        <script src="<?=$_ASSETS['dataTables.js']?>"></script>
        <script src="<?=$_ASSETS['dataTables.uikit.js']?>"></script>
        
        <style type="text/css">
            @media (min-width: 768px){.left-menu-hat { border-right: 1px solid #ddd; } }
            table.cart { border:1px solid; background:#fff;}
        </style>
    </head>
    <body id="page-profile"> 
        <?php include '../snipps/head.php'; ?>
        <div class="uk-grid uk-margin">
            
            <div class="uk-width-medium-1-4">
                <div class="uk-text-center left-menu-hat">
                    <i class="uk-icon-user uk-border-circle uk-margin-bottom" style="font-size:6em;padding:0.1em 0.2em;background:#f5f5f5;color:#fff"></i>
                </div>
                <ul class="uk-tab uk-tab-left" data-uk-tab="{connect:'#tab-content'}" >
                    <li  class="uk-active"><a href="#active-orders">Active orders</a></li>
                    <li><a href="#done-orders">Done orders</a></li>
                    <li><a href="#canceled-orders">Canceled orders</a></li>
                    <li><a href="#profile">Profile data</a></li>
                </ul>
                <div class="uk-hidden-small" style="border-right:1px solid #ddd">
                    <br><br><br><br><br><br><br><br><br>
                </div>
            </div>
            
            
            <div class="uk-width-medium-3-4 uk-margin">
                <ul class="uk-switcher" id="tab-content">
                    
                    <li id="active-orders"> 
                        <h2>Active orders</h2> 
                        <table class="dataTable uk-table uk-table-hover uk-table-striped" width="100%" 
                            data-ajax="<?=URL_BASE?>ajax.php?f=customer/getOrders&t=active" 
                            data-dom="ltip"
                            data-sort="false"
                        >
                            <thead><tr> 
                                <th data-data="id" data-class="uk-text-center" data-width="1em">ID</th>
                                <th data-data="date" data-render="new Date(d*1000).toLocaleDateString()">Date</th>
                                <th data-data="address" >Address</th>
                                <th data-data="products" data-class="uk-text-center" data-render="'<a data-cart=\''+r['id']+'\' class=\'uk-icon-shopping-cart\'><span class=\'uk-badge\'>'+d+'</span></a>'">Products</th>
                                <th data-data="total">Total</th> 
                            </tr></thead>
                        </table>
                    </li>
                    <li id="done-orders">
                        <h2>Done Orders</h2>
                        <table class="dataTable uk-table uk-table-hover uk-table-striped" width="100%" 
                            data-ajax="<?=URL_BASE?>ajax.php?f=customer/getOrders&t=done" 
                            data-dom="ltip"
                            data-sort="false"
                        >
                            <thead><tr> 
                                <th data-data="id" data-class="uk-text-center" data-width="1em">ID</th>
                                <th data-data="date" data-render="new Date(d*1000).toLocaleDateString()">Date</th>
                                <th data-data="address" >Address</th>
                                <th data-data="products" data-class="uk-text-center" data-render="'<a data-cart=\''+r['id']+'\' class=\'uk-icon-shopping-cart\'><span class=\'uk-badge\'>'+d+'</span></a>'">Products</th>
                                <th data-data="total">Total</th>
                            </tr></thead>
                            <tbody><tr> <td colspan="4" class="uk-text-center uk-text-muted">No orders</td> </tr></tbody>
                        </table>
                    </li>
                    <li id="canceled-orders">
                        <h2>Canceled orders</h2>
                        <table class="dataTable uk-table uk-table-hover uk-table-striped" width="100%" 
                            data-ajax="<?=URL_BASE?>ajax.php?f=customer/getOrders&t=canceld" 
                            data-dom="ltip"
                            data-sort="false"
                        >
                            <thead><tr> 
                                <th data-data="id" data-class="uk-text-center" data-width="1em">ID</th>
                                <th data-data="date" data-render="new Date(d*1000).toLocaleDateString()">Date</th>
                                <th data-data="address" >Address</th>
                                <th data-data="products" data-class="uk-text-center" data-render="'<a data-cart=\''+r['id']+'\' class=\'uk-icon-shopping-cart\'><span class=\'uk-badge\'>'+d+'</span></a>'">Products</th>
                                <th data-data="total">Total</th> 
                            </tr></thead>
                            <tbody><tr> <td colspan="4" class="uk-text-center uk-text-muted">No canceled orders</td> </tr></tbody>
                        </table>
                    </li>
                    
                    
                    <li id="profile">
                        <form class="uk-form" action="<?=URL_BASE?>ajax.php?f=postUpdateProfile" method="post">
                        <h2>Profile summary</h2>
                        <dl id="personal-summary" class="uk-description-list uk-description-list-line uk-width-medium-1-2">
                            <dt>Name</dt>
                            <dd id="personal-name" class="uk-visible-hover-inline">-</dd>

                            <dt>Family</dt>
                            <dd id="personal-family" class="uk-visible-hover-inline">-</dd>

                            
                            <dt>Phone</dt>
                            <dd id="personal-phone" class="uk-visible-hover-inline">-</dd>
                            
                            <dt>Email</dt>
                            <dd id="personal-email">-</dd>
                            
                            <dt>City</dt>
                            <dd id="personal-city" class="uk-visible-hover-inline">-</dd>
                            
                            <dt>Address</dt>
                            <dd id="personal-address" class="uk-visible-hover-inline">-</dd>
                            
                            <dt>Password</dt>
                            <dd id="personal-password" class="uk-visible-hover-inline">-</dd>
                        </dl>
                        <button id="submit-change-personal-data" type="submit" class="uk-button uk-button-primary uk-hidden">Save changes</button>
                        <button id="reset-change-personal-data" type="reset" class="uk-button uk-hidden">Reset</button>
                        </form>
                        <script>
                            $.getJSON("<?=URL_BASE?>ajax.php?f=getLogged").done(function(d){ 
                                if(d.id){
                                    var icon = ' <a class="uk-hidden uk-icon-pencil uk-float-right"></a>';
                                    $("#personal-name").html(d.name + icon);
                                    $("#personal-family").html(d.family + icon);
                                    $("#personal-phone").html(d.phone + icon);
                                    $("#personal-email").html(d.email);
                                    $("#personal-city").html(d.city + icon)
                                    $("#personal-address").html(d.address + icon);
                                    $("#personal-password").html("*****" + icon);
                                }else{
                                    window.location.href = "customer/";
                                }     
                            });
                            $("#personal-summary").on("click", ".uk-icon-pencil", function(e){
                                e.preventDefault();
                                var oldval = $.trim( $(this).parent().text() );
                                var name = $(this).parent().attr("id");
                                if(name == "personal-password"){
                                    $(this).parent().html('<input type="password" class="uk-width-1-1" name="password">');
                                }else{
                                    $(this).parent().html('<input type="text" class="uk-width-1-1" name="'+name.substring(9)+'" value="'+oldval+'">');
                                }
                                $("#submit-change-personal-data").removeClass("uk-hidden");
                                $("#reset-change-personal-data").removeClass("uk-hidden");
                            });
                            
                        </script>
                    </li>
                </ul>
            </div>
            
            <script>
                var users_carts = {};
                $("table").on("click","[data-cart]", function(k,v){
                    var id = $(this).attr("data-cart") ;
                    var tr = $(this).closest("tr");
                    
                    if(typeof users_carts[ id ] == "object"){
                        toggleCartAfterOrder( tr, users_carts[ id ] ); 
                    }else $.getJSON("<?=URL_BASE?>ajax.php?f=customer/getOrderCart&id_order="+id).done(function(ret){
                        users_carts[ id ] = ret;
                        toggleCartAfterOrder( tr, ret );
                    });
                });
                function toggleCartAfterOrder(r,d){
                    if( $(r).next().hasClass(d['id']+"_cart") ){
                        $(r).next().remove();
                    }else{
                        var c = '<table class="cart" width="100%"><thead><tr>'
                                +"<th>Product</th> <th>Qty</th> <th>ME</th> <th>Price</th> <th>Total</th>"
                            +"</tr></thead><tbody>";
                        var sum = 0;
                        $.each(d.data, function(k,v){
                            c += "<tr>"
                                +"<td>"+v['product']+"</td>"
                                +"<td data-class='uk-text-right'>"+v['qty']+"</td>"
                                +"<td data-class='uk-text-center'>"+v['unit']+"</td>"
                                +"<td data-class='uk-text-right'>"+v['price']+"</td>"
                                +"<td data-class='uk-text-right'>"+(v['qty']*v['price'])+"</td>"
                            +"</tr>";
                            sum += v['qty']*v['price'];
                        });
                        c += "</tbody><tfoot><tr><th></th> <th></th> <th></th>  <th class='uk-text-right'>Sum:</th> <th class='uk-text-left'>"+sum+"</th> </tr></tfoot></table>"
                        
                        $(r).after('<tr class="'+d['id']+'_cart"><td colspan="5">'+c+'</td></tr>');
                    }
                }
            </script>
            
        </div>
        <?php include '../snipps/foot.php'; ?>
        <script src="<?=URL_BASE.$_ASSETS['application.js']?>"></script>
    </body>
</html>
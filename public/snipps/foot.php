        <!-- footer -->
        <div class="uk-block uk-block-secondary uk-contrast">
            <div class="uk-container">

                <div class="uk-grid uk-grid-match" data-uk-grid-margin="">
                    <div class="uk-width-medium-1-3 uk-row-first">
                        <div class="uk-panel">
                            <h3>Contacts</h3>
                            <p><a href="#">Mail</a></p>
                            <p><a href="#">Facebook</a></p>
                            <p><a href="#">Phone</a></p>
                            <p><a href="#">Fax</a></p>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="uk-panel">
                            <h3>Information</h3>
                            <p><a href="#">Contacts</a></p>
                            <p><a href="#">About</a></p>
                            <p><a href="#">Legals</a></p>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="uk-panel">
                            <h3>Contact us</h3>
                            <form class="uk-form">
                                <div class="uk-form-row">
                                    <input type="text" placeholder=":focus">
                                </div>
                            </form>
                            <h3>Icons</h3>
                            <p>
                                <a href="#" class="uk-icon-hover uk-icon-medium uk-icon-github"></a>
                                <a href="#" class="uk-icon-hover uk-icon-medium uk-icon-twitter"></a>
                                <a href="#" class="uk-icon-hover uk-icon-medium uk-icon-facebook"></a>
                                <a href="#" class="uk-icon-hover uk-icon-medium uk-icon-html5"></a>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- //footer -->
        
        <div id="modal-cart" class="uk-modal">
            <div class="uk-modal-dialog"><a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"><h3>Yours shopping cart</h3></div>
                <?php include __DIR__."/../cart/content.php";?>
                <div class="uk-modal-footer">
                    <button class="uk-button uk-modal-close ">Continue shopping</button>
                    <a href="<?=URL_BASE?>order/" class="uk-button uk-button-primary uk-button-large uk-float-right"> Checkout <i class="uk-icon-truck"></i></a>
                </div>
            </div>
        </div>
        <style>
            #modal-cart .quantity { width:4em};
        </style>
        <script>
            $(document).on("shopping-cart-changed",function(e,cart){
                if(cart.nb){
                
                $("table.shopping-cart-detailed").html('<thead><tr>'
                +'  <th></th>'
                +'  <th>Product</th>'
                +'  <th>Price</th>'
                +'  <th>MU</th>'
                +'  <th>Qty</th>'
                +'  <th>Total</th>'
                +'</tr></thead>'
                +'<tbody></tbody>'
                +'<tfoot>'
                +'  <tr><th colspan="6" class="uk-text-right">'+cart.total.toFixed(2)+'</th></tr>'
                +'</tfoot>');
                $.each(cart.data, function(k,v){
                    $("table.shopping-cart-detailed").find("tbody").append('<tr>'
                    +'  <td class="uk-text-center uk-text-middle"><a href="<?=URL_BASE?>products/view/'+v.url_rewrite+'/"><img src="<?=URL_BASE?>image.php/'+v.id_image+'/small/'+v.date_add+'"</a></td>'
                    +'  <td class=" uk-text-middle" data-id="'+v.id+'">'+v.name+'</td>'
                    +'  <td class="uk-text-right uk-text-middle">'+v.price+'</td>'
                    +'  <td class="uk-text-center uk-text-middle">'+v.unit+'</td>'
                    +'  <td class="uk-text-right uk-text-middle uk-form"><input type="number" class="quantity" value="'+v.qty+'"></td>'
                    +'  <td class="uk-text-right uk-text-middle">'+(v.price*v.qty).toFixed(2)+'</td>'
                    +'</tr>');
                });
                }else{
                     $("table.shopping-cart-detailed").html("<tr><th class='uk-panel-box'> Cart is empty </th></tr>");
                }
            });
            
            $("table.shopping-cart-detailed").on("change",".quantity",function(e){
                var id = $(this).closest("tr").find("[data-id]").data("id");
                var qty = $(this).val();
                
                $.post("<?=URL_BASE?>ajax.php?f=cart/postAdd",{"id_product":id,"qty":qty}).done(function(cart){
                    $(document).trigger("shopping-cart-changed",$.parseJSON(cart));
                });
            });
            
            $.getJSON("<?=URL_BASE?>ajax.php?f=cart/getCart",function(cart){ $(document).trigger("shopping-cart-changed",cart);});
        </script>

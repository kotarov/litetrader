<script>
            $(document).on("shopping-cart-changed",function(e,cart){
                if(cart.nb){
                    $(".checkout").show();
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
                     $(".checkout").hide();
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
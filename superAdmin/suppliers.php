<?php include 'snipps/init.php'; ?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Suppliers</title>
        <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon.png">
        
        <script src="<?=$_ASSETS['jquery.js']?>"></script>
        
        <link  href="<?=$_ASSETS['uikit.css']?>" rel="stylesheet"/>
        <script src="<?=$_ASSETS['uikit.js']?>"></script>
        <script src="<?=$_ASSETS['uikit.offcanvas.js']?>"></script>
        
        <link  href="<?=$_ASSETS['uikit.notify.css']?>" rel="stylesheet" />
        <script src="<?=$_ASSETS['uikit.notify.js']?>"></script>
        
        <link  href="<?=$_ASSETS['dataTables.uikit.css']?>" rel="stylesheet">
        <script src="<?=$_ASSETS['dataTables.js']?>"></script>
        <script src="<?=$_ASSETS['dataTables.uikit.js']?>"></script>
        <script src="<?=$_ASSETS['dataTables.buttons.js']?>"></script>
        <script src="<?=$_ASSETS['dataTables.sum.js']?>"></script>
        
         <script src="<?=$_ASSETS['highlight.js']?>"></script>
        
        <link  href="<?=$_ASSETS['select2.css']?>" rel="stylesheet" />
        <script src="<?=$_ASSETS['select2.js']?>"></script>
        
        <script src="<?=$_ASSETS['chart.sparkline.js']?>"></script>
        
        <link  href="<?=$_ASSETS['application.css']?>" rel="stylesheet">
        <link  href="<?=$_ASSETS['theme.css']?>" rel="stylesheet">
    </head>
    
    <body id="page-suppliers"> 
        <?php include 'snipps/head.php'; ?>
    
        <h2 class="page-header">Suppliers <span class="uk-margin-left page-sparkline" data-table="suppliers"></span></h2>
        <div class="uk-container">
    
        <table id="suppliers" class="uk-table uk-table-hover uk-table-striped uk-table-condensed" cellspacing="0" width="100%"
            data-trigger-add="supplier-added"
            data-trigger-update="supplier-updated"
            data-trigger-delete="supplier-deleted"
        ></table>

        <script> $('#suppliers').dataTable({
            dom: '<"uk-float-right uk-margin-left"B><"uk-float-right"f>lrtip',
        	ajax: "ajax.php?f=suppliers/getSuppliers",
        	stateSave: true,
        	order: [[ 1, "asc" ]],
            columnDefs: [
                { targets:0, title: 'Active', width:"1em", class:"uk-text-center actions", render:function(d,t,r){
        			var icon = d ? "uk-icon-user" : "uk-icon-user-times uk-text-muted";
        			return '<a href="ajax.php?f=suppliers/postToggleSupplier" data-post=\'{"id":"'+r[1]+'"}\' data-toggle="is_active" data-trigger="supplier-updated" class="'+icon+'"></a>';
        		}},
                { targets:1, title: 'id', width:"1em", class:"uk-text-center id" },
                { targets:2, title: 'Name' },
                { targets:3, title: 'Phone' },
                { targets:4, title: 'Email' },
                { targets:5, title: 'Address' },
                { targets:6, title: 'Company' },
                { targets:7, title:"", width:"1em", orderable:false, searchable:false, "class":"uk-text-center uk-text-middle uk-text-nowrap actions",
        			render: function(d,t,r){
        			    var badge_cart = r[8] > 0 ? '<sup class="uk-badge uk-badge-warning" style="">'+r[8]+'</sup> ' : '';
        			    return '<span>'
        			+'<a href="#modal-cart-supplier" class="uk-icon-shopping-cart" data-uk-modal data-get="id='+r[1]+'" data-populate=\'{"id":"'+r[1]+'","name":"'+r[2]+'"}\' title="Cart">'+badge_cart+'</a>'
        			+'<a href="#modal-edit-supplier" class="uk-icon-edit" data-uk-modal data-get="id='+r[1]+'" data-populate=\'{"id":"'+r[1]+'","name":"'+r[2]+'"}\' title="Edit"></a>'
        			+'<a href="#modal-delete-supplier" class="uk-icon-trash" data-uk-modal data-get="id='+r[1]+'" data-populate=\'{"id":"'+r[1]+'","name":"'+r[2]+'"}\' title="Delete"></a>'
        			+'</span>';
        			},
        		},
            ],
            buttons: [{	text:"New", className:"uk-button uk-button-primary",
    			init: function(dt, node, config) {  node.attr("data-uk-modal",true).attr("href","#modal-new-supplier");  }
        	}],
        	fnDrawCallback:function(settings){ $("tbody",this[0]).unhighlight().highlight( this.api().search().split(" ") ); }
        }); </script>
        
        
        
        
        <?php /*** Modal NEW */ ?>
         <div id="modal-new-supplier" class="uk-modal" data-hide-on-submit>
            <div class="uk-modal-dialog">
                <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>New supplier</h3> </div>
                <form class="uk-form uk-form-horizontal" action="ajax.php?f=suppliers/postNewSupplier" data-trigger="supplier-added">
                    
                    <div class="uk-form-row">
                        <label class="uk-form-label">Name <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="name"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Family</label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="family"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Phone</label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="phone"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Email <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="email"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Skype</label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="skype"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Facebook</label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="facebook"></div>
                    </div> 
                    <div class="uk-form-row">
                        <label class="uk-form-label">Country</label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="country"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">City</label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="city"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Address</label>
                        <div class="uk-form-controls"><input type="text" class="uk-width-1-1" name="address"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Company</label>
                        <div class="uk-form-controls">
                            <select class="select2 uk-width-1-1"  style="width:100%" 
                                data-allow-clear="true" 
                                data-get="ajax.php?f=suppliers/getCompaniesForSelect" 
                                multiple name="id_company[]"
                                data-templateResult="<i class='uk-icon-building'></i> {{text}}" 
                                data-templateSelection="<i class='uk-icon-building'></i> {{text}}" 
                            ></select>
                        </div>
                    </div>
            
                    <div class="uk-modal-footer">
                        <button class="uk-button uk-button-primary">Save</button>
                        <button class="uk-button uk-modal-close">Cancel</button>
                    </div>
                
                </form>
            </div>
        </div>
        
        
        <?php /*** Modal EDIT */ ?>
         <div id="modal-edit-supplier" class="uk-modal" data-get="ajax.php?f=suppliers/getSupplier" data-hide-on-submit>
            <div class="uk-modal-dialog">
                <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>Edit supplier #<span class="uk-text-muted id"></span></h3> </div>
                <form class="uk-form uk-form-horizontal" action="ajax.php?f=suppliers/postEditSupplier" data-trigger="supplier-updated">
                    
                    <input type="hidden" name="id">
                    <div class="uk-form-row">
                        <label class="uk-form-label">Name <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="name"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Family</label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="family"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Phone</label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="phone"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Email <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="email"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Skype</label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="skype"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Facebook</label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="facebook"></div>
                    </div> 
                    <div class="uk-form-row">
                        <label class="uk-form-label">Country</label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="country"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">City</label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="city"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Address</label>
                        <div class="uk-form-controls"><input type="text" class="uk-width-1-1" name="address"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Company</label>

                        <div class="uk-form-controls">
                            <select class="select2 uk-width-1-1"  style="width:100%" 
                                data-allow-clear="true" 
                                data-get="ajax.php?f=suppliers/getCompaniesForSelect" 
                                multiple name="id_company[]"
                                data-templateResult="<i class='uk-icon-building'></i> {{text}}" 
                                data-templateSelection="<i class='uk-icon-building'></i> {{text}}" 
                            ></select>
                        </div>
                    </div>
            
                     <div class="uk-form-row">
                        <label class="uk-form-label">Password</label>
                        <div class="uk-form-controls">
                            <input type="text" class="uk-width-1-1" placeholder="•••••" name="password">
                            <p class="uk-form-help-block">Leave blank to keep the old</p>
                        </div>
                    </div>
            
            
                    <div class="uk-modal-footer">
                        <button class="uk-button uk-button-primary">Save</button>
                        <button class="uk-button uk-modal-close">Cancel</button>
                    </div>
                
                </form>
            </div>
        </div>
        
        
        <?php /*** Modal Delete */ ?>
        <div id="modal-delete-supplier" class="uk-modal" data-hide-on-submit>
            <div class="uk-modal-dialog uk-modal-dialog-small">  <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header">  <h3>Delete supplier</h3>  </div>
                <form action="ajax.php?f=suppliers/postDeleteSupplier" method="post" data-trigger="supplier-deleted">
                    <p>Are you sure you want to delete supplier #<b name="id"></b> ?</p>
                    <div class="uk-text-muted"><i class="uk-icon-user"></i> <span name="name"></span></div>
                    <input type="hidden" name="id">
                    <div class="uk-text-right">
                        <button type="submit" class="uk-button uk-button-danger">Delete</button>
                        <button class="uk-modal-close uk-button">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    
    
    <?php /*** Modal cart */ ?>
        <div id="modal-cart-supplier" class="uk-modal">
            <div class="uk-modal-dialog"> <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>Cart of supplier #<span name="id"></span></h3> </div>
                
                <table id="list-cart-supplier" data-trigger-reload="suppliercart-changed" data-get="ajax.php?f=suppliers/cart/getCart" class="uk-table uk-table-hover uk-table-striped uk-table-condensed" cellspacing="0" width="100%">
                    <tfoot><td></td> <td></td> <td></td> <td></td> <td class="uk-text-right">Sum:</td> <th></th> <td></td></tfoot>                    
                </table>
                <script>$("#list-cart-supplier").DataTable({
                    dom: 't',
                    paginate: false,
                    order: [[ "1", "asc" ]],
                    columns: [
                        { data:"image", title:"", orderable:false, sortable:false, render:function(d,t,r){
                            return '<img width="40" src="image.php/'+d+'/small/'+r['date_add']+'">';
                        }   },
                        { data:"product", title:"Product", render:function(d,t,r){return r['id_product']+'. '+d;}},
                        { data: "qty", title:"Qty"},
                        { data: "mu", title: "MU" },
                        { data: "price", title:"U.Price"},
                        { data: "sum", title: "Total", class:"sum", render:function(d,t,r,m){
                            return "<b>"+parseFloat(d).toFixed(2)+"</b>";
                        } },
                        { data: "actions", title:"", searchable:false, orderable:false, class:"uk-text-center uk-text-middle uk-text-nowrap actions",
                            render:function(d,t,r,m){
                                var edit= '<a href="#modal-edit-from-cart" class="uk-icon-edit" data-uk-modal="{modal:false}" data-get="id='+r['id']+'" data-populate=\'{"id":"'+r['id']+'"}\' title="Edit"></a>';
                                var del = '<a href="#modal-delete-from-cart" class="uk-icon-times" data-uk-modal="{modal:false}" data-get="id='+r['id']+'" data-populate=\'{"id":"'+r['id']+'","product":"'+r['product']+'","id_product":"'+r['id_product']+'"}\' title="Remove"></a>';
                                return edit + " " + del;
                            }
                        }
                    ],
                    drawCallback: function(){
                        var api = this.api();
                        $( api.table().footer() ).find(":nth-child(6)").html(
                            parseFloat(api.column( ".sum", {page:'current'} ).data().sum()).toFixed(2)
                        );
                    }
                });
                
                </script>
                <div class="uk-text-right uk-margin-top">
                    <input type="hidden" name="id">
                    <button type="button" class="uk-button uk-button-danger"> Request</button>
                    <a href="#add-to-cart" type="button" class="uk-button uk-button-success" data-uk-modal="{modal:false}"><i class="uk-icon-cart-arrow-down"></i> Add</a>
                    <button type="button" class="uk-modal-close uk-button">Exit</button>
                </div>
            
            </div>
        </div>
        
        <?php /*** Modal Edit from cart */ ?>
        <div id="modal-edit-from-cart" class="uk-modal" data-get="ajax.php?f=suppliers/cart/getEditItem" data-hide-on-submit>
            <div class="uk-modal-dialog"> <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>Edit cart product of supplier #<span class="uk-text-muted" name="id_parent"></span></h3> </div>
                <form class="uk-form uk-form-horizontal" action="ajax.php?f=suppliers/cart/postEditItem" data-trigger="suppliercart-changed,supplier-updated">
                    <input type="hidden" name="id">
                    <div class="uk-form-row">
                        <label class="uk-form-label">Product <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls">
                            <input class="uk-width-1-1" type="hidden" name="id_product"></select>
                            <input class="uk-width-1-1" name="product" readonly>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Qty <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="qty"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Price <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="price"></div>
                    </div>
                    <div class="uk-text-right uk-margin-top">
                        <button type="submit" class="uk-button uk-button-primary"> Save</button>
                        <button type="button" class="uk-modal-close uk-button">Exit</button>
                    </div>
                </form>
            </div>
        </div>
        
        <?php /*** Modal add to cart */ ?>
        <div id="add-to-cart" class="uk-modal" data-get="ajax.php?f=suppliers/cart/getNewCart" data-hide-on-submit>
            <div class="uk-modal-dialog"> <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>Add product to Cart of a supplier #<span class="uk-text-muted" name="id_parent"></span></h3> </div>
                <form class="uk-form uk-form-horizontal" action="ajax.php?f=suppliers/cart/postAppendCart" data-trigger="suppliercart-changed,supplier-updated">
                    <input type="hidden" name="id_parent">
                    <div class="uk-form-row">
                        <label class="uk-form-label">Product <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls">
                            <select class="uk-width-1-1 select2" name="id_product" style="width:100%"
                                data-placeholder="Search product" 
                                data-ajax--url="ajax.php?f=products/searchProducts"
                                data-templateSelection='<img src="image.php/{{id}}/small" width="20"> {{text}}<span>{{id}}</span> {{text}} <small class="uk-text-muted">ref.{{reference}}</small>'
                                data-templateResult='<img class="uk-align-left" src="image.php/{{id}}/small" width="40"> <span>{{id}}</span> {{text}} <small>ref: {{reference}}</small> <div><sup><i>{{category}}</i></sup></div>'
                            ></select>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Qty <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="qty"
                            data-get="ajax.php?f=products/getProduct"
                            data-depends-on="#add-to-cart [name=id_product]"
                        ></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Price <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="price"
                            data-depends-on="#add-to-cart [name=qty]"
                        ></div>
                    </div>
                    
                    <div class="uk-text-right uk-margin-top">
                        <button type="submit" class="uk-button uk-button-primary"> Append</button>
                        <button type="button" class="uk-modal-close uk-button">Exit</button>
                    </div>
                </form>
            </div>
        </div>
        
        <?php /*** Modal delete from cart */?>
         <div id="modal-delete-from-cart" class="uk-modal" data-hide-on-submit>
            <div class="uk-modal-dialog uk-modal-dialog-small"> <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>Delete product from cart of supplier #<span class="uk-text-muted" name="id_parent"></span></h3> </div>
                <form action="ajax.php?f=suppliers/cart/postRemoveItem" method="post" data-trigger="suppliercart-changed,supplier-updated">
                    <p>Remove this product #<b name="id_product"></b> ?</p>
                    <p class="uk-text-muted">"<b name="product"></b>"</p>
                    <input type="hidden" name="id">
                    <div class="uk-text-right">
                        <button type="submit" class="uk-button uk-button-danger">Remove</button>
                        <button class="uk-modal-close uk-button">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    
        <script src="<?=$_ASSETS['application.js']?>"></script>
        </div>
        <?php include 'snipps/foot.php'; ?>
    </body>
    
</html>
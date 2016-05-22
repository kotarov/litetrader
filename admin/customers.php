<?php include 'snipps/init.php'; ?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Customers</title>
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
    
    <body id="page-customers"> 
        <?php include 'snipps/head.php'; ?>
    
        <h2 class="page-header">Customers <span class="uk-margin-left page-sparkline" data-table="customers"></span></h2>
        <div class="uk-container">
    
        <table id="customers" class="uk-table uk-table-hover uk-table-striped uk-table-condensed" cellspacing="0" width="100%"
            data-trigger-add="customer-added"
            data-trigger-update="customer-updated"
            data-trigger-delete="customer-deleted"
        ></table>

        <script> $('#customers').dataTable({
            dom: '<"uk-float-right uk-margin-left"B><"uk-float-right"f>lrtip',
        	ajax: "ajax.php?f=customers/getCustomers",
        	stateSave: true,
        	order: [[ 1, "asc" ]],
            columnDefs: [
                { targets:0, title: 'Active', width:"1em", class:"uk-text-center actions", render:function(data, type, row){
        			var icon = data ? "uk-icon-user" : "uk-icon-user-times uk-text-muted";
        			return '<a href="ajax.php?f=customers/postToggleCustomer" data-post=\'{"id":"'+row[1]+'"}\' data-toggle="is_active" data-trigger="customer-updated" class="'+icon+'"></a><span class="uk-hidden">'+data+"</span>";
        		}},
                { targets:1, title: 'id', width:"1em", class:"uk-text-center id"},
                { targets:2, title: 'Name' },
                { targets:3, title: 'Phone' },
                { targets:4, title: 'Email' },
                { targets:5, title: 'Address' },
                { targets:6, title: 'Company' },
                { targets:7, title:"", width:"1em", orderable:false, searchable:false, "class":"uk-text-center uk-text-middle uk-text-nowrap actions",
        			render: function(data,type,row){
        			    var badge_cart = row[8] > 0 ? '<sup class="uk-badge uk-badge-warning" style="">'+row[8]+'</sup> ' : '';
        			    return '<span>'
        			+'<a href="#modal-cart-customer" class="uk-icon-shopping-cart uk-icon-justify" data-uk-modal data-get="id='+row[1]+'" data-populate=\'{"id":"'+row[1]+'"}\' title="Cart">'+badge_cart+'</a>'
        			+'<a href="#modal-edit-customer" class="uk-icon-edit uk-icon-justify" data-uk-modal data-get="id='+row[1]+'" data-populate=\'{"id":"'+row[1]+'"}\' title="Edit"></a>'
        			+'<a href="#modal-delete-customer" class="uk-icon-trash uk-icon-justify " data-uk-modal data-get="id='+row[1]+'" data-populate=\'{"id":"'+row[1]+'","customer":"'+row[2]+'"}\' title="Delete"></a>'
        			+'</span>';
        			},
        		},
            ],
            buttons: [{	text:"New", className:"uk-button uk-button-primary",
    			init: function(dt, node, config) {  node.attr("data-uk-modal",true).attr("href","#modal-new-customer");  }
        	}],
        	fnDrawCallback:function(settings){ $("tbody",this[0]).unhighlight().highlight( this.api().search().split(" ") ); }
        }); </script>
        
        
        
        
        <?php /*** Modal NEW */ ?>
         <div id="modal-new-customer" class="uk-modal" data-hide-on-submit>
            <div class="uk-modal-dialog">
                <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>New customer</h3> </div>
                <form class="uk-form uk-form-horizontal" action="ajax.php?f=customers/postNewCustomer" data-trigger="customer-added">
                    
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
                            <select class="select2 uk-width-1-1" style="width:100%" 
                                data-allow-clear="true" 
                                data-get="ajax.php?f=customers/getCompaniesForSelect" 
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
         <div id="modal-edit-customer" class="uk-modal" data-get="ajax.php?f=customers/getCustomer" data-hide-on-submit>
            <div class="uk-modal-dialog">
                <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>Edit customer #<span class="uk-text-muted" name="id"></span></h3> </div>
                <form class="uk-form uk-form-horizontal" action="ajax.php?f=customers/postEditCustomer" data-trigger="customer-updated">
                    
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
                                data-get="ajax.php?f=customers/getCompaniesForSelect" 
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
        <div id="modal-delete-customer" class="uk-modal" data-hide-on-submit>
            <div class="uk-modal-dialog uk-modal-dialog-small">  <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header">  <h3>Delete customer #<span name="id"></span></h3>  </div>
                <form action="ajax.php?f=customers/postDeleteCustomer" method="post" data-trigger="customer-deleted">
                    <p>Are you sure you want to delete this customer: <br>"<b name="customer"></b>" ?</p>
                    <input type="hidden" name="id">
                    <div class="uk-text-right">
                        <button type="submit" class="uk-button uk-button-danger">Delete</button>
                        <button class="uk-modal-close uk-button">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    
    
    <?php /*** Modal cart */ ?>
        <div id="modal-cart-customer" class="uk-modal">
            <div class="uk-modal-dialog"> <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>Cart of customer #<span name="id"></span></h3> </div>
                
                <table id="list-cart-customer" cellspacing="0" width="100%" 
                    data-trigger-reload="customercart-changed" 
                    data-get="ajax.php?f=customers/cart/getCart" 
                    class="dataTable uk-table uk-table-hover uk-table-striped uk-table-condensed" 
                >
                    <tfoot><td></td> <td></td> <td></td> <td></td> <td></td><td class="uk-text-right">Sum:</td> <th class="sum"></th> <td></td></tfoot>                    
                </table>
                <script>$("#list-cart-customer").DataTable({
                    dom: 't',
                    paginate: false,
                    order: [[ "1", "asc" ]],
                    columns: [
                        { data:"image", title:"", orderable:false, sortable:false, render:function(d,t,r){
                            return '<img width="40" src="image.php/'+d+'/small/'+r['date_add']+'">';
                        }   },
                        { data:"product", title:"Product", render:function(d,t,r){return r['id_product']+'. '+d;}},
                        { data: "note", title:"Note" },
                        { data: "qty", title:"Qty"},
                        { data: "mu", title: "MU" },
                        { data: "price", title:"U.Price"},
                        { data: "sum", title: "Total", class:"sum", render:function(d,t,r,m){
                            return "<b>"+parseFloat(d).toFixed(2)+"</b>";
                        } },
                        { data: "actions", title:"", searchable:false, orderable:false, class:"uk-text-center uk-text-middle uk-text-nowrap",
                            render:function(d,t,r,m){
                                var del = '<a href="#modal-delete-from-cart" class="uk-icon-times" data-uk-modal="{modal:false}" data-populate=\'{"id":"'+r['id']+'","id_product":"'+r['id_product']+'","product":"'+r['product']+'"}\' title="Remove"></a>',
                                    edit= '<a href="#modal-edit-from-cart" class="uk-icon-edit" data-uk-modal="{modal:false}" data-get="id='+r['id']+'" data-populate=\'{"id":"'+r['id']+'"}\' title="Edit"></a>';
                                return edit + " " + del;
                        }   }
                    ],
                    drawCallback: function(){ 
                        var api = this.api(); $( api.table().footer() ).find(".sum").html(
                            parseFloat(api.column( ".sum", {page:'current'} ).data().sum()).toFixed(2)
                        );
                    }
                });</script>
                
                <div class="uk-text-right uk-margin-top">
                    <input type="hidden" name="id">
                    <button type="button" class="uk-button uk-button-primary"> Order</button>
                    <a href="#add-to-cart" type="button" class="uk-button uk-button-success" data-uk-modal="{modal:false}"><i class="uk-icon-cart-arrow-down"></i> Add</a>
                    <button type="button" class="uk-modal-close uk-button">Exit</button>
                </div>
            </div>
        </div>
        
        <?php /*** Modal Edit from cart */ ?>
        <div id="modal-edit-from-cart" class="uk-modal" data-get="ajax.php?f=customers/cart/getEditItem" data-hide-on-submit>
            <div class="uk-modal-dialog"> <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>Edit product of cart #<span name="id_parent"></span></h3> </div>
                <form class="uk-form uk-form-horizontal" action="ajax.php?f=customers/cart/postEditItem" data-trigger="customercart-changed,customer-updated">
                    <input type="hidden" name="id">
                    <div class="uk-form-row">
                        <label class="uk-form-label">Product <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls">
                            <input class="uk-width-1-1" type="hidden" name="id_product"></select>
                            <input class="uk-width-1-1" name="product" readonly>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Note</label>
                        <div class="uk-form-controls">
                            <input class="uk-width-1-1" type="text" name="note">
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Qty <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="qty"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">ME</label>
                        <div class="uk-form-controls">
                            <select class="uk-width-1-1" type="text" name="id_unit" 
                                data-value-depends-on="#add-to-cart [name=qty]" 
                                data-get="ajax.php?f=products/units/getMeasureUnits"
                            ></select>
                        </div>
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
        <div id="add-to-cart" class="uk-modal" data-get="ajax.php?f=customers/cart/getNewCart" data-hide-on-submit>
            <div class="uk-modal-dialog"> <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>Add product to Cart</h3> </div>
                <form class="uk-form uk-form-horizontal" action="ajax.php?f=customers/cart/postAppendCart" data-trigger="customercart-changed,customer-updated">
                    <input type="hidden" name="id_parent">
                    <div class="uk-form-row">
                        <label class="uk-form-label">Product <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls">
                            <select id="addtocart-idproduct" class="uk-width-1-1 select2" style="width:100%"
                                name="id_product" 
                                data-placeholder="Search product"
                                data-ajax--url="ajax.php?f=products/searchProducts"
                                data-templateResult='
                                    <img class="uk-align-left" src="image.php/{{id}}/small" width="40"> 
                                    <span>{{id}}</span> {{text}} <small class="uk-text-muted">ref: {{reference}}</small>
                                    <div><sup><i class="uk-text-muted">{{category}}</i></sup></div>'
                                data-templateSelection='
                                    <img src="image.php/{{id}}/small" width="20"> 
                                    <span>{{id}}</span> {{text}}
                                    <small class="uk-text-muted">ref.{{reference}}</small>'
                            ></select>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Note</label>
                        <div class="uk-form-controls">
                            <input class="uk-width-1-1" type="text" name="note">
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Qty <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" data-depends-on="#addtocart-idproduct" data-get="ajax.php?f=products/getProduct" type="text" name="qty"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">ME</label>
                        <div class="uk-form-controls">
                            <select class="uk-width-1-1" type="text" name="id_unit" 
                                data-value-depends-on="#add-to-cart [name=qty]" 
                                data-get="ajax.php?f=products/units/getMeasureUnits"
                            ></select>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">Price <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" data-depends-on="#add-to-cart [name=qty]" type="text" name="price"></div>
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
                <div class="uk-modal-header"> <h3>Delete product</h3> </div>
                <form action="ajax.php?f=customers/cart/postRemoveItem" method="post" data-trigger="customercart-changed,customer-updated">
                    <p>Remove this product <br>"<b name="id_product"></b>. <b name="product"></b>" ?</p>
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
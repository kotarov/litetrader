<?php include 'snipps/init.php'; ?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Orders</title>
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
        <script src="<?=$_ASSETS['lang.js']?>"></script>
        
        <link  href="<?=$_ASSETS['application.css']?>" rel="stylesheet">
        <link  href="<?=$_ASSETS['theme.css']?>" rel="stylesheet">
    </head>
    
    <body id="page-customers"> 
        <?php include 'snipps/head.php'; ?>
            
        <h2 class="page-header">Customers Orders <span class="uk-margin-left page-sparkline" data-table="customers_orders"></span></h2>
        <div class="uk-container">
        
        <table id="orders" class="uk-table uk-table-hover uk-table-striped uk-table-condensed" cellspacing="0" width="100%"
            data-trigger-add="order-added"
            data-trigger-update="order-updated"
            data-trigger-delete="order-deleted"
        ><tfoot><tr> <th></th> <th></th> <th></th> <th></th> <th></th> <td class="uk-text-right">Current page SUM:</td> <th class="sum"></th>  </tr></tfoot></table>

        <script> 
            $("#orders").DataTable({
            	dom: '<"uk-float-right uk-margin-left"B><"uk-float-right"f><"uk-float-left"lr> tip',
            	ajax: "ajax.php?f=customers/orders/getOrders",
            	stateSave: true,
            	order: [[ 1, "desc" ]],
            	columnDefs: [
            		{ targets:0, title:"Status", width:"1em","class":"uk-text-center uk-text-middle actions",render:function(d,t,r){
            		    return '<a href="#modal-change-status" data-uk-modal data-get="id='+r[1]+'" data-populate=\'{"id":"'+r[1]+'"}\' title="'+r[11]+'"> <i class="'+d+'" style="color:'+r[10]+'"></i>'
            		        +(r[9]==1?' <small class="uk-icon-lock uk-text-small"></small> ':' ')+'</a><i class="uk-hidden">'+r[11]+'</i>';
            		}},
            		{ targets:1, title:"Id", width:"2em","class":"uk-text-center uk-text-middle id" },
            		{ targets:2, title:"Date", "class":"uk-text-center uk-text-middle", render:function(d,t,r){
            		    var date = d?(new Date(d * 1000).toLocaleDateString()):'-';
            		    return date!='-'?date:'-';
            		}},
            		{ targets:3, title:"Customer", render:function(d,t,r){return (r[8]>0?d:d+' <small class="uk-badge uk-badge-warning">Unregistered</small> ')} },
            		{ targets:4, title:"Company",render:function(d,t,r){return (d?d:"-");}},
            		{ targets:5, title:"Address"  },
            		{ targets:6, title:"Total","class":"uk-text-right sum", render:function(d,t,r){
            		    return '<a href="#modal-cart-order" data-uk-modal data-get="id='+r[1]+'" data-populate=\'{"id":"'+r[1]+'"}\' style="color:inherit">'+(d?d:'<i class="uk-icon-cart-arrow-down uk-text-success"></i> &nbsp;')+ '</a>';
            		} },
            	    { targets:7, title:"", width:"1em", orderable:false, searchable:false, "class":"uk-text-center uk-text-middle uk-text-nowrap actions",
            		    render: function(d,t,r){ return ''
            			+'<a href="#modal-edit-order" data-uk-modal class="uk-icon-edit uk-icon-justify" data-get="id='+d+'" data-populate=\'{"id":"'+d+'"}\' title="Edit"></a>'
            			+'<a href="#modal-delete-order" data-uk-modal class="uk-icon-trash uk-icon-justify" data-get="id='+d+'" data-populate=\'{"id":"'+d+'"}\' title="Delete"></a>';
            		}    }
            	],
            	buttons: [{	text:"New", className:"uk-button uk-button-primary",
            		init: function(dt, node, config){ node.attr("data-uk-modal",true).attr("href","#modal-new-order"); }
            	}],
                fnDrawCallback:function(settings){ $("tbody",this[0]).unhighlight().highlight( this.api().search().split(" ") ); 
                    var api = this.api(); $( api.table().footer() ).find(".sum").html(
                        parseFloat(api.column( ".sum", {page:'current'} ).data().sum()).toFixed(2)
                    );
                }
            });    		
        </script>
        
        
        <?php /*** Modal NEW */ ?>
         <div id="modal-new-order" class="uk-modal" data-hide-on-submit>
            <div class="uk-modal-dialog uk-modal-dialog-medium"> <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>New customer's order</h3> </div>
                <form id="svetlio"  class="uk-form uk-form-horizontal" action="ajax.php?f=customers/orders/postNewOrder" data-trigger="order-added">
                    
                    <style scoped>legend{background:#eee;padding-bottom:0!important;margin-bottom:15px}</style>
                     <ul class="uk-tab uk-margin-bottom" data-uk-tab="{connect:'#modal-new-orders-customer-inputs,#modal-new-orders-buttons'}">
                        <li class="uk-active"><a href="">Registered customer</a></li>
                        <li><a href="">Unregistered customer</a></li>
                    </ul>

                    <ul id="modal-new-orders-customer-inputs" class="uk-switcher uk-width-1-1">
                    <li class="uk-width-1-1"> <!-- ********* -->
                        <div class="uk-form-row">
                            <label class="uk-form-label">Customer <span class="uk-text-danger">*</span></label>
                            <div class="uk-form-controls">
                                <select class="select2 uk-width-1-1" style="width:100%" 
                                    name="id_customer" 
                                    data-allow-clear= "true" 
                                    data-ajax--url="ajax.php?f=customers/searchCustomers" 
                                    data-templateResult = '<span>
                                            <i class="uk-icon-user"></i> {{text}}
                                            <div><small> {{id}} | <i class="uk-icon-phone"></i> {{phone}} | <i class="uk-icon-envelope"></i> {{email}} </small></div>
                                            <div><small><i class="uk-icon-building-o"></i> {{companies}}</small></div>
                                        </span>'
                                    data-templateSelection = '<span><i class="uk-icon-user"></i> {{text}} <small>( {{id}} )</small></span>' 
                                ></select>
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label">Company </label>
                            <div class="uk-form-controls">
                                <select class="select2 uk-width-1-1" style="width:100%" 
                                    name="id_company" 
                                    data-allow-clear="true" 
                                    data-get="ajax.php?f=customers/getCompaniesForSelect"
                                    data-depends-on="#modal-new-order [name=id_customer]" 
                                    data-templateSelection = '<i class="{{icon}}"></i> {{text}}'
                                    data-templateResult = '<i class="{{icon}}"></i> {{text}}<br><small><i class="uk-icon-phone"></i> {{phone}} | <i class="uk-icon-envelope"></i> {{email}}</small>'
                                ></select>
                            </div>
                        </div>
                    
                    </li><li> <!-- ********* -->
                        <div class="uk-form-row">
                            <label class="uk-form-label">Customer name <span class="uk-text-danger">*</span></label>
                            <div class="uk-form-controls"><input name="customer" class="select2 uk-width-1-1"></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label">Company</label>
                            <div class="uk-form-controls"><input name="company" class="select2 uk-width-1-1"></div>
                        </div>
                    </li>

                    </ul>


                    <div class="uk-form-row uk-margin-top">
                            <label class="uk-form-label">EIN</label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" 
                                name="ein" 
                                data-depends-on="#modal-new-order [name=id_company],#modal-new-order [name=id_customer]" 
                                data-get="ajax.php?f=customers/orders/getContactData&field=ein" 
                            ></div>
                    </div>
                    
                    <br>
                    <legend> &nbsp; Address</legend>
                        <div class="uk-form-row">
                            <label class="uk-form-label">Email <span class="uk-text-muted">*</span></label>
                            <div class="uk-form-controls"><input class="uk-width-1-1"
                                name="email" 
                                data-depends-on="#modal-new-order [name=id_company],#modal-new-order [name=id_customer]"
                                data-get="ajax.php?f=customers/orders/getContactData&field=email" 
                            ></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label">Phone <span class="uk-text-muted">*</span></label>
                            <div class="uk-form-controls"><input name="phone" class="uk-width-1-1"
                                data-depends-on="#modal-new-order [name=id_company],#modal-new-order [name=id_customer]"
                                data-get="ajax.php?f=customers/orders/getContactData&field=phone" 
                            >
                                <p class="uk-form-help-block"><span class="uk-text-danger">*</span> One of the both <b>phone</b> or <b>email</b> is required </p>
                            </div>
                        </div>
                        
                        
                        <div class="uk-form-row">
                            <label class="uk-form-label">Country </label>
                            <div class="uk-form-controls">
                                <input type="text" class="uk-width-1-1" 
                                    name="country"
                                    data-depends-on="#modal-new-order [name=id_company],#modal-new-order [name=id_customer]"
                                    data-get="ajax.php?f=customers/orders/getContactData&field=country"  
                                >
                            </div>
                        </div> 
                        <div class="uk-form-row">
                            <label class="uk-form-label">City</label>
                            <div class="uk-form-controls">
                                <input type="text" class="uk-width-1-1" 
                                    name="city"
                                    data-depends-on="#modal-new-order [name=id_company],#modal-new-order [name=id_customer]"
                                    data-get="ajax.php?f=customers/orders/getContactData&field=city" 
                                >
                            </div>
                        </div> 
                        <div class="uk-form-row">
                            <label class="uk-form-label">Address </label>
                            <div class="uk-form-controls">
                                <input class="uk-width-1-1" 
                                    name="address"
                                    data-depends-on="#modal-new-order [name=id_company],#modal-new-order [name=id_customer]"
                                    data-get="ajax.php?f=customers/orders/getContactData&field=address" 
                                >
                                <p class="uk-form-help-block"><span class="uk-text-danger">*</span> If is set company all <b>address</b> fields are required </p>
                            </div>
                        </div>
                
                    <div class="uk-modal-footer">
                        
                        <span id="modal-new-orders-buttons" class="uk-switcher">
                            <span> </span>
                            <span>
                                <input name="non-registered" type="hidden" value="1">
                                <label class="uk-text-warning"> Register as new customer <input type="checkbox" name="register-new-customer"> &nbsp;&nbsp;&nbsp;</label>
                            </span>
                        </span>
                        <button class="uk-button uk-button-primary">Next >></button>
                        <button class="uk-button uk-modal-close ">Cancel</button>
                    </div>
                </form>
                
            </div>
        </div>
        
        
        
        <?php /*** Modal EDIT */ ?>
         <div id="modal-edit-order" class="uk-modal" data-get="ajax.php?f=customers/orders/getOrder" data-hide-on-submit>
            <div class="uk-modal-dialog uk-modal-dialog-medium"> <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>Edit customer's order #<span name="id"></span></h3> </div>
                <form class="uk-form uk-form-horizontal" action="ajax.php?f=customers/orders/postEditOrder" data-trigger="order-updated">
                    <input type="hidden" name="id">
                    
                        <style scoped>legend{background:#eee;padding-bottom:0!important;margin-bottom:15px}</style>
                        <div class="uk-form-row">
                            <div class="uk-form-controls">
                                <ul class="uk-switcher" name="is_registered">
                                    <li data-value="1" class="uk-badge1"> Customer's registration id: <b name="id_customer"></b> </li>
                                    <li data-value="0" class="uk-badge uk-badge-warning">Unregistered customer</li>
                                </ul>
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label">Customer name <span class="uk-text-danger">*</span></label>
                            <div class="uk-form-controls">
                                <input type="text" name="customer" class="uk-width-1-1">
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label">Company </label>
                            <div class="uk-form-controls">
                                <input type="text" name="company" class="uk-width-1-1">
                            </div>
                        </div>
                     <div class="uk-form-row uk-margin-top">
                            <label class="uk-form-label">EIN</label>
                            <div class="uk-form-controls">
                                <input class="uk-width-1-1" name="ein">
                            </div>
                    </div>
                    
                    <br>
                    <legend> &nbsp; Address</legend>
                        <div class="uk-form-row">
                            <label class="uk-form-label">Email <span class="uk-text-muted">*</span></label>
                            <div class="uk-form-controls">
                                <input class="select2 uk-width-1-1"name="email">
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label">Phone <span class="uk-text-muted">*</span></label>
                            <div class="uk-form-controls">
                                <input name="phone" class="select2 uk-width-1-1">
                                <p class="uk-form-help-block"><span class="uk-text-danger">*</span> One of the both <b>phone</b> or <b>email</b> is required </p>
                            </div>
                        </div>
                        
                        
                        <div class="uk-form-row">
                            <label class="uk-form-label">Country </label>
                            <div class="uk-form-controls">
                                <input type="text" class="uk-width-1-1" name="country">
                            </div>
                        </div> 
                        <div class="uk-form-row">
                            <label class="uk-form-label">City</label>
                            <div class="uk-form-controls">
                                <input type="text" class="uk-width-1-1" name="city">
                            </div>
                        </div> 
                        <div class="uk-form-row">
                            <label class="uk-form-label">Address </label>
                            <div class="uk-form-controls">
                                <input class="uk-width-1-1" name="address">
                                <p class="uk-form-help-block"><span class="uk-text-danger">*</span> If is set company all <b>address</b> fields are required </p>
                            </div>
                        </div>

                    <div class="uk-modal-footer">
                        <button class="uk-button uk-button-primary">Next >></button>
                        <button class="uk-button uk-modal-close ">Cancel</button>
                    </div>
                </form>
                
                </form>
            </div>
        </div>
        
        
        
        <?php /*** Modal Delete */ ?>
        <div id="modal-delete-order" class="uk-modal" data-hide-on-submit>
            <div class="uk-modal-dialog uk-modal-dialog-small">  <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header">  <h3>Delete order</h3>  </div>
                <form action="ajax.php?f=customers/orders/postDeleteOrder" method="post" data-trigger="order-deleted" data-hide-on-submit>
                    <p>Are you sure you want to delete order #<b name="id"></b> ?</p>
                    <input type="hidden" name="id">
                    <div class="uk-text-right">
                        <button type="submit" class="uk-button uk-button-danger">Delete</button>
                        <button class="uk-modal-close uk-button">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        
        <?php /*** Modal Change STATUS */ ?>
        <div id="modal-change-status" class="uk-modal">
            <div class="uk-modal-dialog">  <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header">  <h3>Change status of order #<b name="id"></b></h3>  </div>

                <form class="uk-form uk-form-horizontal" action="ajax.php?f=customers/orders/postStatus" data-trigger="ordercart-changed,order-updated">
                    <input type="hidden" name="id">                
                    <div class="uk-form-row">
                        <label class="uk-form-label">Status <span class="uk-text-danger">*</span> </label>
                        <div class="uk-form-controls">
                            <select class="select2 uk-width-1-1" style="width:100%" 
                                name="id_status"
                                data-get="ajax.php?f=customers/orders/getStatuses&first=%2B Change status ..." 
                                data-templateResult='<span><i class="{{icon}}" style="color:{{color}}"></i> {{name}}</span>' 
                                data-templateSelection='<span><i class="{{icon}}" style="color:{{color}}"></i> {{name}}</span>' 
                                type="submit" 
                            ></select>
                        </div>
                    </div>
                </form>
                
                <table id="list-order-statuses" data-trigger-reload="ordercart-changed" data-get="ajax.php?f=customers/orders/getStatusesHistory" 
                    class="uk-table uk-table-hover uk-table-striped uk-table-condensed" cellspacing="0" width="100%">
                </table>
                <script>$("#list-order-statuses").DataTable({
                    dom: 't',
                    paginate: false,
                    ordering:false,
                    columns: [
                        { data: "icon", title:"Icon", render:function(d,t,r){return '<i class="'+d+'" style="color:'+r['color']+'"></i>';}},
                        { data: "status", title:"Status" },
                        { data: "date_add", title:"Date", render:function(d,t,r){return new Date(d*1000).toLocaleString();}},
                        { data: "user", title:"User"}
                    ]
                });</script>
                
                
                <div class="uk-modal-footer">
                    <button class="uk-modal-close uk-button">Exit</button>
                </div>
            </div>
        </div>
        
        
        
        
         <?php /*** Modal cart */ ?>
        <div id="modal-cart-order" class="uk-modal">
            <div class="uk-modal-dialog"> <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>Cart of order #<span name="id"></span></h3> </div>
                
                <table id="list-cart-customer" data-trigger-reload="order-cart-changed" data-get="ajax.php?f=customers/orders_products/getCart" class="uk-table uk-table-hover uk-table-striped uk-table-condensed" cellspacing="0" width="100%">
                    <tfoot><td></td> <td></td> <td></td> <td></td> <td></td><td class="uk-text-right">Sum:</td> <th></th> <td></td></tfoot>                    
                </table>
                <script>$("#list-cart-customer").DataTable({
                    dom: 't',
                    paginate: false,
                    order: [[ "1", "asc" ]],
                    columns: [
                        { data: "image", title:"", orderable:false, sortable:false, render:function(d,t,r){
                            return '<img width="40" src="image.php/'+d+'/small/'+r['date_add']+'">';
                        }   },
                        { data: "product", title:"Product", render:function(d,t,r){return r['id_product']+'. '+d;}},
                        { data: "note", title:"Note"},
                        { data: "qty", title:"Qty"},
                        { data: "mu", title: "MU" },
                        { data: "price", title:"U.Price"},
                        { data: "total", title: "Total", class:"sum", render:function(d,t,r,m){
                            return "<b>"+parseFloat(d).toFixed(2)+"</b>";
                        } },
                        { data: "actions", title:"", searchable:false, orderable:false, class:"uk-text-center uk-text-middle uk-text-nowrap",
                            render:function(d,t,r,m){
                                var del = '<a href="#modal-delete-from-cart" class="uk-icon-times" data-uk-modal="{modal:false}"  data-populate=\'{"id_product":"'+r['id_product']+'","product":"'+r['product']+'"}\' title="Remove"></a>',
                                    edit= '<a href="#modal-edit-from-cart" class="uk-icon-edit" data-uk-modal="{modal:false}" data-get="id='+r['id']+'" data-populate=\'{"id_product":"'+r['id_product']+'"}\' title="Edit"></a>';
                                return edit + " " + del;
                        }   }
                    ],
                    drawCallback: function(){ var api = this.api(); $( api.table().footer() ).find(".sum").html(
                        parseFloat(api.column( ".sum", {page:'current'} ).data().sum()).toFixed(2)
                    );}
                });</script>
                
                <div class="uk-text-right uk-margin-top">
                    <input type="hidden" name="id">
                    <button type="button" class="uk-button uk-button-danger"> Invoice</button>
                    <a href="#add-to-cart" type="button" class="uk-button uk-button-success" data-uk-modal="{modal:false}"><i class="uk-icon-cart-arrow-down"></i> Add</a>
                    <button type="button" class="uk-modal-close uk-button">Exit</button>
                </div>
            </div>
        </div>
        
        <?php /*** Modal Edit from cart */ ?>
        <div id="modal-edit-from-cart" class="uk-modal" data-get="ajax.php?f=customers/orders_products/getEditProduct" data-hide-on-submit>
            <div class="uk-modal-dialog"> <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>Edit product of order #<span name="id_parent"></span></h3> </div>
                <form class="uk-form uk-form-horizontal" action="ajax.php?f=customers/orders_products/postEditProduct" data-trigger="order-cart-changed,order-updated">
                    <input type="hidden" name="id_parent">
                    <input type="hidden" name="id_product">
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
                        <div class="uk-form-controls">
                            <input class="uk-width-1-1" type="text" name="qty"
                                data-depends-on="#add-to-cart [name=id_product]"
                                data-get="ajax.php?f=products/getProduct"
                            >
                        </div>
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
                        <div class="uk-form-controls">
                            <input class="uk-width-1-1" type="text" name="price"
                                data-depends-on="#add-to-cart [name=qty]"
                            >
                        </div>
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
                <div class="uk-modal-header"> <h3>Add product to Order #<span name="id_parent"></span></h3> </div>
                <form class="uk-form uk-form-horizontal" action="ajax.php?f=customers/orders_products/postAppendCart" data-trigger="order-cart-changed,order-updated">
                    <input type="hidden" name="id_parent">
                    <div class="uk-form-row">
                        <label class="uk-form-label">Product <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls">
                            <select class="uk-width-1-1 select2" name="id_product" style="width:100%" 
                                data-ajax--url="ajax.php?f=products/searchProducts" 
                                data-templateResult1='<span><img class="uk-align-left" src="image.php/{{id}}/small" width="40"> {{text}}</span>'
                                data-templateResult='
                                    <img class="uk-align-left" src="image.php/{{id}}/small" width="40"> 
                                    <span>{{id}}</span> {{text}} <small class="uk-text-muted">ref: {{reference}}</small>
                                    <div><sup><i>{{category}}</i></sup></div>'
                                data-templateSelection='
                                    <img src="image.php/{{id}}/small" width="20"> 
                                    <span>{{id}}</span> {{text}}
                                    <small class="uk-text-muted>ref.{{reference}}</small>'
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
                        <div class="uk-form-controls">
                            <input class="uk-width-1-1" type="text" name="qty"
                                data-depends-on="#add-to-cart [name=id_product]"
                                data-get="ajax.php?f=products/getProduct"
                            >
                        </div>
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
                        <div class="uk-form-controls">
                            <input class="uk-width-1-1" type="text" name="price"
                                data-depends-on="#add-to-cart [name=qty]"
                            >
                        </div>
                    </div>
                    <div class="uk-text-right uk-margin-top">
                        <button type="submit" class="uk-button uk-button-primary"> Add</button>
                        <button type="button" class="uk-modal-close uk-button">Exit</button>
                    </div>
                </form>
            </div>
        </div>
        
        <?php /*** Modal delete from cart */?>
         <div id="modal-delete-from-cart" class="uk-modal" data-hide-on-submit>
            <div class="uk-modal-dialog uk-modal-dialog-small"> <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>Delete product</h3> </div>
                <form action="ajax.php?f=customers/orders_products/postRemoveProduct" method="post" data-trigger="order-cart-changed,order-updated">
                    <p>Remove this product <br>"<b name="id_product"></b>. <b name="product"></b>" ?</p>
                    <input type="hidden" name="id_parent">
                    <input type="hidden" name="id_product">
                    <div class="uk-text-right">
                        <button type="submit" class="uk-button uk-button-danger">Remove</button>
                        <button class="uk-modal-close uk-button">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    
    
    </div> 

        
        
        <?php include 'snipps/foot.php'; ?>
        
        <script src="<?=$_ASSETS['application.js']?>"></script>
        
    </body>
</html>
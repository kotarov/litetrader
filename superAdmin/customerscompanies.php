<?php include 'snipps/init.php'; ?>
<!DOCTYPE html>
<html class="uk-height-1-1">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Customers companies</title>
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
        
        <script src="<?=$_ASSETS['highlight.js']?>"></script>
        
        <script src="<?=$_ASSETS['lang.js']?>"></script>
        
        <link  href="<?=$_ASSETS['select2.css']?>" rel="stylesheet" />
        <script src="<?=$_ASSETS['select2.js']?>"></script>
        
        <link  href="<?=$_ASSETS['application.css']?>" rel="stylesheet">
        <link  href="<?=$_ASSETS['theme.css']?>" rel="stylesheet">
    </head>
    
    <body id="page-customers"> 
        <?php include 'snipps/head.php'; ?>
    
        <h2 class="page-header">Customer's companies</h2>
        <div class="uk-container">
        
        <table id="companies" class="uk-table uk-table-hover uk-table-striped uk-table-condensed" cellspacing="0" width="100%"
            data-trigger-add="company-added"
            data-trigger-update="company-updated"
            data-trigger-delete="company-deleted"
        ></table>
        
        <script>$('#companies').DataTable({
            dom: '<"uk-float-right uk-margin-left"B><"uk-float-right"f>lrtip',
        	ajax: "ajax.php?f=customers/getCompanies",
        	stateSave: true,
        	order: [[ 0, "asc" ]],
            columnDefs: [
                { targets:0, title: 'id', width:"1em", class:"uk-text-center id" },
                { targets:1, title: 'Name', render: function(data,type,row){ return ''
                    +'<i class="uk-icon-building"></i> '+ data;
                } },
                { targets:2, title: 'Email' },
                { targets:3, title: 'Phone' },
                { targets:4, title: 'Mrp' },
                { targets:5, title: 'EIN' },
                { targets:6, title: 'Address' },
                { targets:7, title:"", width:"1em", orderable:false, searchable:false, "class":"uk-text-center uk-text-middle uk-text-nowrap actions",
        			render: function(data,type,row){
                        var badge_empl = row[8] > 0 ? '<sup class="uk-badge uk-badge-success" style="">'+row[8]+'</sup> ' : '';
        			    return ''
        			+'<a class="uk-icon-edit uk-icon-justify"  href="#modal-edit-company"   data-uk-modal data-get="id='+row[0]+'" data-populate=\'{"id":"'+row[0]+'"}\' title="Edit"></a>'
        			+'<a class="uk-icon-users uk-icon-justify" href="#modal-company-employees" data-uk-modal data-get="id='+row[0]+'" data-populate=\'{"id":"'+row[0]+'"}\' title="Companies">'+badge_empl+'</a>'
        			+'<a class="uk-icon-trash uk-icon-justify" href="#modal-delete-company" data-uk-modal data-get="id='+row[0]+'" data-populate=\'{"id":"'+row[0]+'"}\' title="Delete"></a>';
        		},  },
            ],
            buttons: [{	text:"New", className:"uk-button uk-button-primary", 
                init: function(dt, node, config) {  node.attr("data-uk-modal",true).attr("href","#modal-new-company");  }
        	}],
        	fnDrawCallback:function(settings){ $("tbody",this[0]).unhighlight().highlight( this.api().search().split(" ") ); }
        });</script>
        
        
        
        
        <?php /*** Modal NEW */ ?>
         <div id="modal-new-company" class="uk-modal" data-hide-on-submit>
            <div class="uk-modal-dialog">
                <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>New customer's company</h3> </div>
                <form class="uk-form uk-form-horizontal" action="ajax.php?f=customers/postNewCompany" data-trigger="company-added">
                    
                    <div class="uk-form-row">
                        <label class="uk-form-label">Name <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="name"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">MRP</label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="mrp"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">EIN <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="ein"></div>
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
                        <label class="uk-form-label">Twitter</label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="twitter"></div>
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
            
                    <div class="uk-modal-footer">
                        <button class="uk-button uk-button-primary">Save</button>
                        <button class="uk-button uk-modal-close">Cancel</button>
                    </div>
                
                </form>
            </div>
        </div>
        
        
        <?php /*** Modal EDIT */ ?>
         <div id="modal-edit-company" class="uk-modal" data-get="ajax.php?f=customers/getCompany" data-hide-on-submit>
            <div class="uk-modal-dialog">
                <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>Edit supplier's company #<span class="uk-text-muted" name="id"></span></h3> </div>
                <form class="uk-form uk-form-horizontal" action="ajax.php?f=customers/postEditCompany" data-trigger="company-updated">
                    
                    <input type="hidden" name="id">
                    <div class="uk-form-row">
                        <label class="uk-form-label">Name <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="name"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">MRP</label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="mrp"></div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">EIN</label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="ein"></div>
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
                        <label class="uk-form-label">Twitter</label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="twitter"></div>
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
            
                    <div class="uk-modal-footer">
                        <button type="submit" class="uk-button uk-button-primary">Save</button>
                        <button class="uk-button uk-modal-close">Cancel</button>
                    </div>
                
                </form>
            </div>
        </div>

        
        
        
        <?php /*** Modal Company EMPLOEES List */ ?>
        <div id="modal-company-employees" class="uk-modal">
            <div class="uk-modal-dialog"> <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>Emploees of company #<span name="id"></span></h3> </div>
                
                <table id="list-company-employees" cellspacing="0" width="100%" 
                    data-trigger-reload="employees-changed" 
                    data-get="ajax.php?f=customers/customers_companies/getCompanyEmployees" 
                    class="uk-table uk-table-hover uk-table-striped uk-table-condensed" 
                ></table>
                <script>$("#list-company-employees").DataTable({
                    dom: 't',
                    paginate: false,
                    order: [[ 1, "asc" ]],
                    columnDefs: [
                        { targets:0, title:'', orderable:false, width:"1em", class:"uk-text-center", render: function(d,t,r){
                                var icon = d ? "uk-icon-user" : "uk-icon-user-times uk-text-muted";
                			    return '<a href="ajax.php?f=customers/postToggleCustomer" data-toggle="is_active" data-post=\'{"id":"'+r[1]+'"}\' data-trigger="employees-changed" class="'+icon+'"></a><span class="uk-hidden">'+d+"</span>";    
                        }   },
                        { targets:1, title: 'id', class:"uk-text-center id" },
                        { targets:2, title: 'Name'  },
                        { targets:3, title: 'Phone' },
                        { targets:4, title: 'Email' },
                        { targets:5, title:"", width:"1em", orderable:false, "class":"uk-text-center uk-text-middle uk-text-nowrap actions",
            			render:function(d,t,r){ return ''
            			    +'<a class="uk-icon-times uk-icon-justify" href="#modal-remove-employee-from-company" data-uk-modal=\'{"modal":false}\' data-get="id='+r[1]+'" data-populate=\'{"id":"'+r[1]+'"}\' title="Remove"></a>';
            			}}
                    ]
                });</script>
                <form action="ajax.php?f=customers/customers_companies/postAddEmployee" data-trigger="employees-changed, company-updated">
                    <div class="uk-text-right uk-margin-top">
                        <input type="hidden" name="id">
                        <select class="select2"  name="id_customer" style="width:300px"
                            data-ajax--url="ajax.php?f=customers/searchCustomers" 
                            data-templateResult='{{id}}. <i class="uk-icon-user"></i> {{text}} <br><small><i class="uk-icon-phone"></i> {{phone}} | <i class="uk-icon-envelope"></i> {{email}}</small>' 
                            data-placeholder="+ Search ..."
                            type="submit" 
                        ><option></option></select>
                        
                        <button type="button" class="uk-modal-close uk-button">Exit</button>
                    </div>
                </form>
            
            </div>
        </div>
        
        <?php /*** Modal remove emploee from company */ ?>
        <div id="modal-remove-employee-from-company" class="uk-modal" data-hide-on-submit="true">
            <div class="uk-modal-dialog uk-modal-dialog-small"> <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>Remove supplier from company</h3> </div>
                <form action="ajax.php?f=customers/customers_companies/postRemoveEmployee" method="post" data-trigger="employees-changed,company-updated">
                    <p>Remove supplier #<span name="id"></span> from company ?</p>
                    <input type="hidden" name="id">
                    <input type="hidden" name="id_parent">
                    <div class="uk-text-right">
                        <button type="submit" class="uk-button uk-button-danger">Delete</button>
                        <button type="button" class="uk-modal-close uk-button">Cancel</button>
                    </div>
                </form>
            </div> 
        </div>
        
        
        
        <?php /*** Modal Delete */ ?>
        <div id="modal-delete-company" class="uk-modal" data-hide-on-submit>
            <div class="uk-modal-dialog uk-modal-dialog-small"> <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header">  <h3>Delete supplier's company</h3>  </div>
                <form action="ajax.php?f=customers/postDeleteCompany" method="post" data-trigger="company-deleted">
                    <p>Are you sure you want to delete this company #<span name="id"></span> ?</p>
                    <input type="hidden" name="id">
                    <div class="uk-text-right">
                        <button type="submit" class="uk-button uk-button-danger">Delete</button>
                        <button type="button" class="uk-modal-close uk-button">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        
        
        
        <script src="<?=$_ASSETS['application.js']?>"></script>
        </div>
        <?php include 'snipps/foot.php'; ?>
    </body>
    
</html>
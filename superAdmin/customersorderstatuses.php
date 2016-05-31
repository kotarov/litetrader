<?php include 'snipps/init.php'; ?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Order statuses</title>
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
        
        <link  href="<?=$_ASSETS['select2.css']?>" rel="stylesheet" />
        <script src="<?=$_ASSETS['select2.js']?>"></script>
        
        <script src="<?=$_ASSETS['lang.js']?>"></script>
        
        <link  href="<?=$_ASSETS['application.css']?>" rel="stylesheet">
        <link  href="<?=$_ASSETS['theme.css']?>" rel="stylesheet">
    </head>
    
    <body id="page-customers"> 
        <?php include 'snipps/head.php'; ?>
        
        <h2 class="page-header">Orders statuses</h2>
        <div class="uk-container">
        
        <table id="statuses" class="uk-table uk-table-hover uk-table-striped uk-table-condensed" cellspacing="0" 
            data-trigger-add="status-added"
            data-trigger-update="status-updated"
            data-trigger-delete="status-deleted" 
            data-trigger-reload="status-reload" 
        ></table>
        <script> 
            $("#statuses").DataTable({
            	dom: '<"uk-float-right uk-margin-left"B><"uk-float-right"f>lrtip',
            	ajax: "ajax.php?f=customers/orders/getStatuses",
            	stateSave: true,
            	order:[[2,'asc']],
            	columns: [
            		{ data:'is_default', title:"",width:"1em",orderable:false,searchable:false,"class":"uk-text-center uk-text-middle actions", render: function(d,t,r){
            		    return '<a href="ajax.php?f=customers/orders/postToggleDefaultStatus" data-post=\'{"id":"'+r.id+'"}\' data-toggle data-trigger="status-reload" '+(d==1?'class="uk-icon-play" title="Default">':'class="uk-text-muted" title="Make default">-')+'</a>';
            		}},
            		{ data:'is_closed', title:"", width:"1em",orderable:false, searchable:false, "class":"uk-text-center uk-text-middle actions", 
            		    render:function(d,t,r){ return '<a href="ajax.php?f=customers/orders/postToggleStatus" data-post=\'{"id":"'+r.id+'"}\' data-toggle="is_closed" data-trigger="status-updated" '+(d?'class="uk-icon-lock"':'class="uk-icon-unlock uk-text-muted"')+'></a>';
            		}  },
            		{ data:'id', title:"Id", width:"1em","class":"uk-text-center uk-text-middle id" },
            		{ data:'icon', title:"Icon", width:"1em", orderable:false, searchable:false,class:"uk-text-center uk-text-middle",
            		    render: function(d,t,r){ return '<i class="'+d+'" style="color:'+r.color+'"></i>'; }
            		},
            		{ data:'name', title:"Name"  },
            		{ data:'actions', title:"", width:"1em", orderable:false, searchable:false, "class":"uk-text-center uk-text-middle uk-text-nowrap actions",
            		    render: function(d,t,r){return ''
            			+'<a href="#modal-edit-status" data-uk-modal class="uk-icon-edit uk-icon-justify" data-get="id='+d+'" data-populate=\'{"id":"'+d+'"}\' title="Edit"></a>'
            			+'<a href="#modal-delete-status" data-uk-modal class="uk-icon-trash uk-icon-justify" data-post=\'{"id":"'+d+'"}\' data-populate=\'{"id":"'+d+'"}\' title="Delete"></a>';
            		}   }
            	],
            	buttons: [{	text:"New", className:"uk-button uk-button-primary",
            		init: function(dt, node, config){ node.attr("data-uk-modal",true).attr("href","#modal-new-status"); }
            	}],
                fnDrawCallback:function(settings){ $("tbody",this[0]).unhighlight().highlight( this.api().search().split(" ") ); }
            });    		
        </script>
        
        
        <?php /*** Modal NEW */ ?>
         <div id="modal-new-status" class="uk-modal" data-hide-on-submit>
            <div class="uk-modal-dialog"> <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>New status</h3> </div>
                <form class="uk-form uk-form-horizontal" action="ajax.php?f=customers/orders/postNewStatus" data-trigger="status-added">

                    <div class="uk-form-row">
                        <label class="uk-form-label">fa-Icon <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls">
                            <select class="uk-width-1-1 select2" data-get="ajax.php?f=getIcons" style="width:100%" name="icon"
                                data-templateResult='<i class="{{id}}"></i> {{text}}</span>'
                                data-templateSelection='<i class="{{id}}"></i> {{text}}</span>'
                            ></select>
                        </div>
                    </div>
                    
                    <div class="uk-form-row">
                        <label class="uk-form-label">Name <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="name"></div>
                    </div>
                     <div class="uk-form-row">
                        <label class="uk-form-label"> Color </label>
                        <div class="uk-form-controls">
                            <input type="color" name="color" placeholder="#000000">
                        </div>
                    </div> 
                    <div class="uk-form-row">
                        <div class="uk-form-controls">
                            <label class="uk-form-label">
                            <input type="checkbox" type="text" name="is_closed">
                            This is close status </label>
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
        <div id="modal-delete-status" class="uk-modal" data-hide-on-submit>
            <div class="uk-modal-dialog uk-modal-dialog-small">  <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header">  <h3>Delete status</h3>  </div>
                <form action="ajax.php?f=customers/orders/postDeleteStatus" method="post" data-trigger="status-deleted">
                    <p>Are you sure you want to delete status #<b name="id"></b> ?</p>
                    <input type="hidden" name="id">
                    <div class="uk-text-right">
                        <button type="submit" class="uk-button uk-button-danger">Delete</button>
                        <button class="uk-modal-close uk-button">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        
        <?php /*** Modal EDIT */ ?>
         <div id="modal-edit-status" class="uk-modal" data-get="ajax.php?f=customers/orders/getStatus" data-hide-on-submit>
            <div class="uk-modal-dialog"> <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>Edit status</h3> </div>
                <form class="uk-form uk-form-horizontal" action="ajax.php?f=customers/orders/postEditStatus" data-trigger="status-updated">
                    <input type="hidden" name="id">
                    <div class="uk-form-row">
                        <label class="uk-form-label">fa-Icon <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls">
                            <select class="uk-width-1-1 select2" data-get="ajax.php?f=getIcons" style="width:100%" name="icon"
                                data-templateResult='<i class="{{id}}"></i> {{text}}</span>'
                                data-templateSelection='<i class="{{id}}"></i> {{text}}</span>'
                            ></select>
                        </div>
                    </div>
                    
                    <div class="uk-form-row">
                        <label class="uk-form-label">Name <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="name"></div>
                    </div>
                     <div class="uk-form-row">
                        <label class="uk-form-label"> Color </label>
                        <div class="uk-form-controls">
                            <input type="color" name="color" placeholder="#000000">
                        </div>
                    </div> 
                    <div class="uk-form-row">
                        <div class="uk-form-controls">
                            <label class="uk-form-label"><input type="checkbox" type="text" name="is_closed"> This is close status </label>
                        </div>
                    </div> 
                    <div class="uk-modal-footer">
                        <button class="uk-button uk-button-primary">Save</button>
                        <button class="uk-button uk-modal-close">Cancel</button>
                    </div>
                
                </form>
            </div>
        </div>
        
        </div>
        <?php include 'snipps/foot.php'; ?>
        <script src="<?=$_ASSETS['application.js']?>"></script>

    </body>
</html>
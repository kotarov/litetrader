<?php include 'snipps/init.php'; ?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Measure units</title>
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
        
        <link  href="<?=$_ASSETS['application.css']?>" rel="stylesheet">
        <link  href="<?=$_ASSETS['theme.css']?>" rel="stylesheet">
        
        <script src="<?=$_ASSETS['lang.js']?>"></script>
    </head>
    
    <body id="page-products"> 
        <?php include 'snipps/head.php'; ?>
        
        <h2 class="page-header">Measure units</h2>
        <div class="uk-container">
        
        <table id="measure-units" class="uk-table uk-table-hover uk-table-striped uk-table-condensed" cellspacing="0" width="100%"
            data-trigger-reload="units-changed"
        ></table>
        <script> 
            $("#measure-units").DataTable({
            	dom: '<"uk-float-right uk-margin-left"B>ti',
            	ajax: "ajax.php?f=products/units/getMeasureUnits",
            	stateSave: true,
            	searching: false,
            	ordering: false,
            	columns: [
            	    { data:"is_default", title:"Default", class:"uk-text-center", width:"1em", orderable:false,searchable:false,
            	        render: function(d,t,r){ return (d?'<i class="uk-icon-circle uk-text-success"></i>':
            	        '<a href="ajax.php?f=products/units/postToggleDefault" data-toggle="is_default" data-post=\'{"id":"'+r['id']+'"}\' data-trigger="units-changed" class="uk-icon-circle-thin uk-text-muted"></a>');        
            	    }},
            		{ data:"id", title:"ID", class:"uk-text-center id", width:"1em"},
            		{ data:"abbreviation", title:"Abbreviation", width:"4em", class:"uk-text-center"},
            		{ data:"name", title:"Description", class:"uk-nowrap" },
            		{ data:"position", title:"Position", width:"1em","class":"uk-text-center"},
            		{ data:"actions", title:"", width:"1em", orderable:false, searchable:false, "class":"uk-text-center uk-text-middle uk-text-nowrap actions",
            			render: function(d,t,r){return ''
            			+'<a href="#modal-edit-unit" class="uk-icon-edit uk-icon-justify" data-uk-modal data-get="id='+r['id']+'" data-populate=\'{"id":"'+r['id']+'","abbreviation":"'+r['abbreviation']+'","name":"'+r['name']+'","position":"'+r['position']+'"}\' title="Edit"></a>'
            			+'<a href="#modal-delete-unit" class="uk-icon-trash uk-icon-justify" data-uk-modal data-populate=\'{"id":"'+r['id']+'","abbreviation":"'+r['abbreviation']+'","name":"'+r['name']+'"}\' data-get="id='+r['id']+'" title="Delete"></a>'
            			},
            		}
            	],
            	buttons: [{	text:"New", className:"uk-button uk-button-primary",
                	init: function(dt, node, conf){ node.attr("data-uk-modal",true).attr("href","#modal-new-unit"); } 
            	}]
            });
        </script>
        
        <?php /*** Modal NEW */ ?>
         <div id="modal-new-unit" class="uk-modal" data-hide-on-submit>
            <div class="uk-modal-dialog">
                <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>New measure unit</h3> </div>
                <form class="uk-form uk-form-horizontal" action="ajax.php?f=products/units/postNewUnit" data-trigger="units-changed">
                    
                    <div class="uk-form-row">
                        <label class="uk-form-label">Abbreviation <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="abbreviation"></div>
                    </div>
                    
                    <div class="uk-form-row">
                        <label class="uk-form-label">Name <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="name"></div>
                    </div>
                    
                    <div class="uk-form-row">
                        <label class="uk-form-label">Position</label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="position"></div>
                    </div>
                    
                    <div class="uk-modal-footer">
                        <button class="uk-button uk-button-primary">Save</button>
                        <button class="uk-button uk-modal-close">Cancel</button>
                    </div>
                
                </form>
            </div>
        </div>
        
         <?php /*** Modal edit */ ?>
         <div id="modal-edit-unit" class="uk-modal" data-hide-on-submit>
            <div class="uk-modal-dialog">
                <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"> <h3>Edit measure unit: <span class="uk-text-muted"><span name="abbreviation"></span> (#<span name="id"></span>)</span></h3> </div>
                <form class="uk-form uk-form-horizontal" action="ajax.php?f=products/units/postEditUnit" data-trigger="units-changed">
                    <input type="hidden" name="id">
                    <div class="uk-form-row">
                        <label class="uk-form-label">Abbreviation <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="abbreviation"></div>
                    </div>
                    
                    <div class="uk-form-row">
                        <label class="uk-form-label">Name <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="name"></div>
                    </div>
                    
                    <div class="uk-form-row">
                        <label class="uk-form-label">Position</label>
                        <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="position"></div>
                    </div>
                    
                    <div class="uk-modal-footer">
                        <button class="uk-button uk-button-primary">Save</button>
                        <button class="uk-button uk-modal-close">Cancel</button>
                    </div>
                
                </form>
            </div>
        </div>
        
        
        <?php /*** Modal Delete */ ?>
        <div id="modal-delete-unit" class="uk-modal" data-hide-on-submit>
            <div class="uk-modal-dialog uk-modal-dialog-small">  <a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header">  <h3>Delete unit: <span class="uk-text-muted"><span name="abbreviation"></span> (#<span name="id"></span>)</span></h3>  </div>
                <form action="ajax.php?f=products/units/postDeleteUnit" method="post" data-trigger="units-changed">
                    <p>Are you sure you want to delete this measure unit: <br>"<b name="name"></b>" ?</p>
                    <input type="hidden" name="id">
                    <div class="uk-text-right">
                        <button type="submit" class="uk-button uk-button-danger">Delete</button>
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
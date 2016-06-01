<?php include 'snipps/init.php'; ?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Categories</title>
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
        
        <link  href="<?=$_ASSETS['select2.css']?>" rel="stylesheet" />
        <script src="<?=$_ASSETS['select2.js']?>"></script>
        
        <script src="<?=$_ASSETS['lang.js']?>"></script>
        
        <link  href="<?=$_ASSETS['application.css']?>" rel="stylesheet">
        <link  href="<?=$_ASSETS['theme.css']?>" rel="stylesheet">
        <style>
            .uk-table-condensed td { padding-top:0px;padding-bottom:0px}
        </style>
    </head>
    
    <body id="page-products"> 
        <?php include 'snipps/head.php'; ?>
        
        <h2 class="page-header">Product categories</h2>
        <div class="uk-container">
        
        <table id="categories" class="uk-table uk-table-hover uk-table-striped uk-table-condensed" cellspacing="0" width="100%"
            data-trigger-reload="category-changed"
        ></table>

        
        <script> 
            $("#categories").DataTable({
            	dom: '<"uk-float-right uk-margin-left"B>ti',
            	ajax: "ajax.php?f=products/getCategories",
            	paginate: false,
            	stateSave: true,
            	searching: false,
            	ordering: false,
            	columnDefs: [
            		{ targets:0, title:"Vis", width:"1em", class:"uk-text-center", render:function(d,t,r){
            		    return '<a href="ajax.php?f=products/postToggleCategory" class="uk-icon-eye'+(d?'':'-slash uk-text-muted')+'" data-toggle="is_visible" data-trigger="category-changed" data-post=\'{"id":"'+r[1]+'"}\'></a>';
            		}},
            		{ targets:1, title:"ID", width:"1em", class:"id"},
            		{ targets:2, title:"Name", class:"uk-nowrap" },
            		{ targets:3, title:"Descrition"},
            		{ targets:4, title:"Position", width:"1em","class":"uk-text-center"},
            		{ targets:5, title:"", width:"1em", orderable:false, searchable:false, "class":"uk-text-center uk-text-middle uk-text-nowrap actions",
            			render: function(data,type,row){return ''
            			+'<a href="#modal-edit-category" class="uk-icon-edit uk-icon-justify" data-uk-modal data-get="id='+row[1]+'" data-populate=\'{"id":"'+row[1]+'"}\' title="Edit"></a>'
            			+'<a href="#modal-delete-category" class="uk-icon-trash uk-icon-justify" data-uk-modal data-populate=\'{"id":"'+row[1]+'","name":"'+row[2].replace(/\||&nbsp;/g,"")+'"}\' data-get="id='+row[0]+'" title="Delete"></a>'
            			},
            		}
            	],
            	buttons: [{	text:"New", className:"uk-button uk-button-primary",
                	init: function(dt, node, conf){ node.attr("data-uk-modal",true).attr("href","#modal-new-category"); } 
            	}]
            });
        </script>
            
        <div>
            <?php /*** Modal New */?>
            <div id="modal-new-category" class="uk-modal" data-hide-on-submit>
                <div class="uk-modal-dialog">
                    <a class="uk-modal-close uk-close"></a>
                    <div class="uk-modal-header"> <h3 data-lang>Create new category</h3> </div>
                    <form class="uk-form uk-form-horizontal" action="ajax.php?f=products/postNewCategory" data-trigger="category-changed">
                        <div class="uk-form-row">
                            <label class="uk-form-label"><span data-lang>Name</span> <span class="uk-text-danger">*</span></label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="name"></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" data-lang>Parent</label>
                            <div class="uk-form-controls"><select data-get="ajax.php?f=products/getCategories&getforselect" class="uk-width-1-1" name="id_parent"></select></div>
                            <script>$(document).on("category-changed", function(e,d){
                                var select = $("#modal-new-category [name=id_parent]").html("").append('<option value="0">-</option>');
                                $.each(d.data, function(r,k){
                                    select.append('<option value="'+k.id+'">'+(k.text||k.name)+'</option>');
                                })
                            })</script>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" data-lang>Position</label>
                            <div class="uk-form-controls"><input type="number" class="uk-width-1-1" name="pos"></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label"><span data-lang>Description</span> <span class="uk-text-danger">*</span></label>
                            <div class="uk-form-controls"><textarea class="uk-width-1-1" name="description"></textarea></div>
                        </div>
                        <div class="uk-form-row">
                                <label class="uk-form-label"><span data-lang>Tags</span>  <span class="uk-text-danger">*</span></label>
                                <div class="uk-form-controls">
                                    <select class="uk-width-1-1 select2" style="width:100%" 
                                                data-tags="true" 
                                                multiple 
                                                data-tokenSeparators='[",", " "]' 
                                                name="tags[]"
                                            ></select>
                                    <p class="uk-form-help-block"><span data-lang>Separate tags with</span> <code data-lang>comma</code>, <code data-lang>space</code> <span data-lang>or</span> <code>&lt;Еnter&gt;</code>.</p>
                                </div>
                            </div>
                        <div class="uk-modal-footer">
                            <button class="uk-button uk-button-primary" data-lang>Save</button>
                            <button class="uk-button uk-modal-close" data-lang>Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            
            
            <?php /*** Modal Edit */ ?>
            <div id="modal-edit-category" class="uk-modal" data-get="ajax.php?f=products/getCategory" data-hide-on-submit>
                <div class="uk-modal-dialog">
                    <a class="uk-modal-close uk-close"></a>
                    <div class="uk-modal-header"> <h3><span data-lang>Edit category</span> #<span name="id"></span></h3> </div>
                    <form class="uk-form uk-form-horizontal" action="ajax.php?f=products/postEditCategory" data-trigger="category-changed">
                        <input type="hidden" name="id">
                        <div class="uk-form-row">
                            <label class="uk-form-label"><span data-lang>Name</span> <span class="uk-text-danger">*</span></label>
                            <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="name"></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label"><span data-lang>Parent</span></label>
                            <div class="uk-form-controls"><select data-get="ajax.php?f=products/getCategories&getforselect" class="uk-width-1-1" name="id_parent"></select></div>
                            <script>$(document).on("category-changed", function(e,d){
                                var select = $("#modal-edit-category [name=id_parent]").html("").append('<option value="0">-</option>');
                                $.each(d.data, function(r,k){
                                    select.append('<option value="'+k.id+'">'+(k.text||k.name)+'</option>');
                                })
                            })</script>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label"><span data-lang>Position</span></label>
                            <div class="uk-form-controls"><input type="number" class="uk-width-1-1" name="pos"></div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label"><span data-lang>Description</span> <span class="uk-text-danger">*</span></label>
                            <div class="uk-form-controls"><textarea class="uk-width-1-1" name="description"></textarea></div>
                        </div>
                        <div class="uk-form-row">
                                <label class="uk-form-label"><span data-lang>Tags</span>  <span class="uk-text-danger">*</span></label>
                                <div class="uk-form-controls">
                                    <select class="uk-width-1-1 select2" style="width:100%" 
                                                data-tags="true" 
                                                multiple 
                                                data-tokenSeparators='[",", " "]' 
                                                name="tags[]"
                                            ></select>
                                    <p class="uk-form-help-block"><span data-lang>Separate tags with</span> <code data-lang>comma</code>, <code data-lang>space</code> <span data-lang>or</span> <code>&lt;Еnter&gt;</code>.</p>
                                </div>
                        </div>
                        <div class="uk-modal-footer">
                            <button class="uk-button uk-button-primary" data-lang>Save</button>
                            <button class="uk-button uk-modal-close" data-lang>Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                $("#modal-edit-category").on("populated",function(e,ret){
                    var obj = $("[name=id_parent]", this);
                    $("option[disabled]", obj).prop("disabled",false);
                    var children = ret.data[0]['children'];
                    if(children){ $.each(children.split(","), function(k,v){
                        $(obj).find("[value="+v+"]").prop("disabled",true);
                    });}      
                });
            </script>            
            
            
            <?php /*** Modal Delete */ ?>
            <div id="modal-delete-category" class="uk-modal" data-hide-on-submit>
                <div class="uk-modal-dialog uk-modal-dialog-small">
                    <a class="uk-modal-close uk-close"></a>
                    <div class="uk-modal-header"> <h3 data-lang>Delete category</h3> </div>
                    <form action="ajax.php?f=products/postDeleteCategory" data-trigger="category-changed">
                        <p><span data-lang>Are you sure you want to delete this category ?</span> <div class="uk-text-muted"> <span name="name"></span> - <code>#<b name="id"></b></code> </div></p>
                        <input type="hidden" name="id">
                        <div class="uk-text-right">
                            <button type="submit" class="uk-button uk-button-danger" data-lang>Delete</button>
                            <button class="uk-modal-close uk-button" data-lang>Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        
        <script src="<?=$_ASSETS['application.js']?>"></script>
        
        </div>
        <?php include 'snipps/foot.php'; ?>
    </body>
</html>
<?php include 'snipps/init.php'; ?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Products</title>
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
        
        
        
        <link  href="<?=$_ASSETS['codemirror.css']?>" rel="stylesheet">
        <script src="<?=$_ASSETS['codemirror.js']?>"></script>
        <script src="<?=$_ASSETS['codemirror.marked.js']?>"></script>

        <?php /*<script src="<?=$_ASSETS['codemirror.markdown.js']?>"></script> */?>
        <?php /*<script src="<?=$_ASSETS['codemirror.overlay.js']?>"></script> */?>
        <script src="<?=$_ASSETS['codemirror.xml.js']?>"></script>
        
        <link  href="<?=$_ASSETS['uikit.htmleditor.css']?>" rel="stylesheet">
        <script src="<?=$_ASSETS['uikit.htmleditor.js']?>"></script>
        

        
        <script src="<?=$_ASSETS['highlight.js']?>"></script>
        
        <link  href="<?=$_ASSETS['select2.css']?>" rel="stylesheet" />
        <script src="<?=$_ASSETS['select2.js']?>"></script>
        
        <script src="<?=$_ASSETS['chart.sparkline.js']?>"></script>
        
        <link  href="<?=$_ASSETS['application.css']?>" rel="stylesheet">
        <link  href="<?=$_ASSETS['theme.css']?>" rel="stylesheet">
    </head>
    
    <body id="page-products"> 
        <?php include 'snipps/head.php'; ?>
        
        <h2 class="page-header">Products <span class="uk-margin-left page-sparkline" data-table="products"></span></h2>
        <div class="uk-container">
        
        <table id="products" class="uk-table uk-table-hover uk-table-striped uk-table-condensed" cellspacing="0" width="100%"
            data-trigger-add="product-added"
            data-trigger-update="product-updated"
            data-trigger-delete="product-deleted"
        ></table>

        
        <script> 
            $("#products").DataTable({
            	dom: '<"uk-float-right uk-margin-left"B><"uk-float-right"f>lrtip',
            	ajax: "ajax.php?f=products/getProducts",
            	stateSave: true,
            	order: [[ 4, "desc" ]],
            	columnDefs: [
            		{ targets:0, title:"Vis", searchable:false, width:"2em",
            			render: function(data,type,row){
            				var icon = (data == 1) ? "uk-icon-eye uk-text-success" : "uk-icon-eye-slash uk-text-muted";
            				return '<a href="ajax.php?f=products/postToggleProduct" data-trigger="product-updated" data-post=\'{"id":"'+row[3]+'"}\' data-toggle="is_visible" class="'+icon+'"><i hidden>'+data+'</i></a>';
            			}
            		},
            		{ targets:1, title:"Av", width:"2em",
            		    render: function(data,type,row){
            				var icon = (data == 1) ? "uk-icon-cart-arrow-down" : "uk-icon-ban uk-text-muted";
            				return '<a href="ajax.php?f=products/postToggleProduct" data-trigger="product-updated" data-post=\'{"id":"'+row[3]+'"}\' data-toggle="is_avaible" class="'+icon+'"><i hidden>'+data+'</i></a>';
            			}
            		},
            		{ targets:2, title:"Ad", width:"1em", class:"uk-text-center", render: function(d,t,r){
            		    var icon = (d==1) ? "uk-icon-flag uk-text-danger" : "uk-icon-flag-o uk-text-muted";
            		    return '<a href="ajax.php?f=products/postToggleProduct" data-trigger="product-updated" data-post=\'{"id":"'+r[3]+'"}\' data-toggle="is_adv" class="'+icon+'"><i hidden>'+d+'</i></a>';
            		}},
            		{ targets:3, title:"ID", width:"1em", class:"id uk-text-center"},
            		{ targets:4, title:"", orderable:false,searchable:false,
            			render: function ( d, t, r ) {
            			    var badge = r[13] > 0 ? '<sup class="uk-badge">'+r[13]+'</sup>' : '';
            				return '<a href="#modal-image-product" data-uk-modal data-get="id='+r[3]+'" data-populate=\'{"id":"'+r[3]+'"}\'>'
            						+'<img src="image.php/'+d+'/small/'+r[11]+'" width="40" >'+badge+'</a>';
            			}
            		},
            		{ targets:5, title:"Name", render:function(d,t,r){return d+(r[12]?' <small class="uk-text-muted">/ '+r[12]+'</small>':'');}},
            		{ targets:6, title:"Category"},
            		{ targets:7, title:"Supplier"},
            		{ targets:8, title:"Price",width:"3em", "class":"dt-right"},
            		{ targets:9, title:"Qty", width:"3em","class":"uk-text-right uk-text-nowrap",render:function(d,t,r){return d+' '+r[14];}},
            		{ targets:10, title:"", width:"1em", orderable:false, searchable:false, "class":"uk-text-center uk-text-middle uk-text-nowrap actions",
            			render: function(data,type,row){return ''
            			+'<a href="#modal-editproduct" data-uk-modal class="uk-icon-edit" data-get="id='+row[3]+'" data-populate=\'{"id":"'+row[3]+'"}\' title="Edit"></a>'
            			+'<a href="#modal-editproduct-details" data-uk-modal class="uk-icon-list-ul" data-get="id='+row[3]+'"data-populate=\'{"id":"'+row[3]+'","product":"'+row[5]+'"}\'  title="Details"></a>'
            			+'<a href="#modal-delete-product" data-uk-modal class="uk-icon-trash" data-get="id='+row[3]+'" data-populate=\'{"id":"'+row[3]+'"}\' title="Delete"></a>';
            			},
            		}
            	],
            	<?php /*fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            		if(aData[0] == 0) $(nRow).addClass("disabled");
            		else $(nRow).removeClass("disabled");
            		$(nRow).attr("data-id",aData[1]).attr("data-index",iDisplayIndex);
            	},*/?>
            
            	buttons: [{	text:"New", className:"uk-button uk-button-primary",
            		init: function(dt, node, config){ node.attr("data-uk-modal",true).attr("href","#modal-new-product"); }
            	}],
                fnDrawCallback:function(settings){ $("tbody",this[0]).unhighlight().highlight( this.api().search().split(" ") ); }
            });
        </script>
            
        <div>
            <?php /*** Modal New */?>
            <div id="modal-new-product" class="uk-modal" data-hide-on-submit>
                <div class="uk-modal-dialog"> <a class="uk-modal-close uk-close"></a>
                    <div class="uk-modal-header"> <h3>Create new product</h3></div>
                    
                    <form class="uk-form uk-form-horizontal" action="ajax.php?f=products/postNewProduct" data-trigger="product-added">
                            <div class="uk-form-row">
                                <label class="uk-form-label">Name <span class="uk-text-danger">*</span></label>
                                <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="name"></div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label">Ref.</label>
                                <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="reference"></div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label">Price <span class="uk-text-danger">*</span></label>
                                <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="price"></div>
                            </div>
                             <div class="uk-form-row">
                                <label class="uk-form-label">Quantity </label>
                                <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="qty"></div>
                            </div>
                             <div class="uk-form-row">
                                <label class="uk-form-label">Measure Unit </label>
                                <div class="uk-form-controls"><select class="uk-width-1-1" data-get="ajax.php?f=products/units/getMeasureUnits" type="text" name="id_unit"></select></div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label">Category <span class="uk-text-danger">*</span></label>
                                <div class="uk-form-controls"><select class="uk-width-1-1" data-get="ajax.php?f=products/getCategories&getforselect" name="id_category"></select></div>
                                <script>$(document).on("categories-changed", function(e,d){
                                    var select = $("#modal-newproduct [name=id_category]").html("").append('<option value="0">-</option>');
                                    $.each(d.data, function(r,k){select.append('<option value="'+k[0]+'">'+k[1]+'</option>');});
                                });</script>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label">Supplier</label>
                                <div class="uk-form-controls"><select class="uk-width-1-1 select2" style="width:100%"
                                    name="id_supplier"
                                    data-get="ajax.php?f=suppliers/getCompaniesForSelect" 
                                    data-templateSelection='{{text}}'
                                    data-templateResult='{{text}}'
                                ></select></div>
                            </div>
                        
                            <div class="uk-form-row">
                                <label class="uk-form-label">Description  <span class="uk-text-danger">*</span></label>
                                <div class="uk-form-controls"><textarea class="uk-width-1-1" name="description"></textarea></div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label">Tags  <span class="uk-text-danger">*</span></label>
                                <div class="uk-form-controls">
                                    <select class="uk-width-1-1 select2" style="width:100%" 
                                                data-tags="true" 
                                                multiple 
                                                data-tokenSeparators='[",", " "]' 
                                                name="tags[]"
                                            ></select>
                                    <p class="uk-form-help-block">Separate tags with <code>comma</code>, <code>space</code> or <code>&lt;Еnter&gt;</code>.</p>
                                </div>
                            </div>
                        
                        <div class="uk-modal-footer">
                            <button class="uk-button uk-button-primary">Save</button>
                            <button class="uk-button uk-modal-close">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <?php /*** Modal Edit */ ?>
            <div id="modal-editproduct" class="uk-modal" data-get="ajax.php?f=products/getProduct" data-hide-on-submit>
                <div class="uk-modal-dialog"> <a class="uk-modal-close uk-close"></a>
                    <div class="uk-modal-header"> <h3>Edit product #<span class="uk-text-muted" name="id"></span></h3> </div>
                    <form class="uk-form uk-form-horizontal" action="ajax.php?f=products/postEditProduct" data-trigger="product-updated">
                        <input type="hidden" name="id">
                            
                            <div class="uk-form-row">
                                <label class="uk-form-label">Name <span class="uk-text-danger">*</span></label>
                                <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="name"></div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label">Ref.</label>
                                <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="reference"></div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label">Price <span class="uk-text-danger">*</span></label>
                                <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="price"></div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label">Quantity </label>
                                <div class="uk-form-controls"><input class="uk-width-1-1" type="text" name="qty"></div>
                            </div>
                             <div class="uk-form-row">
                                <label class="uk-form-label">Measure Unit </label>
                                <div class="uk-form-controls"><select class="uk-width-1-1" data-get="ajax.php?f=products/units/getMeasureUnits" type="text" name="id_unit"></select></div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label">Category <span class="uk-text-danger">*</span></label>
                                <div class="uk-form-controls"><select class="uk-width-1-1" data-get="ajax.php?f=products/getCategories&getforselect" name="id_category"></select></div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label">Supplier</label>
                                <div class="uk-form-controls"><select class="uk-width-1-1 select2" style="width:100%"
                                    name="id_supplier"
                                    data-get="ajax.php?f=suppliers/getCompaniesForSelect" 
                                    data-templateSelection='{{text}}'
                                    data-templateResult='{{text}}'
                                ></select></div>
                            </div>

                            <div class="uk-form-row">
                                <label class="uk-form-label">Description <span class="uk-text-danger">*</span></label>
                                <div class="uk-form-controls"><textarea class="uk-width-1-1" name="description"></textarea></div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label">Tags <span class="uk-text-danger">*</span></label>
                                <div class="uk-form-controls">
                                    <select class="uk-width-1-1 select2" style="width:100%" 
                                        data-tags="true" 
                                        multiple 
                                        data-tokenSeparators='[",", " "]' 
                                        name="tags[]"
                                    ></select>
                                    <p class="uk-form-help-block">Separate tags with <code>comma</code>, <code>space</code> or <code>&lt;Еnter&gt;</code>.</p>
                                </div>
                            </div>
                        
                        <div class="uk-modal-footer">
                            <button class="uk-button uk-button-primary">Save</button>
                            <button class="uk-button uk-modal-close">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            
            
            <?php /*** Modal Details */ ?>
            <div id="modal-editproduct-details" class="uk-modal" data-get="ajax.php?f=products/getProductDetails" data-hide-on-submit>
                <style scoped>a[data-htmleditor-button="fullscreen"] {display:none!important}</style>
                <div class="uk-modal-dialog uk-modal-dialog-large uk-modal-dialog-lightbox">
                    <a href="" class="uk-modal-close uk-close uk-close-alt"></a>
                    <form class="uk-form" action="ajax.php?f=products/postProductDetails" data-trigger="product-updated">
                        <textarea class="uk-width-1-1" name="description" data-uk-htmleditor="{maxsplitsize:600}" data-mode="text/html"></textarea>
                        <input type="hidden" name="id">
                        <div class="uk-text-right">
                            <button class="uk-button uk-button-primary">Save</button>
                            <button class="uk-modal-close uk-button">Cancel</button>
                        </div>
                    </form>
                    <div class="uk-modal-caption"><i><b class="uk-text-muted">Code Editor</b> of Details for product:</i> "<b class="uk-text-warning" name="product"></b>"</div>
                </div>
            </div>
            
            <?php /*** Modal Delete */ ?>
            <div id="modal-delete-product" class="uk-modal" data-hide-on-submit>
                <div class="uk-modal-dialog uk-modal-dialog-small">
                    <a class="uk-modal-close uk-close"></a>
                    <div class="uk-modal-header">
                        <h3>Delete product</h3>
                    </div>
                    <form action="ajax.php?f=products/postDeleteProduct" method="post" data-trigger="product-deleted">
                        <p>Are you sure you want to delete product #<b name="id"></b> ?</p>
                        <input type="hidden" name="id">
                        <div class="uk-text-right">
                            <button type="submit" class="uk-button uk-button-danger">Delete</button>
                            <button class="uk-modal-close uk-button">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>


            <?php /*** Modal Image */?>
            <div id="modal-image-product" class="uk-modal">
                <div class="uk-modal-dialog"> <a class="uk-modal-close uk-close"></a>
                    <div class="uk-modal-header"> <h3>Images of product #<span name="id" class="uk-text-muted"></span></h3> </div>
                    
                    <table id="list-product-images" cellspacing="0" width="100%" 
                        data-trigger-reload="product-image-changed" 
                        data-get="ajax.php?f=products/images/getProductImages" 
                        class="dataTable uk-table uk-table-hover uk-table-striped uk-table-condensed" 
                    >
                    </table>
                    <script>$("#list-product-images").DataTable({
                        dom: 't',
                        paginate: false,
                        order: [[ "2", "asc" ]],
                        columns: [
                            { data: "is_cover", title:"Cover", width:"1em", "class":"uk-text-center",orderable:false,render:function(d,t,r){
                                return '<a href="ajax.php?f=products/images/postImageUpdateCover" data-toggle data-post=\'{"id":"'+r['id']+'"}\' data-trigger="product-image-changed,product-updated" class="'+(d?"uk-icon-star":"uk-icon-star-o")+'"></a>';
                            }},
                            { data:"id", title:"", orderable:false, sortable:false, render:function(d,t,r){
                                return '<a href="#dialog-preview-image" data-id="'+r['id']+'" data-uk-modal="{modal:false}" data-get="id='+r['id']+'" data-populate=\'{"id":"'+r['id']+'"}\'><img width="40" src="image.php/'+r['id']+'/small/'+r['date_add']+'"></a>';
                            }   },
                            { data:"name", title:"Name" },
                            { data: "size", title:"Size","class":"uk-text-right" },
                            { data: "actions", title:"", searchable:false, orderable:false, class:"uk-text-center uk-text-middle uk-text-nowrap actions",
                                render:function(d,t,r,m){
                                    return '<a href="#modal-delete-image" onclick=\'$("#delete-image-preview").attr("src","image.php/'+r['id']+'/small/'+r['date_add']+'")\' class="uk-icon-times" data-uk-modal="{modal:false}" data-populate=\'{"id":"'+r['id']+'"}\' title="Remove"></a>';
                            }   }
                        ]
                    });</script>
                                    
                    <form id="form-product-upload-image" action="ajax.php?f=products/images/postProductImages" data-trigger="product-image-changed,product-updated">
                        <input type="hidden" name="id">
                        <input type="file" id="select-product-image-files" name="images[]" multiple class="uk-hidden" onchange="$(this).closest('form').submit()">
                        <div class="uk-text-right">
                            <button type="button" class="uk-button uk-button-success" onclick="$('#select-product-image-files').click()"><i class="uk-icon-cloud-upload"></i> <span class="upload-progress">Upload</span></button>
                            <button type="button" class="uk-modal-close uk-button">Exit</button>
                        </div>
                    </form>
                </div>
            </div>
            <?php /*** Modal Delete IMAGE */ ?>
            <div id="modal-delete-image" class="uk-modal" data-hide-on-submit>
                <div class="uk-modal-dialog uk-modal-dialog-small"> <a class="uk-modal-close uk-close"></a>
                    <div class="uk-modal-header"> <h3>Delete image</h3> </div>
                    <form action="ajax.php?f=products/images/postImageDelete" data-trigger="product-image-changed,product-updated">
                        <p>Are you sure you want to delete this image from product #<b name="id_parent"></b> ?</p>
                        <div><img id="delete-image-preview"></div>
                        <input type="hidden" name="id">
                        <div class="uk-text-right">
                            <button type="submit" class="uk-button uk-button-danger">Delete</button>
                            <button class="uk-modal-close uk-button">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <?php /*** Modal Preview Image */ ?>
            <div id="dialog-preview-image" class="uk-modal">
                <div class="uk-modal-dialog uk-modal-dialog-blank"> <button class="uk-modal-close uk-close" type="button"></button>
                    <div class="uk-grid uk-flex-middle" data-uk-grid-margin="">
                        <div class="uk-width-medium-1-2 uk-height-viewport uk-cover-background uk-row-first" style="background-image: url('image.php/0/full');"></div>
                        <div class="uk-width-medium-1-2">
                        <h1>Image details</h1>
                            <div class="uk-width-medium-1-1">
                                <p><dl class="uk-description-list-horizontal image-details"></dl></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $("#modal-image-product").on("click","[href='#dialog-preview-image']",function(e){ e.preventDefault();
                    var id = $(this).data("id");
                    var dlg = "#dialog-preview-image";
                    $.getJSON("ajax.php?f=products/images/getProductImageInfo&id="+id).done(function(ret){
                        console.log(ret);
                        $(dlg).find(".uk-cover-background").css("background-image","url('image.php/"+id+"/full/"+ret.data[0]['date_add']+"')")
                        $(dlg).find(".image-details").html("").append(''
                            +'<dt>Image</dt><dd>'+ret.data[0]['nme']+' (ID:'+ret.data[0]['id']+')</dd>'
                            +'<dt>Type</dt><dd>'+ret.data[0]['type']+'</dd>'
                            +'<dt>Size</dt><dd>'+ret.data[0]['size']+'</dd>'
                            +'<dt>Cover</dt><dd>'+(ret.data[0]['is_cover']?'Yes':'No')+'</dd>'
                            +'<dt>Product</dt><dd>'+ret.data[0]['product']+' (ID: '+ret.data[0]['id_product']+')</dd>'
                            +'<dt>&nbsp;</dt><dd>&nbsp;</dd>'
                            
                            +'<dt class="uk-text-muted">Small</dt><dd><b class="uk-text-muted">Thumb</b></dd>'
                            +'<dt><img src="image.php/'+ret.data[0]['id']+'/small/'+ret.data[0]['date_add']+'"> </dt>'
                            +'<dd><img src="image.php/'+ret.data[0]['id']+'/thumb/'+ret.data[0]['date_add']+'"> </dd>'
                        );
                    });
                });
            </script>
       
            
        
        </div>
        
        <script src="<?=$_ASSETS['application.js']?>"></script>
        
        </div>
        <?php include 'snipps/foot.php'; ?>
    </body>
</html>
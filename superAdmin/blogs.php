<?php include 'snipps/init.php'; ?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Blog</title>
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
        
        <link  href="<?=$_ASSETS['application.css']?>" rel="stylesheet">
        <link  href="<?=$_ASSETS['theme.css']?>" rel="stylesheet">
        <link  href="<?=$_ASSETS['select2.css']?>" rel="stylesheet" />
        <script src="<?=$_ASSETS['select2.js']?>"></script>
        
        <script src="<?=$_ASSETS['chart.sparkline.js']?>"></script>
        
        <script src="<?=$_ASSETS['tinymce.js']?>"></script>
        <style>
            .select2-container--default .select2-selection--multiple{ border-color:#ddd;border-radius:0}
            .select2-container--default.select2-container--focus .select2-selection--multiple{border-color:#ddd}
            article input, article select {background:transparent!important; border:1px dotted #ddd;}
            .editable:hover:before {content:"\f040";color:#05f;position:absolute;margin-left:-25px;font-family: FontAwesome;line-height: 1;font-size:20px;}
            .uk-form article, .uk-form .uk-article { padding:20px;background:#fff;border:1px solid #ddd }
        </style> 
    </head>
    
    <body id="page-blogs"> 
        <?php include 'snipps/head.php'; ?>
        
        <h2 class="page-header">Blog items <span class="uk-margin-left page-sparkline" data-table="blogs"></span></h2>
        <div class="uk-container">
        
        <table id="blogs" class="uk-table uk-table-hover uk-table-striped uk-table-condensed" cellspacing="0" width="100%"
            data-trigger-update="blog-changed"
            data-trigger-add="blog-addnew"
            data-trigger-delete="blog-delete"
        ></table>

        
        <script> 
            $("#blogs").DataTable({
            	dom: '<"uk-float-right uk-margin-left"B><"uk-float-right"f><"uk-float-left"lr> tip',
            	ajax: "ajax.php?f=blogs/getBlogs",
            	stateSave: true,
            	columns: [
            		{ data:"is_active", title:"Vis", width:"1em", class:"uk-text-center", render:function(d,t,r){
            		    return '<a href="ajax.php?f=blogs/postToggleBlog" class="uk-icon-eye'+(d?'':'-slash uk-text-muted')+'" data-toggle="is_active" data-trigger="blog-changed" data-post=\'{"id":"'+r.id+'"}\'></a>';
            		}},
            		{ data:"id", title:"ID", width:"1em", class:"id"},
            		{ data:"date", title:"Date", "class":"uk-text-center uk-text-middle", render:function(d,t,r){
            		    var date = d?(new Date(d * 1000).toLocaleDateString()):'-';
            		    return date!='-'?date:'-';
            		}},
            		{ data:"image", title:"Img", width:"1em"},
            		{ data:"title", title:"Title", class:"uk-nowrap", render:function(d,t,r){return d.replace(/^(.{45}[^\s]*).*/, "$1...")} },
            		{ data:"category", title:"Category",render:function(d,t,r){
            		    if(d === null) d = "";
            		    return r.cat_is_visible == 1 ? d : '<strike class="uk-text-muted">'+d+'</strike>';
            		}},
            		{ data:"subtitle", title:"Subtitle",render:function(d,t,r){return d.replace(/^(.{45}[^\s]*).*/, "$1...")  }},
            		{ data:"author", title:"Author"},
            		
            		{ data:"actions", title:"", width:"1em", orderable:false, searchable:false, "class":"uk-text-center uk-text-middle uk-text-nowrap actions",
            			render: function(d,t,r){return ''
            			//+'<a href="#modal-edit-blog" class="uk-icon-edit" data-uk-modal data-get="id='+r.id+'" data-populate=\'{"id":"'+r.id+'"}\' title="Edit"></a>'
            			+'<a href="#modal-edit-blogcontent" class="uk-icon-file-text-o" data-uk-modal data-get="id='+r.id+'" data-populate=\'{"id":"'+r.id+'","date":"'+(new Date(r.date * 1000).toLocaleDateString())+'", "author":"'+r.author.replace(/\||&nbsp;/g,"")+'"}\'></a>'
            			+'<a href="#modal-delete-blog" class="uk-icon-trash" data-uk-modal data-populate=\'{"id":"'+r.id+'","title":"'+r.title.replace(/\||&nbsp;/g,"")+'"}\' title="Delete"></a>'
            			},
            		}
            	],
            	buttons: [{	text:"New", className:"uk-button uk-button-primary",
                	init: function(dt, node, conf){ node.attr("data-uk-modal",true).attr("href","#modal-edit-blogcontent").attr("data-populate",'{"id":"0"}'); } 
            	}],
            	fnDrawCallback:function(settings){ $("tbody",this[0]).unhighlight().highlight( this.api().search().split(" ") ); }
            });
        </script>
            
        <div>
            <?php /*** Modal EDIT Content */?>
            <div id="modal-edit-blogcontent" class="uk-modal" data-get="ajax.php?f=blogs/getBlog" data-hide-on-submit>
                <div class="uk-modal-dialog uk-modal-dialog-large">
                    <a class="uk-modal-close uk-close"></a>
                    <div class="uk-modal-header"> <h3>Edit article: #<b class="uk-text-muted" name="id"></b> </h3></div>
                    
                    <form class="uk-form uk-form-horizontal" action="ajax.php?f=blogs/postEditBlog" data-trigger="blog-changed,blog-addnew">
                        <input type="hidden" name="id">
                        <article class="uk-article">
                            <h1 name="title" class="uk-width-1-1 uk-article-title editable"
                                data-tinymce
                                data-inline="true"
                                data-toolbar="undo,redo"
                                data-menubar="false"
                            >Article title</h1>
                            
                            <div class="uk-article-lead uk-width-1-1 editable" name="subtitle" 
                                data-tinymce
                                data-inline="true"
                                data-toolbar="undo,redo"
                                data-menubar="false"
                            >Article Lead.</div>
                            
                            <div class="uk-article-divider"></div>
                            
                            <div class="uk-article-meta uk-panel-box1">
                                Written by <b name="author"></b> on <input type="date" name="date">. Posted in <select data-get="ajax.php?f=blogs/getCategories&forselect" name="id_category"></select>
                            </div>
                            
                            <div class="uk-article-divider"></div>                        
                            
                            <div name="content" class="uk-width-1-1 edit uk-margin-top uk-margin-bottom editable" 
                                data-tinymce    
                                data-inline="true"
                                data-plugins='["advlist autolink lists link image charmap print preview anchor","searchreplace visualblocks code fullscreen","insertdatetime media table contextmenu paste code imagetools"]'
                                data-toolbar= 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image' 
                                data-imagetools_cors_hosts='["www.tinymce.com","codepen.io"]'
                            ><i class="uk-icon-external-link"></i> A long, long article content goes here.</div>
                            
                        </article>
                        
                        <div class="uk-article-divider"></div>
                        
                            <div class="uk-form-row">
                                <label class="uk-form-label">SEO Tags  <span class="uk-text-danger">*</span></label>
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
            
            <?php /*** Modal Delete */ ?>
            <div id="modal-delete-blog" class="uk-modal" data-hide-on-submit>
                <div class="uk-modal-dialog uk-modal-dialog-small">
                    <a class="uk-modal-close uk-close"></a>
                    <div class="uk-modal-header"> <h3>Delete blog</h3> </div>
                    <form action="ajax.php?f=blogs/postDeleteBlog" data-trigger="blog-delete">
                        <p>Are you sure you want to delete this blog ? <div class="uk-text-muted"> <span name="title"></span> - <code>#<b name="id"></b></code> </div></p>
                        <input type="hidden" name="id">
                        <div class="uk-text-right">
                            <button type="submit" class="uk-button uk-button-danger">Delete</button>
                            <button class="uk-modal-close uk-button">Cancel</button>
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
<?php include 'snipps/init.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon" >
    <title>Login</title>
        
	<script src="<?=$_ASSETS['jquery.js']?>"></script>
	<script src="https://cdn.jsdelivr.net/jquery.form/3.51/jquery.form.min.js"></script>
	
	<link  href="<?=$_ASSETS['uikit.css']?>" rel="stylesheet"/>
    <script src="<?=$_ASSETS['uikit.js']?>"></script>
        
	<link  href="<?=$_ASSETS['uikit.notify.css']?>" rel="stylesheet" />
    <script src="<?=$_ASSETS['uikit.notify.js']?>"></script>
        
    
    <style>
        
        html, body {background-color: #eee}
        #page-foot {font-size:0.9em}
        
        .uk-modal-dialog {-webkit-transition: none; transition: none;}
    
        
        .uk-grid { margin-left: 0}
        #theIcon { color:#eee; padding:0.15em 0.25em; }
    
    </style>
</head>
<body>
    <div class="uk-vertical-align uk-text-center uk-height-1-1">
    <div class="uk-vertical-align-middle" style="width: 300px;">
        <br><br>
        <div class="uk-margin-top">
            <h1><i id="theIcon" class="uk-border-circle uk-icon-large uk-panel-box uk-icon-user"></i></h1>
        </div>
        <form id="FormLogin" action="ajax.php?f=postLogin" class="uk-form" method="post">
			<div class="uk-form-controls uk-form-row uk-grid">
				<input name="email" type="text" placeholder="Email" title="Email" class="uk-width-1-1 uk-form-large">
			</div>
			<div class="uk-form-controls uk-form-row uk-grid">
				<input name="password" type="password" placeholder="Passwords" title="Password" class="uk-width-1-1 uk-form-large" value="">
			</div>
			<div class="uk-form-controls uk-form-row uk-grid">
				<button class="uk-button uk-button-primary uk-width-1-1  uk-button-large">Login</button>
			</div>
		</form>
		<script>$("#FormLogin").ajaxForm({
            dataType:"json",
            beforeSend:function(jqXHR,settings){$("#FormLogin").find(".uk-form-danger").removeClass("uk-form-danger");},
            success:function(data, textStatus, jqXHR){
                if(data.required){
                    $.each(data.required, function(k,name){$("#FormLogin").find("[name='"+name+"']").addClass("uk-form-danger");});
                    window.UIkit.notify("<i class='uk-icon-asterisk'></i> Required fields","danger");
                }else if(data.success){
                    window.location.href = "index.php";
                }else if(data.access){
                    window.UIkit.notify("<b>Access</b> "+data.access,"danger");
                }
            }
        });</script>
    </div>
    </div>
    <br>
    
    <?php include 'snipps/foot.php';?>

</body>
</html>
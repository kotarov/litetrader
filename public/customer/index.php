<?php include '../snipps/init.php'; ?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Customer Login</title>
        <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon.png">
        
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
        
        <script src="<?=$_ASSETS['jquery.js']?>"></script>
        
        <link rel="stylesheet" href="<?=$_ASSETS['uikit.css']?>" />
        <script src="<?=$_ASSETS['uikit.js']?>"></script>
        
        <link href="<?=URL_BASE?>css/theme.css" rel="stylesheet">
        
        <style> .uk-tab > li.uk-active > a {background:#f5f5f5} 
            .uk-panel-box { border-color: #ddd; border-style: solid; border-width: 0 1px 1px;}
        </style>

    </head>

    <body class="uk-height-1-1">

    
        <div class="uk-vertical-align uk-text-center uk-height-1-1">
            <div class="uk-vertical-align-middle" style="width:400px">
                
                
                <ul id="login-forms-tabs"  data-uk-tab="#login-forms" class="uk-tab" >
                    <li class="uk-active">      <a href="#login" class="translate"> Have an account </a></li>
                    <li>                        <a href="#signup"> Sign Up </a></li>
                    <li>                        <a href="#reset"> Reset password </a></li>
                </ul>
                
                
                
                <ul id="login-forms" class="uk-switcher" >
                    
                    <li id="login" class="uk-active">
                    <div class="uk-width-medium-1-1 uk-panel uk-panel-box">
                        <br>
                        <i class="uk-icon-user uk-border-circle uk-margin-bottom" style="font-size:6em;padding:0.1em 0.2em;color:#f5f5f5;background:#fff"></i>
                        <br><br>
                        <form id="login-form" class="uk-form" method="post" action="login/postLogin">
                            <div class="uk-form-row">
                                <input class="uk-width-1-1 uk-form-large" type="text" placeholder="Email" name="email">
                            </div>
                            <div class="uk-form-row">
                                <input class="uk-width-1-1 uk-form-large" type="password" placeholder="Password" name="password">
                            </div>
                            <div class="uk-form-row">
                                <button type="submit" name="login" class="uk-width-1-1 uk-button uk-button-primary uk-button-large">Login</button>
                            </div>
                            <div class="uk-form-row uk-text-small">
                                <label class="uk-float-left"><input type="checkbox"> Remember Me</label>
                            </div>
                        </form>
                    </div>
                    </li>
                    

                    <li id="signup">
                    <div class="uk-width-medium-1-1 uk-panel uk-panel-box">
                        
                        <h3 class="uk-margin-bottom">You don't have an account ?</h3>
                        <p>Just fill this simple form.</p>
                        
                        <form id="signup-form" class="uk-form" method="post" action="login/postSignup">
                            
                            <div class="uk-grid uk-form-row" style="margin-left:0">
                                <input class="uk-width-1-2 uk-form-large" type="text" placeholder="Name*" name="name">
                                <input class="uk-width-1-2 uk-form-large" type="text" placeholder="Family" name="family">
                            </div>
                            
                            <div class="uk-form-row">
                                <input class="uk-width-1-1 uk-form-large" type="text" placeholder="Email*" name="email">
                            </div>
                            
                            <div class="uk-form-row uk-grid uk-width-1-1" style="margin-left:0">
                                <input class="uk-width-1-2 uk-form-large" type="password" placeholder="Password*" name="password">
                                <input class="uk-width-1-2 uk-form-large" type="password" placeholder="Repeat password" name="repeat">
                            </div>
                            <div class="uk-form-row uk-grid" style="margin-left:0">
                                <input class="uk-width-1-2 uk-form-large" type="text" placeholder="Phone*" name="phone">
                                <input class="uk-width-1-2 uk-form-large" type="text" placeholder="City*" name="city">
                            </div>
                            <div class="uk-form-row">
                                <input class="uk-width-1-1 uk-form-large" type="text" placeholder="Address*" name="address">
                            </div>
                            <br>
                            <div class="uk-fom-row uk-text-left">
                                All fields are required. You need a valid email toactivate your account
                            </div>
                            <div class="uk-form-row">
                                <button type="submit" name="signup" class="uk-width-1-1 uk-button uk-button-success uk-button-large">Create new</button>
                            </div>
                        </form>
                    </div>
                    </li>


                    <li id="reset">
                        <div class="uk-panel uk-panel-box ">
                            <h3>Forgot your password ?</h3>
                        
                            <form id="reset-password" class="uk-form" method="post" action="login/postReset">
                                <div class="uk-form-row">
                                    <input class="uk-width-1-1 uk-form-large" type="text" placeholder="Email" name="email">
                                </div>
                                
                                <div class="uk-form-row">
                                    <button type="submit" class="uk-width-1-1 uk-button uk-button-danger uk-button-large" href="#">Reset password</button>
                                </div>
                                <div class="uk-form-row ">
                                    Newly generated password will be send to email.
                                </div>
                            </form>
                        </div>

                    </li>



                </ul>
                
                <div class="uk-margin-top">
                     <a href="<?=URL_BASE?>"><i class="uk-icon-home"></i> Home page</a>
                </div>
            </div>
        </div>
        
    
        <script>
            $("form").on("submit",function(e){ 
                e.preventDefault();
                var $form = $(this);
                $(".uk-form-danger", $form).removeClass('uk-form-danger');
                
                $.post("<?=URL_BASE?>ajax.php?f="+$(this).attr('action'), $(this).serialize()).done(function(ret){
                    $("body").find(".uk-alert").remove();
                    ret = $.parseJSON(ret);
                    if(ret.required){
                        $.each(ret.required, function(i,field){ $("[name='"+field+"']", $form).addClass("uk-form-danger"); });
                        $("body").prepend('<div class="uk-alert uk-alert-danger"><b>Fill down Required fields</b></div>');
                    }else if(ret.error){
                        $("body").prepend('<div class="uk-alert uk-alert-danger"><b>'+ret.error+'</b></div>');
                    }else if(ret.success){
                        $("body").prepend('<div class="uk-alert uk-alert-success"><b>'+ret.success+'</b></div>');
                        window.location.href = "profile.php";
                    }
                });
            });
            
            
            $("a", "ul.uk-tab > li").on("click",function(e){ e.preventDefault();
                $(".uk-active", $(this).closest(".uk-tab") ).removeClass("uk-active");
                $(this).parent().addClass("uk-active");
                $("li.uk-active", $(this).closest(".uk-tab").attr("data-uk-tab")).removeClass("uk-active");
                $( $(this).attr("href") ).addClass("uk-active");
            });
        </script>
    
    </body>
</html>

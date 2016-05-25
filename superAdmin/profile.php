<?php include 'snipps/init.php'; ?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Profile</title>
        <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon.png">
        
        <script src="<?=$_ASSETS['jquery.js']?>"></script>
        
        <link  href="<?=$_ASSETS['uikit.css']?>" rel="stylesheet"/>
        <script src="<?=$_ASSETS['uikit.js']?>"></script>
        <script src="<?=$_ASSETS['uikit.offcanvas.js']?>"></script>
        
        <link  href="<?=$_ASSETS['uikit.notify.css']?>" rel="stylesheet" />
        <script src="<?=$_ASSETS['uikit.notify.js']?>"></script>
        
        <link  href="<?=$_ASSETS['application.css']?>" rel="stylesheet">
        <link  href="<?=$_ASSETS['theme.css']?>" rel="stylesheet">
        
        <style type="text/css">
            @media (min-width: 768px){
                .left-menu-hat { border-right: 1px solid #ddd; } 
            }
        </style>
    </head>
    <body id="page-profile"> 
        <?php include 'snipps/head.php'; ?>
        
        <br>
        <div class="uk-container">
        
        <div class="uk-grid uk-margin">
            
            <div class="uk-width-medium-1-4">
                <div class="uk-text-center left-menu-hat">
                    <i class="uk-icon-user uk-border-circle uk-margin-bottom" style="font-size:6em;padding:0.1em 0.2em;background:#f5f5f5;color:#fff"></i>
                    <div id="personal-email" class="uk-text-muted" style="padding-bottom:1em">-</div>
                </div>
                <ul class="uk-tab uk-tab-left" data-uk-tab="#tab-content">
                    <li class="uk-active"><a href="#profile">Profile</a></li>
                    <li><a href="#messages">Messages</a></li>
                </ul>
                <div class="uk-hidden-small" style="border-right:1px solid #ddd">
                    <br><br><br><br><br><br><br><br><br>
                </div>
            </div>
            
            
            <div class="uk-width-medium-3-4 uk-margin">
                <ul class="uk-switcher" id="tab-content">
                    <li id="profile" class="uk-active">
                        <form class="uk-form" action="postUpdateProfile" method="post">
                        <h2>Profile</h2>
                        <dl id="personal-summary" class="uk-description-list uk-description-list-line uk-width-medium-1-2">
                            <dt>Name</dt>
                            <dd id="personal-name" class="uk-visible-hover-inline">-</dd>

                            <dt>Family</dt>
                            <dd id="personal-family" class="uk-visible-hover-inline">-</dd>

                            <dt>Phone</dt>
                            <dd id="personal-phone" class="uk-visible-hover-inline">-</dd>
                            
                            <dt>Address</dt>
                            <dd id="personal-address" class="uk-visible-hover-inline">-</dd>
                            
                            <dt>Password</dt>
                            <dd id="personal-password" class="uk-visible-hover-inline">-</dd>
                        </dl>
                        <button id="submit-change-personal-data" type="submit" class="uk-button uk-button-primary uk-hidden">Save changes</button>
                        <button id="reset-change-personal-data" type="reset" class="uk-button uk-hidden">Reset</button>
                        </form>
                        <script>
                            $.getJSON("ajax.php?f=getLogged").done(function(d){ 
                                if(d.id){
                                    var icon = ' <a class="uk-hidden uk-icon-pencil uk-float-right"></a>';
                                    $("#personal-name").html(d.name + "&nbsp;" + icon);
                                    $("#personal-family").html(d.family + "&nbsp;" + icon);
                                    $("#personal-phone").html(d.phone + "&nbsp;" + icon);
                                    $("#personal-email").html(d.email + "&nbsp;");
                                    $("#personal-address").html(d.address + "&nbsp;" + icon);
                                    $("#personal-password").html("&bull;&bull;&bull;&bull;&bull;" + icon);
                                }else{
                                    window.location.href = "login.php";
                                }     
                            });
                            $("#personal-summary").on("click", ".uk-icon-pencil", function(e){
                                e.preventDefault();
                                var oldval = $.trim($(this).parent().text());
                                var name = $(this).parent().attr("id");
                                if(name == "personal-password"){
                                    $(this).parent().html('<input type="password" class="uk-width-1-1" name="password">');
                                }else{
                                    $(this).parent().html('<input type="text" class="uk-width-1-1" name="'+name.substring(9)+'" value="'+oldval+'">');
                                }
                                $("#submit-change-personal-data").removeClass("uk-hidden");
                                $("#reset-change-personal-data").removeClass("uk-hidden");
                            });
                            
                        </script>
                    </li>
                    <li id="mesages"> 
                        <h2>Your Messages</h2> 
                        <table class="uk-table uk-table-hover uk-table-striped">
                            <thead><tr> <th>Date</th><th>Address</th><th>Products</th><th>Total</th> </tr></thead>
                            <tbody><tr> <td colspan="4" class="uk-text-center uk-text-muted">No activities</td> </tr></tbody>
                        </table>
                    </li>
                </ul>
            </div>
            
            
            <script>
             $("a", "ul.uk-tab > li").on("click",function(e){ e.preventDefault();
                $("li.uk-active", $(this).closest(".uk-tab").attr("data-uk-tab")).removeClass("uk-active");
                $( $(this).attr("href") ).addClass("uk-active");
            });
            
            
            $("form").on("submit",function(e){ 
                e.preventDefault();
                var $form = $(this);
                $(".uk-form-danger", $form).removeClass('uk-form-danger');
                
                $.post("ajax.php?f="+$(this).attr('action'), $(this).serialize()).done(function(ret){
                    $("body").find(".uk-alert").remove();
                    ret = $.parseJSON(ret);
                    if(ret.required){
                        $.each(ret.required, function(i,field){ $("[name='"+field+"']", $form).addClass("uk-form-danger"); });
                        $form.prepend('<div class="uk-alert uk-alert-danger"><b>Fill down Required fields</b></div>');
                    }else if(ret.error){
                        $form.prepend('<div class="uk-alert uk-alert-danger"><b>'+ret.error+'</b></div>');
                    }else if(ret.success){
                        window.location.href = "profile.php";
                    }
                });
            });
            </script>
            
            
        </div>
        </div>
        <?php include 'snipps/foot.php'; ?>
    </body>
</html>
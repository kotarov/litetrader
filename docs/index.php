<?php
    header("Cache-Control: max-age=2592000"); //30days (60sec * 60min * 24hours * 30days)
    $page = '';
    if(isset($_GET['p']) && file_exists($_GET['p'])) $page = $_GET['p'];
?>
<!DOCTYPE html>
<html class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Application - UIkit</title>
        <link rel="shortcut icon" href="http://getuikit.com/docs/images/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="http://getuikit.com/docs/images/apple-touch-icon.png">
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.min.js"></script>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/uikit.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/uikit.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/core/offcanvas.min.js"></script>
    
        <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
        <style>pre.prettyprint{border-color:#ddd;padding:1em}</style>
    
        <style>
            .tm-navbar{background:#000;}
            .tm-navbar.uk-contrast a:not([class]):hover{color:#000}
        </style>
    </head>
    <body>
        <nav class="tm-navbar uk-contrast uk-navbar uk-navbar-attached">
            <div class="uk-container uk-container-center">

                <a class="uk-navbar-brand uk-hidden-small uk-text-primary" href="index.php"><img class="uk-margin uk-margin-remove" src="http://getuikit.com/docs/images/logo_uikit.svg" width="90" height="30" title="UIkit" alt="UIkit"> Application</a>

                <ul class="uk-navbar-nav uk-hidden-small">
                    <?php /*<li  class="uk-active"><a href="documentation_get-started.html">Application</a></li>*/?>
                    <li><a href="http://getuikit.com/docs/core.html" target="uikitcore"><i class="uk-icon-external-link"></i> Core</a></li>
                    <li><a href="http://getuikit.com/tests/overview.html" target="uitests"><i class="uk-icon-external-link"></i> Tests</a></li>
                </ul>

                <a href="#tm-offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas=""></a>

                <div class="uk-navbar-brand uk-navbar-center uk-visible-small"><img src="http://getuikit.com/docs/images/logo_uikit.svg" width="90" height="30" title="UIkit" alt="UIkit"></div>

            </div>
        </nav>
        
        <div class="uk-grid uk-margin-large-top uk-container uk-container-center1">
            <div class="uk-width-2-10">
                <ul class="uk-nav">
                    <li><a href="?p=initdata.php">Init data</a></li>
                    <li><a href="?p=dependace.php">Dependant data</a></li>
                    <li><a href="?p=tables.php">Tables</a></li>
                    <li><a href="?p=toggle.php">Toggle</a></li>
                    <li><a href="?p=form.php">Form</a></li>
                    <li><a href="?p=select2.php">Select2</a></li>
                </ul>
            </div>
            <div class="uk-width-8-10">
                <?php if($page) include $page; else { ?>
                <article class="uk-article">
                    <h1 class="uk-article-title"> UIkit for application</h1>
                    <p class="uk-article-lead"> Creating application </p>
                    <p>With this plugin you can create easly and fast backoffice applications.</p>
                </article>
                
                <hr>
                
                <h2 class="uk-article-title">Usage</h2>
                <pre class="prettyprint">
                    <code class="lang-html">
                        
    &lt;head&gt;
        ...
        &lt;script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.min.js"&gt;&lt;/script&gt;
        &lt;link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/uikit.min.css" /&gt;
        &lt;script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/uikit.min.js">&lt;/script&gt;
        ...
    &lt;/head&gt;
    &lt;body&gt;
        ...
        &lt;script src="js/application.js"&gt;&lt;/script&gt;
    &lt;/body&gt;
                    </code>
                </pre>
                
                <?php } ?> 
            </div>
        </div>
        <script>
            $("pre > code").each(function(k,tag){
                var t = $(this).html();
                t = t.replace(/^[\r\n]+/, "").replace(/\s+$/g, "");
                t = t.replace(/\</g, "&lt;").replace(/\>/g,"&gt;");
                $(this).html(t);
            });
        </script>
    </body>
</html>
    
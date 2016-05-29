<?php include '../snipps/init.php'; ?>
<?php
    $dbh = new PDO('sqlite:'.DB_DIR.'blogs');
    $p = isset($_GET['p']) ? (int)$_GET['p'] : 0 ;
    $l = 15;
    
    $articles = $dbh->query("
    SELECT 
        b.id,
        b.title,
        b.subtitle,
        c.title category,
        b.tags,
        b.author,
        b.`date`,
        b.content,
        b.id image,
        b.is_new
    FROM blogs b
    LEFT JOIN categories c ON (c.id = b.id_category)
    WHERE c.is_visible = 1 AND b.is_active = 1 
    LIMIT $p,$l
    ")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contacts</title>
        <link rel="shortcut icon" href="<?=URL_BASE?>img/favicon.png" type="image/x-icon">
        
        <script src="<?=$_ASSETS['jquery.js']?>"></script>
        
        <link  href="<?=$_ASSETS['uikit.css']?>" rel="stylesheet"/>
        <script src="<?=$_ASSETS['uikit.js']?>"></script>
        <script src="<?=$_ASSETS['uikit.offcanvas.js']?>"></script>
        
        <link rel="stylesheet" href="<?=$_ASSETS['uikit.search.css']?>">
        <script src="<?=$_ASSETS['uikit.search.js']?>"></script>
    </head>
    <body id="page-articles"> 
    <?php include '../snipps/head.php'; ?>
    <br>
    
    <div class="uk-grid">
        <div class="uk-width-medium-3-4">
        <?php foreach($articles AS $article){
           include __DIR__.'/article.php'; 
           echo "<hr><br>";
        }?>
        </div>
        <div class="uk-width-medium-1-4">
            
        </div>
    </div>
    
    <br>
    <?php include '../snipps/foot.php';?>
    </body>
</html>
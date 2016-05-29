<article class="uk-article">
    <h1 name="title" class="uk-width-1-1 uk-article-title editable">
        <?=$article['title']?>
    </h1>
    
    
    
    <div class="uk-article-meta uk-panel-box1">
        Written by <b><?=$article['author']?></b> on <b><?=$article['date']?></b> Posted in <b><?=$article['category']?></b></select>
    </div>
    
    <div class="uk-article-divider"></div>
    
    <div class="uk-article-lead uk-width-1-1 editable" name="subtitle" >
        <?=$article['subtitle']?>
    </div>
    
    <div><a href="<?=URL_BASE?>view/index.php/<?=$article['id'].'/'.$article['title']?>">Read more <i class="uk-icon-link"></i></a></div>
    
    <?php /*
    <div class="uk-article-divider"></div>                        
    
    <div name="content" class="uk-width-1-1 edit uk-margin-top uk-margin-bottom editable" >
        <i class="uk-icon-external-link"></i> <?=$article['content']?>
    </div>
    */?>
</article>
<!-- featured -->
<hr>
<h2>Featured</h2>
<div class="uk-margin" id="featured" data-uk-slideset1="{medium: 4}">
    <div class="uk-slidenav-position uk-margin">
        <ul id="featured-content" class="uk-slideset uk-grid uk-flex-center"></ul>
        <a href="#" class="uk-slidenav uk-slidenav-previous" data-uk-slideset-item="previous"></a>
        <a href="#" class="uk-slidenav uk-slidenav-next" data-uk-slideset-item="next"></a>
    </div>
    <ul class="uk-slideset-nav uk-dotnav uk-flex-center"></ul>
</div>
<script>
    $.getJSON("<?=URL_BASE?>ajax.php?f=getFeatured",function(featured){
        $.each(featured.data, function(k,v){ 
            var item = '<a class="uk-thumbnail uk-overlay-hover" href="<?=URL_BASE.URL_PRODUCT?>'+v.url_rewrite+'">'
            +'  <figure class="uk-overlay">'
            +'      <img src="<?=URL_BASE?>image.php/'+v.img+'/small/'+v.date_add+'" alt="'+v.alt+'">'
            +'      <div class="uk-overlay-panel uk-overlay-background uk-overlay-bottom uk-overlay-slide-bottom">'+v.price+'</div>'
            +'  </figure>'
            +'  <div class="uk-thumbnail-caption">'+v.title+'</div>'
            +'</a>';
            $("#featured-content").append('<li>'+item+'</li>');
        });
        UIkit.slideset("#featured", { "large":5, "medium":4, "small":2, "autoplay": true });
    });
</script>
<!-- //featured -->
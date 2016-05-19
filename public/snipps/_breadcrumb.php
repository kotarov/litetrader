$(".uk-breadcrumb").html('<li><a href="<?=URL_BASE?>products/"><i class="uk-icon-home"></i> Home</a></li>');
$.each(breadcrumb, function(r,c){
    $(".uk-breadcrumb").append('<li><a href="<?=URL_BASE?>products'+c.url_rewrite+'">'+c.name+'</a></li>');
});
$(".uk-breadcrumb").append('<li class="uk-active"><a href="<?=URL_BASE?>products'+ret.data.url_rewrite+'">'+ret.data.category+'</a></li>');



$(".uk-breadcrumb").html('<li><a data-live href="<?=URL_BASE?>products/"><i class="uk-icon-home"></i> Home</a></li>');
$.each(ret.parents, function(k,v){
    $(".uk-breadcrumb").append('<li><a data-live href="<?=URL_BASE?>products'+v.url_rewrite+'">'+v.name+'</a></li>');
});
if(typeof ret.current.name !== "undefined") $(".uk-breadcrumb").append('<li><span>'+ret.current.name+'</span></li>');

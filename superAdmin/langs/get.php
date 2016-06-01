var lang = 
<?php session_start();

$lang_file = 'bg.json';

if(isset($_SESSION['lang']) && file_exists($_SESSION['lang'].'.json') ){
    $file_lang = $_SESSION['lang'].'.json';    
}

include $lang_file;

$page_lang_file = basename($_SERVER['HTTP_REFERER']).'/'.$lang_file;

if(file_exists($page_lang_file)) {
    echo "\n$.extend(lang,".file_get_contents($page_lang_file).");";
}

?>


$(function(){
    
    $("[data-lang]").each(function(k,o){
        switch($(o).prop("tagName")){
            case "INPUT":
                var st = $(o).attr("placeholder");
                if(typeof st == "string") $(o).attr( "placeholder", (lang[st]||st) );
                break;
            default:
                var st = $.trim( $(o).data("lang")) || $.trim($(o).html());
                if(typeof st == "string") $(o).html( lang[st]||st );
        }
    });
});


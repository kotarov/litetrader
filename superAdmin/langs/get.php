var lang = 
<?php session_start();

$lang_file = 'bg.json';

if(isset($_SESSION['lang']) && file_exists($_SESSION['lang'].'.json') ){
    $file_lang = $_SESSION['lang'].'.json';    
}

include $lang_file;
?>
/*
function _(st){
    return lang[st]||st;
}*/

$(function(){
    
    $("[data-lang]").each(function(k,o){
        switch($(o).prop("tagName")){
            case "INPUT":
                var st = $(o).attr("placeholder");
                if(typeof st == "string") $(o).attr( "placeholder", (lang[st]||st) );
                break;
            default:
                var st = $.trim($(o).html());
                if(typeof st == "string") $(o).html( lang[st]||st );
        }
    });
});


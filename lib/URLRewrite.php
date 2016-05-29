<?php
function url_rewrite($str){
    return str_replace(array(' ','\\','"',"'",  '"',"'",'&lt;','&gt;'),'-',trim($str));
}
?>
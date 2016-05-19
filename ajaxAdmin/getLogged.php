<?php
//session_start();

if(isset($_SESSION['employee']))
    return json_encode($_SESSION['employee']);
else
    return json_encode(array('access_denided'=>1));
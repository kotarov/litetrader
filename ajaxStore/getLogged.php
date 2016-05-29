<?php
if(isset($_SESSION['supplier']))
    return json_encode($_SESSION['supplier']);
else
    return json_encode(array('access_denided'=>1));
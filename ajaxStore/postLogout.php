<?php
if(isset($_SESSION['supplier'])){
    unset($_SESSION['supplier']);
}

return json_encode(array('redirect'=>'index.php'));
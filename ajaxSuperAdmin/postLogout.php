<?php
if(isset($_SESSION['employee'])){
    unset($_SESSION['employee']);
}

return json_encode(array('redirect'=>'index.php'));
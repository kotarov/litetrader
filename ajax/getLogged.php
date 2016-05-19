<?php
session_start();

if(isset($_SESSION['customer']))
    return json_encode($_SESSION['customer']);
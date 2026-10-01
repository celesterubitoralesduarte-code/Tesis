<?php

include_once __DIR__. '/../../config.php';

session_start();
 session_unset();                     
    session_destroy();
    header('Location:'.$URL.'login/index.php');
    exit();
    

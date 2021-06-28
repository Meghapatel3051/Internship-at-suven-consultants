<?php
    session_start();
    if(!isset($_SESSION['user'])) {
        exit('notloggedin');
    }
    require_once './process.php';
    
    $user = $_SESSION['user'];
    echo getEvents($user);
?>
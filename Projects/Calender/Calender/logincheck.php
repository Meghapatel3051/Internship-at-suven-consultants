<?php
    session_start();
    if(isset($_SESSION['user'])) {
        exit('loggedin');
    }
    exit('notloggedin');
?>
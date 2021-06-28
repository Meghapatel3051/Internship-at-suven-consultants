<?php 
require_once './process.php';
session_start();
if(!isset($_SESSION['user'])) {
    exit('loginfirst');
}
$title = '';
if(!isset($_POST['title'])) {
    exit('inputerror');
} else {
    $title = $_POST['title'];
}

$e_desc = '';
if(isset($_POST['e_desc'])) {
    $e_des = $_POST['e_desc'];
}

$startdt = null;
if(!isset($_POST['e_s_dt'])) {
    exit('inputerror');
} else {
    $startdt = $_POST['e_s_dt'];
}

$enddt = null;
if(!isset($_POST['e_e_dt'])) {
    exit('inputerror');
} else {
    $enddt = $_POST['e_e_dt'];
}

$user = $_SESSION['user'];
$result = addEvent($user, $title, $e_desc, $startdt, $enddt);
if($result) {
    exit('eventadded');
} else {
    exit('error');
}
?>
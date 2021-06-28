<?php 
require_once './process.php';
session_start();
if(!isset($_SESSION['user'])) {
    exit('notloggedin');
}
if(!isset($_GET['id'])) {
    exit('error');
}
$id = $_GET['id'];
echo removeEvent($id)

?>
<?php
require_once './process.php';

if(isset($_GET['username'])) {
    $un = $_GET['username'];
    $conn;
    $login_sql = "SELECT username FROM Users WHERE username = ?";
    $stmt = $conn->prepare($login_sql);
    $stmt->bind_param("s", $un);

    if($stmt->execute()) {
        $result = $stmt->get_result();
        $stmt->close();
        $conn->close();
        if($result && $result->num_rows >= 1) {
            $user = $result->fetch_assoc();
            echo 'taken';
        } else {
            echo 'available';
        }
    } else {
        $stmt->close();
        $conn->close();
        echo 'taken';
    }
}
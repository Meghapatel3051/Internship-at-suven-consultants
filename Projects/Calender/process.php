<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calender";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";

function login($un, $pwd) {
    global $conn;
    $login_sql = "SELECT username FROM Users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($login_sql);
    $stmt->bind_param("ss", $un, $pwd);

    if($stmt->execute()) {
        $result = $stmt->get_result();
        $stmt->close();
        $conn->close();
        if($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            return $user['username'];
        } else {
            return false;
        }
    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}

function signup($un, $pwd) {
    global $conn;
    $login_sql = "INSERT INTO Users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($login_sql);
    $stmt->bind_param("ss", $un, $pwd);

    if($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;

    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}

function addEvent($user, $title, $edesc, $esdt, $eedt) {
    global $conn;
    $addEventQry = "INSERT INTO Events (user, title, detail, startdt, enddt) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($addEventQry);
    $stmt->bind_param("sssss", $user, $title, $edesc, $esdt, $eedt);

    if($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;

    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}

function getEvents($user) {
    global $conn;
    $event_qry = "SELECT * FROM events WHERE user = ?";
    $stmt = $conn->prepare($event_qry);
    $stmt->bind_param("s", $user);

    if($stmt->execute()) {
        $result = $stmt->get_result();
        $stmt->close();
        $conn->close();
        $data = array();
        if($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($data, $row);
            }
        }
        return json_encode($data);
    } else {
        $stmt->close();
        $conn->close();
        return 'error';
    }
}

function removeEvent($id) {
    global $conn;
    $delevent_qry = "DELETE FROM events WHERE id = ?";
    $stmt = $conn->prepare($delevent_qry);
    $stmt->bind_param("i", $id);

    if($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return "deleted";
    } else {
        $stmt->close();
        $conn->close();
        return 'error';
    }
}

?>
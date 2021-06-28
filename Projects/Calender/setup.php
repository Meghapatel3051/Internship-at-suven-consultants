<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calender";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully<br>";

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully<br>";
} else {
  echo "Error creating database: " . $conn->error;
}

$selectdb = "USE $dbname";
if ($conn->query($selectdb) === TRUE) {
    echo "Database selected successfully<br>";
  } else {
    echo "Error creating database: " . $conn->error;
  }

$usertable = "CREATE TABLE IF NOT EXISTS Users (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(128) UNIQUE NOT NULL,
password VARCHAR(128) NOT NULL,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($usertable) === TRUE) {
    echo "Table Users created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error;
}

$eventtable = "CREATE TABLE IF NOT EXISTS Events (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
user VARCHAR(128) FOREIGN KEY REFERENCES Users(username),
title VARCHAR(60) NOT NULL,
detail VARCHAR(250),
startdt DATETIME NOT NULL,
enddt DATETIME NOT NULL,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($eventtable) === TRUE) {
    echo "Table Event created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error;
}
$conn->close();
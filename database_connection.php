<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crd_sela";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db = $conn;
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
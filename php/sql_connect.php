<?php

$servername = "localhost:3306";
$databasename = "sqlChat";
$username = "root";
$password = "root"; 

try {
    $conn = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
    
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "\033[31mConnection failed: " . $e->getMessage() . "\033[0m\n";
    exit();
}
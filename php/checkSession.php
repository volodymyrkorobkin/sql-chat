<?php
include_once 'session.php';

session_start();

if (!isset($_SESSION["id"])) {
    echo "No session";
    exit();
}

if (!isValidSession($_SESSION["id"])) {
    echo "Invalid session";
    exit();
}

$session = $_SESSION["id"];
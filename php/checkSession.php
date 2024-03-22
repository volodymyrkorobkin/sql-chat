<?php
include_once 'session.php';

function checkSession() {
    session_start();

    if (!isset($_SESSION["id"])) {  
        return false;
    }
    
    if (!isValidSession($_SESSION["id"])) {
        return false;
    }
    
    return $_SESSION["id"];
}
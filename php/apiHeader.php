<?php
include_once '../php/sql_connect.php';
include_once '../php/sql_utils.php';
include_once '../php/chat.php';

$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);
if ($data != null) {
    foreach ($data as $key => $value) {
        $_POST[$key] = $value;
    }
}

// Check keys and session
include_once "../php/checkRequestKeys.php";
include_once "../php/checkSession.php";

$userId = getUserBySession($session);

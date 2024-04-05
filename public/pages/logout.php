<?php
session_start();
$_SESSION["id"] = null;
header("Location: sign_in.php");
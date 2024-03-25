<?php

foreach ($requestKeys as $key) {
    if (!isset($_POST[$key]) && !isset($_GET[$key])) {
        echo "No $key";
        exit();
    }
}
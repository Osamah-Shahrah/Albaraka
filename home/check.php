<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!session_start()) {
    die("Failed to start session");
}
include "../db.php";
include "header.php";
include "Myfun_albraka.php";

// Check if the user is logged in and has the necessary session data
if (isset($_SESSION['logged_in_user']) && isset($_SESSION['id_user']) && $_SESSION['name'] !== "") {
    // User is logged in and has valid session data, proceed with the page
} else {
    // User is not logged in or session data is invalid, redirect to the login page
    header('location:../index.php');
    exit;
}
?>
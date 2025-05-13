<?php
// verifyLogin.php
// Verifies if a user is logged in

if(!isset($_SESSION['role'])) {
    header("Location: login");
    die();
}
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "ecommerce"; // pastikan database ini ada di phpMyAdmin

$conn = mysqli_connect($host, $user, $pass, $db);

// Debug koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error()); // ini penting untuk melihat error koneksi
}
?>

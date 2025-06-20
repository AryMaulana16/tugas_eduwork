<?php
session_start();
include 'db.php';

$session_id = session_id();

// Hapus keranjang dari session
unset($_SESSION['keranjang']);

// Hapus juga dari database jika digunakan
mysqli_query($conn, "DELETE FROM keranjang WHERE session_id = '$session_id'");

header("Location: keranjang.php");
exit;

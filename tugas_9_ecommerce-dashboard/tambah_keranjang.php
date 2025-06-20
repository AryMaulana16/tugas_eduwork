<?php
session_start();
include 'db.php';

$id = $_POST['produk_id'];

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

if (isset($_SESSION['keranjang'][$id])) {
    $_SESSION['keranjang'][$id] += 1;
} else {
    $_SESSION['keranjang'][$id] = 1;
}

// (Opsional) Simpan juga ke DB:
$session_id = session_id();
$cek = mysqli_query($conn, "SELECT * FROM keranjang WHERE session_id='$session_id' AND produk_id=$id");
if (mysqli_num_rows($cek) > 0) {
    mysqli_query($conn, "UPDATE keranjang SET jumlah=jumlah+1 WHERE session_id='$session_id' AND produk_id=$id");
} else {
    mysqli_query($conn, "INSERT INTO keranjang (session_id, produk_id, jumlah) VALUES ('$session_id', $id, 1)");
}

header("Location: keranjang.php");
exit;

<?php
// Informasi koneksi database
$host     = "localhost";     // Server database
$username = "root";          // Username database (default XAMPP: root)
$password = "";              // Password database (default XAMPP: kosong)
$database = "ecommerce_db"; // Ganti dengan nama database Anda

// Membuat koneksi
$koneksi = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
} else {
    #echo "Koneksi berhasil"; // Aktifkan jika ingin menampilkan pesan sukses
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars(trim($_POST['nama']));
    $harga = htmlspecialchars(trim($_POST['harga']));
    $deskripsi = htmlspecialchars(trim($_POST['deskripsi']));

    // validasi sederhana
    if (empty($nama) || empty($harga) || empty($deskripsi)){
        echo "Anda belum memasukkan data";
        exit;
    }

    // Tampilkan hasil input sebagai simulasi penyimpanan
    echo "<h2>Produk Berhasil Ditambahkan</h2>";
    echo "Nama Produk: $nama<br>";
    echo "Harga: Rp " . number_format($harga, 0, ',', '.') . "<br>";
    echo "Deskripsi: $deskripsi";
} else {
    echo "Form belum dikirim.";
}
?>

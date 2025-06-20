<?php
session_start();
include 'db.php';

// Ambil isi keranjang dari session
$keranjang = $_SESSION['keranjang'] ?? [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h2 class="mb-4">🛒 Keranjang Belanja</h2>

    <div class="mb-3 d-flex justify-content-between">
        <a href="index.php" class="btn btn-secondary">← Kembali ke Produk</a>
        <?php if (!empty($keranjang)): ?>
            <form method="post" action="hapus_keranjang.php" onsubmit="return confirm('Yakin ingin mengosongkan keranjang?')">
                <button type="submit" class="btn btn-danger">Kosongkan Keranjang 🗑</button>
            </form>
        <?php endif; ?>
    </div>

    <?php if (empty($keranjang)): ?>
        <div class="alert alert-warning">Keranjang Anda kosong.</div>
    <?php else: ?>
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($keranjang as $id => $jumlah):
                    $produk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id=$id"));
                    $subtotal = $produk['harga'] * $jumlah;
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?= $produk['nama_produk'] ?></td>
                    <td>Rp <?= number_format($produk['harga'], 0, ',', '.') ?></td>
                    <td><?= $jumlah ?></td>
                    <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <th colspan="3" class="text-end">Total</th>
                    <th>Rp <?= number_format($total, 0, ',', '.') ?></th>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>

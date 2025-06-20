<?php
session_start();
include 'db.php';

// Ambil daftar kategori unik dari tabel products
$kategori_result = mysqli_query($conn, "SELECT DISTINCT kategori FROM products");

// Ambil kategori dari filter (jika ada)
$filter_kategori = $_GET['kategori'] ?? '';

// Query produk (dengan atau tanpa filter)
if ($filter_kategori) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE kategori = ?");
    $stmt->bind_param("s", $filter_kategori);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = mysqli_query($conn, "SELECT * FROM products");
}

// Hitung total item dalam keranjang
$jumlah_keranjang = isset($_SESSION['keranjang']) ? array_sum($_SESSION['keranjang']) : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
    <!-- Navigasi -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 border rounded px-3 py-2">
        <a class="navbar-brand fw-bold" href="index.php">🛍 E-Commerce</a>
        <div class="ms-auto">
            <a href="keranjang.php" class="btn btn-outline-success">
                🛒 Keranjang <span class="badge bg-success"><?= $jumlah_keranjang ?></span>
            </a>
        </div>
    </nav>

    <!-- Header dan tombol tambah -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Daftar Produk</h3>
        <a href="tambah.php" class="btn btn-primary">+ Tambah Produk</a>
    </div>

    <!-- Filter kategori -->
    <form method="get" class="mb-3 d-flex gap-2 align-items-center">
        <label for="kategori" class="form-label mb-0">Filter Kategori:</label>
        <select name="kategori" id="kategori" class="form-select w-auto" onchange="this.form.submit()">
            <option value="">-- Semua Kategori --</option>
            <?php while ($kat = mysqli_fetch_assoc($kategori_result)): ?>
                <option value="<?= $kat['kategori'] ?>" <?= $filter_kategori == $kat['kategori'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($kat['kategori']) ?>
                </option>
            <?php endwhile; ?>
        </select>
        <?php if ($filter_kategori): ?>
            <a href="index.php" class="btn btn-sm btn-secondary">Reset</a>
        <?php endif; ?>
    </form>

    <!-- Tabel produk -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) === 0): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tidak ada produk ditemukan.</td>
                    </tr>
                <?php else: ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" width="60" alt="<?= htmlspecialchars($row['nama_produk']) ?>"></td>
                        <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                        <td><?= htmlspecialchars($row['kategori']) ?></td>
                        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td><?= $row['stok'] ?></td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                <form action="tambah_keranjang.php" method="post">
                                    <input type="hidden" name="produk_id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn btn-success btn-sm">+ Keranjang</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

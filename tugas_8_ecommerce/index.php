<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Toko Online</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .card-img-top {
      height: 200px;
      object-fit: cover;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">TokoKu</a>
  </div>
</nav>

<!-- Konten -->
<div class="container mt-5">
  <h1 class="text-center mb-4">Produk Kami</h1>

  <!-- Filter Kategori -->
  <form method="GET" class="mb-4">
    <div class="row">
      <div class="col-md-4">
        <select name="kategori" class="form-select" onchange="this.form.submit()">
          <option value="">-- Semua Kategori --</option>
          <?php
          // Ambil daftar kategori unik dari database
          $kat_query = mysqli_query($koneksi, "SELECT DISTINCT kategori FROM produk ORDER BY kategori ASC");
          while ($kat = mysqli_fetch_assoc($kat_query)) {
            $selected = (isset($_GET['kategori']) && $_GET['kategori'] == $kat['kategori']) ? 'selected' : '';
            echo "<option value='{$kat['kategori']}' $selected>{$kat['kategori']}</option>";
          }
          ?>
        </select>
      </div>
    </div>
  </form>

  <div class="row">
    <?php
    // Filter berdasarkan kategori jika ada
    if (isset($_GET['kategori']) && $_GET['kategori'] != '') {
        $kategori = mysqli_real_escape_string($koneksi, $_GET['kategori']);
        $query = mysqli_query($koneksi, "SELECT * FROM produk WHERE kategori='$kategori'");
    } else {
        $query = mysqli_query($koneksi, "SELECT * FROM produk");
    }

    if (!$query) {
        echo "<p class='text-danger'>Query error: " . mysqli_error($koneksi) . "</p>";
    } elseif (mysqli_num_rows($query) == 0) {
        echo "<p class='text-muted'>Tidak ada produk dalam kategori ini.</p>";
    } else {
        while ($produk = mysqli_fetch_array($query)) {
    ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <img src="images/<?php echo $produk['gambar']; ?>" class="card-img-top" alt="<?php echo $produk['nama']; ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo $produk['nama']; ?></h5>
            <p class="card-text"><?php echo $produk['deskripsi']; ?></p>
            <h6 class="text-success">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></h6>
          </div>
          <div class="card-footer text-center">
            <button class="btn btn-primary">Beli</button>
          </div>
        </div>
      </div>
    <?php }} ?>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

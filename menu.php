<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: dashboard.php");
    exit();
}

include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_makanan'])) {
    $id_user = mysqli_real_escape_string($conn, $_SESSION['id_user']);
    $id_menu = mysqli_real_escape_string($conn, $_POST['id_makanan']);

    
    if (!is_numeric($id_menu)) {
        header("Location: menu.php");
        exit();
    }

    
    $cek = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_user='$id_user' AND id_menu='$id_menu' AND status='pending'");
    if (mysqli_num_rows($cek) > 0) {
        
        mysqli_query($conn, "UPDATE keranjang SET jumlah = jumlah + 1 WHERE id_user='$id_user' AND id_menu='$id_menu' AND status='pending'");
    } else {
        
        mysqli_query($conn, "INSERT INTO keranjang (id_user, id_menu, jumlah, status) VALUES ('$id_user', '$id_menu', 1, 'pending')");
    }

    header("Location: menu.php");
    exit();
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';

$query = "SELECT * FROM menu_makanan";

if ($search !== '') {
    $safe_search = mysqli_real_escape_string($conn, $search);
    $query .= " WHERE nama_makanan LIKE '%$safe_search%'";
}

if ($sort === 'terlaris') {
    $query .= " ORDER BY jumlah_terjual DESC";
} elseif ($sort === 'termurah') {
    $query .= " ORDER BY harga ASC";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu Makanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">KulinerinAja</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="menu.php">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="pesanan.php">Pesanan</a></li>
                <button type="button" class="btn btn-outline-danger" onclick="window.location.href='logout.php'">Logout</button>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center mb-4">Daftar Menu Makanan</h2>
    <p class="text-center">Temukan makanan favoritmu di sini!</p>
    <hr class="mb-4">

    <div class="mb-4 d-flex justify-content-between">
        <form method="get" class="d-flex" style="gap: 10px;">
            <input type="text" name="search" class="form-control" placeholder="Cari makanan..." value="<?= htmlspecialchars($search); ?>">
            <select name="sort" class="form-select">
                <option value="default">Urutkan</option>
                <option value="terlaris" <?= ($sort === 'terlaris') ? 'selected' : ''; ?>>Terlaris</option>
                <option value="termurah" <?= ($sort === 'termurah') ? 'selected' : ''; ?>>Termurah</option>
            </select>
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        <a href="keranjang.php" class="btn btn-primary">Keranjang
            <span class="badge bg-light text-dark ms-2">
                <?php
                $id_user = $_SESSION['id_user'];
                $query_keranjang = mysqli_query($conn, "SELECT COUNT(*) as total FROM keranjang WHERE id_user='$id_user' AND status='pending'");
                $data_keranjang = mysqli_fetch_assoc($query_keranjang);
                echo $data_keranjang['total'];
                ?>
            </span>
        </a>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['nama_makanan']); ?></h5>
                        <p class="card-text">Kategori: <?= htmlspecialchars($row['kategori']); ?></p>
                        <p class="card-text">Harga: Rp<?= number_format($row['harga'], 0, ',', '.'); ?></p>
                        <p class="card-text"><small><?= htmlspecialchars($row['deskripsi']); ?></small></p>
                        <form method="post">
                            <input type="hidden" name="id_makanan" value="<?= $row['id_menu']; ?>">
                            <input type="hidden" name="nama_makanan" value="<?= htmlspecialchars($row['nama_makanan']); ?>">
                            <input type="hidden" name="harga" value="<?= $row['harga']; ?>">
                            <button type="submit" class="btn btn-primary mt-2">Tambah ke Keranjang</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="mt-5 text-center">
        <a href="pesanan.php" class="btn btn-success">Lihat Keranjang / Pesan</a>
    </div>
</div>

<footer class="text-center text-lg-start bg-light text-muted mt-5">
    <div class="text-center p-4">
        © 2025 KulinerinAja. All rights reserved.
    </div> 
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

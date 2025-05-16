<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$id_user = mysqli_real_escape_string($conn, $_SESSION['id_user']);

if (isset($_GET['hapus'])) {
    $id_menu = mysqli_real_escape_string($conn, $_GET['hapus']);
    mysqli_query($conn, "DELETE FROM keranjang WHERE id_user = '$id_user' AND id_menu = '$id_menu' AND status='pending'");
    header("Location: keranjang.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id_menu = mysqli_real_escape_string($conn, $_POST['id_menu']);
    $jumlah = max(1, (int) $_POST['jumlah']);
    mysqli_query($conn, "UPDATE keranjang SET jumlah = '$jumlah' WHERE id_user = '$id_user' AND id_menu = '$id_menu' AND status='pending'");
    header("Location: keranjang.php");
    exit();
}

$query = mysqli_query($conn, "
    SELECT k.id_menu, k.jumlah, m.nama_makanan, m.harga
    FROM keranjang k
    JOIN menu_makanan m ON k.id_menu = m.id_menu
    WHERE k.id_user = '$id_user' AND k.status = 'pending'
");

$keranjang = [];
while ($row = mysqli_fetch_assoc($query)) {
    $keranjang[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">KulinerinAja</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="menu.php">Menu</a></li>
                <li class="nav-item"><a class="nav-link active" href="keranjang.php">Keranjang</a></li>
                <button type="button" class="btn btn-outline-danger ms-2" onclick="window.location.href='logout.php'">Logout</button>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class=" text-center mb-4">Keranjang Belanja</h2>
    
    <hr>

    <?php if (empty($keranjang)): ?>
        <div class="alert alert-info text-center">
            Keranjang Anda kosong. Silakan <a href="menu.php" class="alert-link">pilih makanan</a> untuk menambahkannya ke keranjang.
        </div>

    <?php else: ?>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grand_total = 0;
                foreach ($keranjang as $item):
                    $total = $item['jumlah'] * $item['harga'];
                    $grand_total += $total;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nama_makanan']); ?></td>
                        <td>Rp<?= number_format($item['harga'], 0, ',', '.'); ?></td>
                        <td>
                            <form method="post" class="d-flex">
                                <input type="hidden" name="id_menu" value="<?= $item['id_menu']; ?>">
                                <input type="number" name="jumlah" value="<?= $item['jumlah']; ?>" min="1" class="form-control w-50">
                                <button type="submit" name="update" class="btn btn-sm btn-primary ms-2">Update</button>
                            </form>
                        </td>
                        <td>Rp<?= number_format($total, 0, ',', '.'); ?></td>
                        <td>
                            <a href="keranjang.php?hapus=<?= $item['id_menu']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus item ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td colspan="2"><strong>Rp<?= number_format($grand_total, 0, ',', '.'); ?></strong></td>
                </tr>
            </tbody>
        </table>
        <div class="text-end">
            <a href="pesanan.php" class="btn btn-success">Lanjut ke Pesanan</a>
        </div>

        <div class="text-center mt-4">
        <a href="menu.php" class="btn btn-secondary">Kembali ke Menu</a>
        </div>
    <?php endif; ?>
</div>
</body>
</html>

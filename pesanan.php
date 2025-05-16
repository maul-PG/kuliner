<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

$query = mysqli_query($conn, "
    SELECT k.id_menu, k.jumlah, m.nama_makanan, m.harga
    FROM keranjang k
    JOIN menu_makanan m ON k.id_menu = m.id_menu
    WHERE k.id_user = '$id_user' AND k.status = 'pending'
");

$keranjang = [];
$total_harga = 0;

while ($row = mysqli_fetch_assoc($query)) {
    $row['subtotal'] = $row['jumlah'] * $row['harga'];
    $total_harga += $row['subtotal'];
    $keranjang[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pesanan Anda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php if (isset($_GET['success'])): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Pesanan Berhasil',
        text: 'Pesanan Anda telah berhasil diproses!',
        confirmButtonText: 'OK'
    });
</script>
<?php endif; ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">KulinerinAja</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="menu.php">Menu</a></li>
                <li class="nav-item"><a class="nav-link active" href="pesanan.php">Pesanan</a></li>
                <button type="button" class="btn btn-outline-danger ms-2" onclick="window.location.href='logout.php'">Logout</button>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Ringkasan Pesanan</h2>
    <hr>

    <?php if (empty($keranjang)): ?>
        <div class="alert alert-info text-center">Keranjang masih kosong. Silakan pilih makanan di <a href="menu.php">Menu</a>.</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nama Makanan</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($keranjang as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nama_makanan']); ?></td>
                    <td><?= $item['jumlah']; ?></td>
                    <td>Rp<?= number_format($item['harga'], 0, ',', '.'); ?></td>
                    <td>Rp<?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                    <td><strong>Rp<?= number_format($total_harga, 0, ',', '.'); ?></strong></td>
                </tr>
            </tbody>
        </table>

        <div class="text-end">
            <form action="proses_checkout.php" method="post">
                <button type="submit" class="btn btn-success">Checkout Sekarang</button>
            </form>
        </div>
    <?php endif; ?>
</div>

</body>
</html>

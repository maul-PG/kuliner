<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['id_user'];
$tanggal = date("Y-m-d");
$total_harga = 0;

$query = mysqli_query($conn, "
    SELECT k.id_menu, k.jumlah, m.harga
    FROM keranjang k
    JOIN menu_makanan m ON k.id_menu = m.id_menu
    WHERE k.id_user = '$id_user' AND k.status = 'pending'
");

$keranjang = [];
while ($row = mysqli_fetch_assoc($query)) {
    $subtotal = $row['jumlah'] * $row['harga'];
    $total_harga += $subtotal;
    $keranjang[] = [
        'id_menu' => $row['id_menu'],
        'jumlah' => $row['jumlah'],
        'harga' => $row['harga'],
        'subtotal' => $subtotal
    ];
}

$insertPesanan = mysqli_query($conn, "INSERT INTO pesanan (id_user, tanggal, total_harga) VALUES ('$id_user', '$tanggal', '$total_harga')");
if (!$insertPesanan) {
    die("Gagal menyimpan pesanan: " . mysqli_error($conn));
}

$id_pesanan = mysqli_insert_id($conn);

foreach ($keranjang as $item) {
    $id_menu = $item['id_menu'];
    $jumlah = $item['jumlah'];
    $subtotal = $item['subtotal'];

    mysqli_query($conn, "INSERT INTO detail_pesanan (id_pesanan, id_makanan, jumlah, subtotal)
                         VALUES ('$id_pesanan', '$id_menu', '$jumlah', '$subtotal')");

    mysqli_query($conn, "UPDATE menu_makanan SET jumlah_terjual = jumlah_terjual + $jumlah WHERE id_menu = '$id_menu'");
}

mysqli_query($conn, "UPDATE keranjang SET status = 'selesai' WHERE id_user = '$id_user' AND status = 'pending'");

echo '
<!DOCTYPE html>
<html>
<head>
    <title>Pesanan Berhasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .success-container {
            margin-top: 100px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container success-container">
        <h2 class="text-bold-dark">🎉 Pesanan Berhasil!</h2>
        <p>Terima kasih telah memesan. Silakan tunggu konfirmasi dari kami.</p>
        <a href="menu.php" class="btn btn-secondary mt-3">Kembali ke Menu</a>
        <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        Swal.fire({
            icon: "success",
            title: "Pesanan Berhasil",
            text: "Pesanan Anda telah berhasil diproses!",
            confirmButtonText: "OK"
        });
    </script>

    

</body>
</html>
';
exit();
?>

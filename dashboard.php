<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - KulinerinAja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">KulinerinAja</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="menu.php">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="pesanan.php">Pesanan</a></li>
                <button type="button" class="btn btn-outline-danger" onclick="window.location.href='logout.php'">Logout</button>
            </ul>
        </div>
    </div>
</nav>

<div class="p-5 mb-4 bg-body-tertiary rounded-3"> 
    <div class="container-fluid py-5">    
        <h2 class="display-5 fw-bold">Selamat Datang, <?= htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p class="col-md-8 fs-4">KulinerinAja hadir untuk memudahkan kamu menemukan dan memesan makanan favorit tanpa ribet. Yuk mulai jelajahi menunya!</p>
        <hr class="my-4">
        <p class="lead">Dengan KulinerinAja, kamu bisa menemukan berbagai pilihan makanan dari restoran terdekat dengan mudah.</p> 
        <a class="btn btn-primary btn-lg" href="menu.php" role="button">Lihat Menu</a>
    </div> 
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        Swal.fire({
            title: 'Welcome!',
            text: 'Enjoy your time with KulinerinAja',
            icon: 'success',
            confirmButtonText: 'Cool'
        });
    });
</script>

<footer class="text-center text-lg-start bg-light text-muted">
    <div class="text-center p-4">
        © 2025 KulinerinAja. All rights reserved.
    </div> 
</footer>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>

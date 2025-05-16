<?php
session_start();
if (isset($_SESSION['id_user'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>KulinerinAja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container col-xxl-8 px-4 py-5"> 
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5"> 
        <div class="col-10 col-sm-8 col-lg-6"> 
            <img src="img/makanan.png" class="d-block mx-lg-auto img-fluid" alt="makanan" width="700" height="500" loading="lazy"> 
        </div> 
        <div class="col-lg-6"> 
            <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">Makan aja dulu</h1> 
            <p class="lead"> 
                Aplikasi ini adalah aplikasi kuliner yang menyediakan berbagai menu makanan yang dapat dipesan secara online. 
                Anda dapat melihat daftar menu, melakukan pemesanan, dan melihat riwayat pesanan Anda.
            </p>
            <p class="lead"> 
                Silakan login atau daftar untuk memulai pengalaman kuliner Anda!
            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <a href="login.php" class="btn btn-outline-info btn-lg px-4 me-sm-3 fw-bold">LogIn</a>
                <a href="signup.php" class="btn btn-outline-secondary btn-lg px-4 fw-bold">SignUp</a>  
            </div> 
        </div> 
    </div> 
</div>
       
<footer class="text-center text-lg-start bg-light text-muted">
    <div class="text-center p-4">
        © 2025 KulinerinAja. All rights reserved.
    </div> 
</footer>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

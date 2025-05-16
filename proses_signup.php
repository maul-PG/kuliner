<?php
$conn = new mysqli("localhost", "root", "", "kuliner");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO user (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    echo "Berhasil daftar. <a href='login.php'>Login di sini</a>";
} else {
    echo "Gagal daftar: " . $conn->error;
}

$conn->close();
?>

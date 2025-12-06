<?php
session_start();
require "koneksi.php";

// AKTIFKAN ERROR AGAR TIDAK WHITE SCREEN
ini_set('display_errors', 1);
error_reporting(E_ALL);

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nama = $_POST["nama"];
    $password = $_POST["password"];

    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE nama='$nama' LIMIT 1");

    if (mysqli_num_rows($cek) === 1) {
        $row = mysqli_fetch_assoc($cek);

        // cek password
        if (password_verify($password, $row["password"])) {

            $_SESSION["nama"] = $row["nama"];
            $_SESSION["role"] = $row["role"];

            if ($row["role"] === "admin") {
                header("Location: admin.php");
                exit;
            } else {
                header("Location: index.php");
                exit;
            }

        } else {
            $error = "Password salah!";
        }

    } else {
        $error = "Nama tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1"> <!-- MOBILE FRIENDLY -->
<title>Login</title>

<!-- BOOTSTRAP -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    font-family: Arial;
    background: #f5e6d3;
    min-height: 100vh;
}

/* Box login lebih fleksibel di HP */
.login-box {
    background: white;
    padding: 25px;
    border-radius: 15px;
    width: 100%;
    max-width: 390px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

/* Input lebih besar & nyaman disentuh */
input {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    border-radius: 8px;
}

button {
    width: 100%;
    padding: 14px;
    margin-top: 15px;
    background: #9c6f45;
    color: white;
    border: none;
    font-weight: bold;
    border-radius: 8px;
    font-size: 16px;
}
button:hover {
    background: #7a5434;
}

.error {
    margin-top: 12px;
    color: red;
    font-size: 14px;
}

/* Tambahan responsif untuk layar sangat kecil (HP jadul) */
@media (max-width: 350px) {
    .login-box {
        padding: 20px;
        max-width: 95%;
    }
}
</style>
</head>

<body class="d-flex justify-content-center align-items-center">

<div class="login-box">

    <h4 class="text-center mb-3">Silahkan Login terlebih dahulu ya!</h4>

    <?php if ($error) : ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Nama</label>
        <input type="text" name="nama" required class="form-control">

        <label>Password</label>
        <input type="password" name="password" required class="form-control">

        <button type="submit">Masuk</button>
    </form>
</div>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

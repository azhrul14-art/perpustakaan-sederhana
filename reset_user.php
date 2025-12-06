<?php
require "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = $_POST["nama"];
    $new_pass = password_hash($_POST["password"], PASSWORD_BCRYPT);

    mysqli_query($koneksi, "UPDATE users SET password='$new_pass' WHERE nama='$nama'");

    $msg = "Password untuk $nama berhasil direset!";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reset Password User</title>
<style>
body { font-family: Arial; background: #f5e6d3; padding: 40px; }
.box {
    background: white; padding: 20px; max-width: 400px; margin: auto;
    border-radius: 10px; box-shadow: 0 3px 8px rgba(0,0,0,0.2);
}
input, button { width: 100%; padding: 10px; margin-top: 10px; }
button { background: #9c6f45; color: white; border: none; border-radius: 5px; }
button:hover { background: #7a5434; }
</style>
</head>

<body>

<div class="box">
    <h2>Reset Password</h2>

    <?php if (!empty($msg)) echo "<p>$msg</p>"; ?>

    <form method="POST">
        <label>Nama User</label>
        <input type="text" name="nama" required>

        <label>Password Baru</label>
        <input type="password" name="password" required>

        <button type="submit">Reset</button>
    </form>
</div>

</body>
</html>

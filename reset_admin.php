<?php
require 'koneksi.php';
// new password plain:
$new = 'admin123';
// generate hash (bcrypt)
$hash = password_hash($new, PASSWORD_DEFAULT);
$sql = "UPDATE users SET password = ? WHERE nama = 'admin'";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "s", $hash);
if(mysqli_stmt_execute($stmt)){
    echo "Password admin di-reset. Hash: $hash";
} else {
    echo "Gagal: ".mysqli_error($koneksi);
}
?>

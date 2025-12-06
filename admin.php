<?php
session_start();
require "koneksi.php";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit;
}

// ================== TAMBAH BUKU ==================
if (isset($_POST["tambah"])) {

    $judul = $_POST["judul"];
    $penulis = $_POST["penulis"];
    $kategori = $_POST["kategori"];
    $deskripsi = $_POST["deskripsi"];

    // upload cover
    $file = $_FILES["cover"]["name"];
    $tmp = $_FILES["cover"]["tmp_name"];
    $path = "img/" . $file;
    move_uploaded_file($tmp, $path);

    // upload PDF
    $pdf = $_FILES["file_pdf"]["name"];
    $tmpPdf = $_FILES["file_pdf"]["tmp_name"];
    $pathPdf = "pdf/" . $pdf;
    move_uploaded_file($tmpPdf, $pathPdf);

    mysqli_query($koneksi, 
        "INSERT INTO books (judul, penulis, kategori, cover, deskripsi, file_pdf)
         VALUES ('$judul','$penulis','$kategori','$path','$deskripsi','$pathPdf')"
    );
    header("Location: admin.php");
    exit;
}

// ================== HAPUS BUKU ==================
if (isset($_GET["hapus"])) {
    $id = $_GET["hapus"];
    mysqli_query($koneksi, "DELETE FROM books WHERE id=$id");
    header("Location: admin.php");
    exit;
}

// ================== AMBIL DATA UNTUK EDIT ==================
$editData = null;
if (isset($_GET["edit"])) {
    $id = $_GET["edit"];
    $result = mysqli_query($koneksi, "SELECT * FROM books WHERE id=$id");
    $editData = mysqli_fetch_assoc($result);
}

// ================== UPDATE BUKU ==================
if (isset($_POST["update"])) {
    $id = $_POST["id"];
    $judul = $_POST["judul"];
    $penulis = $_POST["penulis"];
    $kategori = $_POST["kategori"];
    $deskripsi = $_POST["deskripsi"];

    $updatePdf = "";
    $updateCover = "";

    // Jika upload cover baru
    if (!empty($_FILES["cover"]["name"])) {
        $file = $_FILES["cover"]["name"];
        $tmp = $_FILES["cover"]["tmp_name"];
        $path = "img/" . $file;
        move_uploaded_file($tmp, $path);
        $updateCover = ", cover='$path'";
    }

    // Jika upload PDF baru
    if (!empty($_FILES["file_pdf"]["name"])) {
        $pdf = $_FILES["file_pdf"]["name"];
        $tmpPdf = $_FILES["file_pdf"]["tmp_name"];
        $pathPdf = "pdf/" . $pdf;
        move_uploaded_file($tmpPdf, $pathPdf);
        $updatePdf = ", file_pdf='$pathPdf'";
    }

    mysqli_query($koneksi, 
        "UPDATE books SET 
            judul='$judul',
            penulis='$penulis',
            kategori='$kategori',
            deskripsi='$deskripsi'
            $updateCover
            $updatePdf
         WHERE id=$id"
    );

    header("Location: admin.php");
    exit;
}

$books = mysqli_query($koneksi, "SELECT * FROM books ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Panel Admin</title>

<style>
body {
    font-family: Arial;
    background: #f5e6d3;
    padding: 20px;
}
h2 { color: #6b4728; }
.container { display: flex; gap: 30px; }
.form-box {
    background: white;
    padding: 20px;
    border-radius: 12px;
    width: 48%;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
    height: fit-content;
    max-height: 550px;
}
.book-list {
    background: white;
    padding: 20px;
    border-radius: 12px;
    width: 48%;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
}
input, textarea {
    width: 100%;
    padding: 10px;
    margin-top: 8px;
}
button {
    padding: 12px;
    background: #9c6f45;
    color: white;
    border: none;
    margin-top: 15px;
    width: 100%;
    border-radius: 6px;
    cursor: pointer;
}
button:hover { background: #7a5434; }
.book { display: flex; gap: 20px; padding: 15px; border-bottom: 1px solid #ddd; }
.book img {
    width: 90px;
    height: 130px;
    object-fit: cover;
    border-radius: 6px;
}
.delete {
    color: red;
    font-size: 14px;
    text-decoration: none;
    margin-right: 10px;
}
.edit {
    color: #9c6f45;
    font-size: 14px;
    text-decoration: none;
}
.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}
.btn-logout {
    background-color: #9c6f45;
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s ease;
    border: 2px solid #9c6f45;
}
.btn-logout:hover {
    background-color: #f5e6d3;
    color: #9c6f45;
}
</style>
</head>

<body>

<div class="admin-header">
    <h2>SELAMAT DATANG, ADMIN :)</h2>
    <a href="logout.php" class="btn-logout">Logout</a>
</div>
<hr><br>

<div class="container">

    <!-- FORM TAMBAH / EDIT -->
    <div class="form-box">

        <?php if ($editData): ?>
            <h3>Edit Buku</h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $editData['id'] ?>">

                <label>Judul</label>
                <input type="text" name="judul" value="<?= $editData['judul'] ?>" required>

                <label>Penulis</label>
                <input type="text" name="penulis" value="<?= $editData['penulis'] ?>">

                <label>Kategori</label>
                <input type="text" name="kategori" value="<?= $editData['kategori'] ?>">

                <label>Cover Baru (opsional)</label>
                <input type="file" name="cover">

                <label>File PDF Baru (opsional)</label>
                <input type="file" name="file_pdf">

                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="4"><?= $editData['deskripsi'] ?></textarea>

                <button type="submit" name="update">Update Buku</button>
            </form>

        <?php else: ?>
            <h3>Tambah Buku</h3>
            <form method="POST" enctype="multipart/form-data">

                <label>Judul</label>
                <input type="text" name="judul" required>

                <label>Penulis</label>
                <input type="text" name="penulis">

                <label>Kategori</label>
                <input type="text" name="kategori">

                <label>Cover Buku</label>
                <input type="file" name="cover" required>

                <label>File PDF Buku</label>
                <input type="file" name="file_pdf" required>

                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="4"></textarea>

                <button type="submit" name="tambah">Tambah</button>
            </form>
        <?php endif; ?>

    </div>

    <!-- LIST BUKU -->
    <div class="book-list">
        <h3>Daftar Buku</h3>

        <?php while ($row = mysqli_fetch_assoc($books)): ?>
        <div class="book">
            <img src="<?= $row['cover'] ?>">
            <div>
                <b><?= $row['judul'] ?></b><br>
                <small><?= $row['penulis'] ?></small><br>
                <small><?= $row['kategori'] ?></small><br><br>

                <a class="edit" href="admin.php?edit=<?= $row['id'] ?>">Edit</a> | 
                <a class="delete" href="admin.php?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus buku ini?')">Hapus</a>
            </div>
        </div>
        <?php endwhile; ?>

    </div>

</div>

</body>
</html
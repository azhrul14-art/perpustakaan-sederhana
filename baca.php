<?php
// Pastikan parameter file ada
if (!isset($_GET['file']) || empty($_GET['file'])) {
    die("File buku tidak ditemukan.");
}

$file = basename($_GET['file']); // keamanan: mencegah akses luar folder
$path = "uploads/" . $file;

// Cek apakah file benar-benar ada
if (!file_exists($path)) {
    die("File PDF tidak ditemukan di server.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Baca Buku</title>
    <style>
        body {
            margin: 0;
            background: #f5e6d3;
            font-family: Arial, sans-serif;
        }
        .pdf-viewer {
            width: 100%;
            height: 100vh;
            border: none;
        }
        .top-bar {
            background: #9c6f45;
            color: #fff;
            padding: 10px 16px;
            font-weight: bold;
        }
        .back {
            color: #fff;
            text-decoration: none;
            margin-right: 20px;
        }
    </style>
</head>
<body>

<div class="top-bar">
    <a class="back" href="javascript:history.back()">← Kembali</a>
    Mode Baca Buku (PDF)
</div>

<iframe src="<?= $path ?>" class="pdf-viewer"></iframe>

</body>
</html>

<?php
require "koneksi.php";

if (!isset($_GET['file'])) {
    die("File tidak ditemukan.");
}

$filename = basename($_GET['file']);
$filepath = "uploads/" . $filename;

if (!file_exists($filepath)) {
    die("File tidak tersedia di server: " . $filepath);
}

header("Content-Description: File Transfer");
header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=\"" . basename($filepath) . "\"");
header("Content-Length: " . filesize($filepath));
readfile($filepath);
exit;
?>

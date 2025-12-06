<?php
session_start();
require "koneksi.php";

// Ambil filter
$search   = $_GET['search'] ?? '';
$kategori = $_GET['kategori'] ?? '';

$query = "SELECT * FROM books WHERE 1";

if (!empty($search)) {
    $query .= " AND (judul LIKE '%$search%' OR penulis LIKE '%$search%')";
}

if (!empty($kategori)) {
    $query .= " AND kategori = '$kategori'";
}

$query .= " ORDER BY id DESC";
$buku = mysqli_query($koneksi, $query);

// Ambil kategori
$kategori_q = mysqli_query($koneksi, "SELECT DISTINCT kategori FROM books");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Daftar Buku</title>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Arial, sans-serif;
}

body {
    background: linear-gradient(135deg, #f5e6d3, #e7c9a5);
    padding: 15px;
}

/* ===== Header ===== */
.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
}

.left-controls {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* Welcome */
.welcome-text {
    font-size: 18px;
    font-weight: bold;
    color: #5a3c1f;
}

/* Form */
.filter-form {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.filter-form input,
.filter-form select {
    padding: 10px 15px;
    border-radius: 14px;
    border: 1px solid #d2b48c;
    background: #fff8ee;
    font-weight: bold;
    outline: none;
}

.filter-form button {
    padding: 10px 18px;
    border-radius: 14px;
    border: none;
    background: linear-gradient(135deg, #9c6f45, #b8860b);
    color: white;
    font-weight: bold;
    cursor: pointer;
}

/* Logout */
.btn-logout {
    background: #5a3c1f;
    color: white;
    padding: 10px 18px;
    border-radius: 14px;
    text-decoration: none;
    font-weight: bold;
    transition: 0.2s ease;
    white-space: nowrap;
}

.btn-logout:hover {
    background: #b8860b;
}

/* ================================ */
/*   FIX: GRID TIDAK MELEBAR        */
/* ================================ */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 18px;
    justify-items: center; /* BIAR CARD TIDAK MELEBAR SAAT HASIL 1 */
}

/* Card */
.card {
    background: #fffdfa;
    border-radius: 22px;
    padding: 14px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
    transition: 0.2s ease;

    width: 100%;
    max-width: 230px;  /* 🔥 FIX UTAMA BIAR TIDAK MELEBAR */
}

.card:hover {
    transform: translateY(-4px);
}

.card img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 16px;
}

/* Title */
.book-title {
    margin-top: 10px;
    font-size: 16px;
    font-weight: bold;
}

.book-title a {
    text-decoration: none;
    color: #4b2e12;
}

.book-title a:hover {
    color: #b8860b;
}

/* Info */
.book-info {
    font-size: 13px;
    margin-top: 6px;
    color: #6b4a2b;
}

/* Rating */
.rating {
    margin-top: 6px;
    font-size: 14px;
    font-weight: bold;
    color: #b8860b;
}

/* Desc */
.desc {
    font-size: 13px;
    margin-top: 6px;
    color: #5a4328;
    line-height: 1.4;
}

.book-actions {
    display: flex;
    justify-content: center;
    margin-top: 12px;
}

.btn-detail:hover {
    background: linear-gradient(135deg, #b8860b, #9c6f45);
}

/* Responsive */
@media (max-width: 600px) {
    .header {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-form input,
    .filter-form select,
    .filter-form button {
        width: 100%;
    }

    .card {
        max-width: 200px;
    }

    .card img {
        height: 200px;
    }
}
</style>
</head>

<body>

<!-- ===== HEADER ===== -->
<div class="header">

    <div class="left-controls">
        <div class="welcome-text">
            👋 Selamat datang, <?= htmlspecialchars($_SESSION['nama'] ?? 'User') ?>
        </div>

        <form method="get" class="filter-form">
            <input 
                type="text" 
                name="search" 
                placeholder="Cari judul / penulis..."
                value="<?= htmlspecialchars($search) ?>"
            >

            <select name="kategori">
                <option value="">Semua Kategori</option>
                <?php while($kat = mysqli_fetch_assoc($kategori_q)): ?>
                    <option value="<?= $kat['kategori'] ?>" 
                        <?= ($kategori == $kat['kategori']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($kat['kategori']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <button type="submit">Cari</button>
        </form>
    </div>

    <a href="logout.php" class="btn-logout">Logout</a>
</div>

<!-- ===== GRID BUKU ===== -->
<div class="grid">

<?php while($row = mysqli_fetch_assoc($buku)): ?>
<?php
$id_buku = $row['id'];
$rating_q = mysqli_query($koneksi,
    "SELECT AVG(rating) as avg_rating FROM reviews WHERE book_id = $id_buku"
);
$rating_data = mysqli_fetch_assoc($rating_q);
$avg_rating = $rating_data['avg_rating'];
?>

<div class="card">
    <img src="<?= htmlspecialchars($row['cover']) ?>" alt="Cover">

    <div class="book-title">
        <a href="detail.php?id=<?= $row['id'] ?>">
            <?= htmlspecialchars($row['judul']) ?>
        </a>
    </div>

    <div class="book-info">
        ✍️ <?= htmlspecialchars($row['penulis']) ?><br>
        🏷️ <?= htmlspecialchars($row['kategori']) ?>
    </div>

    <div class="rating">
        ⭐ <?= $avg_rating ? number_format($avg_rating, 1) : 'Belum ada rating' ?>
    </div>

    <div class="desc">
        <?= substr(strip_tags($row['deskripsi']), 0, 80) ?>...
    </div>

</div>

<?php endwhile; ?>

</div>

</body>
</html>

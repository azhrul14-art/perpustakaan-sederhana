<?php
session_start();
require "koneksi.php";

// Pastikan ada id
if (!isset($_GET['id'])) {
    die("Buku tidak ditemukan.");
}

$book_id = (int) $_GET['id'];

// Proses simpan review (komentar + rating)
if (isset($_POST['kirim_review'])) {
    $nama = mysqli_real_escape_string($koneksi, trim($_POST['nama'] ?? ''));
    $komentar = mysqli_real_escape_string($koneksi, trim($_POST['komentar'] ?? ''));
    $rating = (int)($_POST['rating'] ?? 0);

    if ($nama !== '' && $komentar !== '' && $rating >= 1 && $rating <= 5) {
        mysqli_query($koneksi,
            "INSERT INTO reviews (book_id, nama, komentar, rating, created_at)
             VALUES ($book_id, '$nama', '$komentar', $rating, NOW())"
        );
        // Redirect agar form tidak tersubmit ulang bila direfresh
        header("Location: detail.php?id=$book_id");
        exit;
    }
}

// Ambil data buku
$book_q = mysqli_query($koneksi, "SELECT * FROM books WHERE id = $book_id");
$data = mysqli_fetch_assoc($book_q);

if (!$data) {
    die("Buku tidak ditemukan.");
}

// Ambil rating rata-rata dari tabel reviews
$rating_q = mysqli_query($koneksi, "SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews FROM reviews WHERE book_id = $book_id");
$rating_data = mysqli_fetch_assoc($rating_q);
$avg_rating = $rating_data['avg_rating'];
$total_reviews = $rating_data['total_reviews'] ?? 0;

// Ambil komentar / review
$reviews = mysqli_query($koneksi, "SELECT * FROM reviews WHERE book_id=$book_id ORDER BY id DESC");

// Ambil 3 rekomendasi acak (exclude current)
$rekomendasi = mysqli_query($koneksi,
    "SELECT id, judul, penulis, cover FROM books WHERE id != $book_id ORDER BY RAND() LIMIT 3"
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($data['judul'] ?? 'Detail Buku') ?></title>

<style>
/* --- Warna & gaya sesuai tema golden brown --- */
* { box-sizing: border-box; margin:0; padding:0; font-family: Arial, sans-serif; }
body { background: #fdf8f3; color: #4b2e1e; padding: 18px; }
.container { max-width: 920px; margin: 16px auto; background: #fff; padding: 22px; border-radius: 16px; box-shadow: 0 6px 16px rgba(0,0,0,0.08); }

/* Tombol kembali */
.btn-back {
    position: fixed;
    top: 16px;
    left: 16px;
    background: linear-gradient(135deg, #b8860b, #8b5e34);
    color: #fff;
    padding: 10px 16px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: bold;
    z-index: 999;
    transition: .18s;
}
.btn-back:hover { transform: translateY(-2px); }

/* Detail layout */
.book-detail { display: flex; gap: 20px; flex-wrap: wrap; align-items: flex-start; }
.book-detail img { width: 100%; max-width: 210px; border-radius: 14px; object-fit: cover; }
.book-info { flex:1; min-width:260px; }
.book-info h1 { font-size: 24px; margin-bottom: 8px; color:#3e2717; }
.book-meta { font-size: 14px; margin-bottom: 8px; color:#5a3c1f; }
.book-desc { margin-top: 10px; line-height: 1.6; color:#5a4328; }

/* rating */
.rating-box { margin-top:10px; color:#c89b3c; font-weight:bold; font-size:16px; }

/* tombol aksi */
.btn { display:inline-block; margin-top:10px; padding:10px 16px; border-radius:12px; text-decoration:none; color:#fff; background:#8b5e34; transition:.15s; }
.btn:hover { background:#6f4424; }

/* rekomendasi */
.section-title { font-size:18px; font-weight:bold; margin-top:28px; color:#5a3c1f; display:flex; align-items:center; gap:10px; }
.book-list { display:flex; gap:14px; margin-top:12px; flex-wrap:wrap; }
.book-card { width:180px; background:#fffdfa; border-radius:14px; padding:8px; box-shadow:0 6px 14px rgba(0,0,0,0.04); text-align:center; }
.book-card img { width:100%; height:220px; object-fit:cover; border-radius:10px; }

/* komentar */
.comment-section { margin-top:28px; }
.comment-form { background:#fff8f1; padding:14px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.03); }
.comment-form input, .comment-form textarea, .comment-form select { width:100%; padding:10px; margin-top:10px; border-radius:10px; border:1px solid #ddd; }
.comment-form textarea { height:90px; resize:vertical; }
.comment-form button { margin-top:10px; padding:10px 16px; border-radius:10px; border:none; background:#9c6f45; color:#fff; cursor:pointer; }
.comment-form button:hover { background:#7d5635; }

.comment-list { margin-top:14px; display:flex; flex-direction:column; gap:12px; }
.comment-card { background:#fff; padding:12px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.04); }
.comment-name { font-weight:bold; color:#5a3c1f; margin-bottom:6px; }
.comment-text { color:#444; line-height:1.5; }

@media (max-width:640px){
    .book-detail { flex-direction:column; align-items:center; text-align:center; }
    .book-info { text-align:left; }
    .book-card img { height:180px; }
}
</style>
</head>
<body>

<a class="btn-back" href="index.php">← Kembali</a>

<div class="container">

    <!-- DETAIL BUKU -->
    <div class="book-detail">
        <img src="<?= htmlspecialchars($data['cover'] ?? ''); ?>" alt="Cover Buku">
        <div class="book-info">
            <h1><?= htmlspecialchars($data['judul'] ?? '-') ?></h1>

            <div class="book-meta">
                <div><strong>Penulis:</strong> <?= htmlspecialchars($data['penulis'] ?? '-') ?></div>
                
            </div>

            <div class="rating-box">
                <?= $avg_rating ? "⭐ " . number_format($avg_rating,1) . " — ({$total_reviews} ulasan)" : "⭐ Belum ada rating" ?>
            </div>

            <div class="book-desc">
                <?= nl2br(htmlspecialchars($data['deskripsi'] ?? '-')) ?>
            </div>

            <!-- Tombol baca / download: gunakan field file_pdf bila tersedia -->
            <div>
                <?php if (!empty($data['file_pdf'])): ?>
                    <a class="btn" href="baca.php?file=<?= urlencode($data['file_pdf']) ?>" target="_blank">📖 Baca Buku</a>
                    <a class="btn" href="download.php?file=<?= urlencode($data['file_pdf']) ?>" style="background:#5a3c1f; margin-left:8px;">⬇️ Download PDF</a>
                <?php else: ?>
                    <div style="margin-top:12px; color:#9a8b7a;">File buku tidak tersedia</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- REKOMENDASI -->
    <div>
        <div class="section-title">📚 Rekomendasi Buku Lainnya</div>
        <div class="book-list">
            <?php if (mysqli_num_rows($rekomendasi) > 0): ?>
                <?php while ($r = mysqli_fetch_assoc($rekomendasi)): ?>
                    <div class="book-card">
                        <a href="detail.php?id=<?= $r['id'] ?>" style="text-decoration:none;color:inherit;">
                            <img src="<?= htmlspecialchars($r['cover']) ?>" alt="Cover">
                            <div style="margin-top:8px; font-weight:700; color:#3e2717;"><?= htmlspecialchars($r['judul']) ?></div>
                            <div style="font-size:13px; color:#6b4a2b; margin-top:6px;"><?= htmlspecialchars($r['penulis']) ?></div>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div style="color:#888;">Tidak ada rekomendasi.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- KOMENTAR & RATING -->
    <div class="comment-section">
        <div class="section-title" style="margin-top:18px;">💬 Komentar & Rating</div>

        <form method="post" class="comment-form">
            <input type="text" name="nama" placeholder="Nama kamu..." required>
            <textarea name="komentar" placeholder="Tulis komentarmu..." required></textarea>
            <select name="rating" required>
                <option value="">-- Beri Rating --</option>
                <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                <option value="4">⭐⭐⭐⭐ (4)</option>
                <option value="3">⭐⭐⭐ (3)</option>
                <option value="2">⭐⭐ (2)</option>
                <option value="1">⭐ (1)</option>
            </select>
            <button type="submit" name="kirim_review">Kirim</button>
        </form>

        <div class="comment-list">
            <?php if (mysqli_num_rows($reviews) > 0): ?>
                <?php while ($c = mysqli_fetch_assoc($reviews)): ?>
                    <div class="comment-card">
                        <div class="comment-name"><?= htmlspecialchars($c['nama']) ?> · <span style="font-size:12px;color:#999; font-weight:normal;"><?= htmlspecialchars($c['created_at'] ?? '') ?></span></div>
                        <div class="comment-text"><?= nl2br(htmlspecialchars($c['komentar'])) ?></div>
                        <div style="margin-top:8px; color:#c89b3c; font-weight:bold;">⭐ <?= intval($c['rating']) ?>/5</div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div style="color:#888;">Belum ada komentar.</div>
            <?php endif; ?>
        </div>
    </div>

</div>

</body>
</html>

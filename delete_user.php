<?php
include('./template/head.php');
include('./config/database_connection.php');

// Validasi ID dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Redirect jika user tidak ditemukan
if (!$user) {
    header('Location: index.php');
    exit;
}

// Proses hapus jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deleteSql = "DELETE FROM users WHERE id = ?";
    $deleteStmt = $db->prepare($deleteSql);
    if ($deleteStmt->execute([$id])) {
        echo "<script>alert('Data berhasil dihapus'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data'); window.location='index.php';</script>";
    }
    exit;
}
?>

<!-- 🎀 CSS PINK THEME -->
<style>
    body {
        background-color: #ffe6f0;
    }
    .delete-box {
        background-color: #fff0f5;
        border-radius: 10px;
        padding: 40px;
        box-shadow: 0 0 10px rgba(255, 105, 180, 0.3);
        margin-top: 80px;
    }
    .delete-box h4 {
        color: #d63384;
        margin-bottom: 30px;
    }
    .btn-success {
        background-color: #ff69b4;
        border-color: #ff69b4;
    }
    .btn-success:hover {
        background-color: #ff85c1;
        border-color: #ff85c1;
    }
    .btn-danger {
        background-color: #ff4d6d;
        border-color: #ff4d6d;
    }
    .btn-danger:hover {
        background-color: #ff5f7e;
        border-color: #ff5f7e;
    }
</style>

<!-- 💬 Konfirmasi Penghapusan -->
<div class="container delete-box text-center">
    <h4>Apakah Anda yakin ingin menghapus data berikut?</h4>
    <p><strong>Nama:</strong> <?= htmlspecialchars($user['name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <button type="submit" class="btn btn-success">✓ Ya, Hapus</button>
        <a href="index.php" class="btn btn-danger">✗ Batal</a>
    </form>
</div>

<?php include('./template/foot.php');
 ?>
<?php
include('./template/head.php');
include('./config/database_connection.php');

// Fungsi untuk mengecek apakah email tersedia
function isEmailAvailable($db, $email){
    $stmt = $db->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->rowCount() === 0;
}

$errors = [];
$name = '';
$email = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validasi
    if ($name === "") $errors['name'] = "Nama tidak boleh kosong";
    if ($email === "") $errors['email'] = "Email tidak boleh kosong";
    if ($password === "") $errors['password'] = "Password tidak boleh kosong";

    if (!$errors) {
        if (isEmailAvailable($db, $email)) {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $stmt = $db->prepare($sql);
            $saved = $stmt->execute([$name, $email, $hashPassword]);

            if ($saved) {
                echo "<script>alert('Data berhasil disimpan'); window.location.href='index.php';</script>";
                exit;
            } else {
                echo "<div class='alert alert-danger'>Gagal menyimpan data.</div>";
            }
        } else {
            $errors['email'] = "Email <strong>" . htmlspecialchars($email) . "</strong> sudah digunakan.";
        }
    }
}
?>
<style>
    body {
        background-color:rgb(252, 226, 250);
    }
    .card-header {
        background-color:rgb(225, 173, 230) !important;
    }
    .btn-success {
        background-color:rgb(248, 107, 236);
        border-color:rgb(255, 105, 223);
    }
    .btn-secondary {
        background-color:rgb(255, 192, 241);
        border-color: rgb(255,192,241);
        color: #333;
    }
    .btn-success:hover,
    .btn-secondary:hover {
        opacity: 0.9;
    }
    .form-control:focus {
        border-color:rgb(201, 134, 207);
        box-shadow: 0 0 0 0.2rem rgba(255, 105, 180, 0.25);
    }
</style>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-white">
                    <h4 class="mb-0">Tambah Data User</h4>
                </div>
                <div class="card-body">

                    <form method="POST">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input name="name" type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" id="name" value="<?= htmlspecialchars($name) ?>">
                            <?php if (isset($errors['name'])): ?>
                                <div class="invalid-feedback"><?= $errors['name'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" value="<?= htmlspecialchars($email) ?>">
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= $errors['email'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input name="password" type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" id="password">
                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback"><?= $errors['password'] ?></div>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-success btn-block">💾 Simpan</button>
                        <a href="index.php" class="btn btn-secondary btn-block">← Kembali</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include('./template/foot.php'); ?>
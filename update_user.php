<?php
include('./template/head.php');
include('./config/database_connection.php');

// Fungsi cek email apakah masih tersedia
function isEmailAvailable($db, $email, $userID)
{
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt->execute([$email, $userID]);
    return $stmt->rowCount() === 0;
}

$errors = [];
$user = [
    'name' => '',
    'email' => '',
];

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];

// Ambil data user berdasarkan ID
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($name === "") $errors['name'] = "Nama tidak boleh kosong";
    if ($email === "") $errors['email'] = "Email tidak boleh kosong";

    if (!$errors) {
        if (isEmailAvailable($db, $email, $id)) {
            if (!empty($password)) {
                $hashPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?";
                $params = [$name, $email, $hashPassword, $id];
            } else {
                $sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
                $params = [$name, $email, $id];
            }

            $stmt = $db->prepare($sql);
            if ($stmt->execute($params)) {
                echo "<script>alert('Data berhasil diperbarui'); window.location='index.php';</script>";
                exit;
            } else {
                $errors['general'] = "Gagal memperbarui data.";
            }
        } else {
            $errors['email'] = "Email <strong>" . htmlspecialchars($email) . "</strong> sudah digunakan.";
        }
    }

    // Update form values in case of validation failure
    $user['name'] = $name;
    $user['email'] = $email;
}
?>
<style>
    body {
        background-color:rgb(254, 230, 255);
    }
    .card-header {
        background-color:rgb(255, 105, 248);
        color: white;
    }
    .btn-success {
        background-color:rgb(255, 105, 248);
        border-color:rgb(255, 105, 255);
    }
    .btn-success:hover {
        background-color:rgb(231, 133, 255);
    }
    .form-control:focus {
        border-color:rgb(225, 105, 255);
        box-shadow: 0 0 0 0.2rem rgba(255, 105, 180, 0.25);
    }
</style>

<!-- 💻 Form Update -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="mb-0">Update Data User</h4>
                </div>
                <div class="card-body">
                    <?php foreach ($errors as $error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endforeach; ?>

                    <form method="POST">
                        <div class="form-group mb-3">
                            <label for="name">Nama</label>
                            <input name="name" type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" id="name" value="<?= htmlspecialchars($user['name']) ?>">
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input name="email" type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" value="<?= htmlspecialchars($user['email']) ?>">
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Password (Kosongkan jika tidak diubah)</label>
                            <input name="password" type="password" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success btn-block">Simpan</button>
                        <a href="index.php" class="btn btn-secondary btn-block">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('./template/foot.php');
?>
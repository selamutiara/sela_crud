<?php
include('./template/head.php');
include('./config/database_connection.php');

function getAllUser($db) {
    $sql = "SELECT * FROM users";
    return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

$users = getAllUser($db);
?>

<!-- Tambahkan Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        background: linear-gradient(to right, #ffe0f0, #f3c6f9);
        font-family: 'Segoe UI', sans-serif;
    }

    .card-custom {
        border: none;
        border-radius: 16px;
        box-shadow: 0 12px 30px rgba(243, 105, 255, 0.2);
        background-color: #fff;
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(90deg, #f36aff, #ff92dd);
        padding: 20px 30px;
        text-align: center;
    }

    .card-header h4 {
        color: #fff;
        font-weight: 700;
        margin: 0;
    }

    .table th, .table td {
        vertical-align: middle !important;
        text-align: center;
    }

    .table thead {
        background-color: #fca5f1;
        color: white;
        font-weight: 600;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #fff0fa;
    }

    .btn {
        border-radius: 8px;
        font-size: 14px;
        padding: 6px 12px;
    }

    .btn-edit {
        background-color: #da6af9;
        color: white;
    }

    .btn-delete {
        background-color: #f9a6c4;
        color: white;
    }

    .btn-edit:hover,
    .btn-delete:hover {
        opacity: 0.9;
    }

    .action-buttons .btn {
        margin: 2px;
    }

    .table-container {
        max-height: 500px;
        overflow-y: auto;
    }

    .btn-outline-primary, .btn-outline-secondary {
        padding: 8px 16px;
        border-radius: 8px;
    }

    .table td.password {
        font-family: monospace;
        font-size: 13px;
        color: #555;
    }
</style>

<div class="container py-5">
    <div class="card card-custom">
        <div class="card-header">
            <h4><i class="bi bi-people-fill me-2"></i>Daftar Pengguna</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive table-container">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)) : ?>
                            <?php $no = 1; foreach ($users as $user) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($user['name']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td class="password"><?= htmlspecialchars($user['password']) ?></td>
                                    <td class="action-buttons">
                                        <a href="update_user.php?id=<?= $user['id'] ?>" class="btn btn-edit" title="Edit"><i class="bi bi-pencil-square"></i> Edit</a>
                                        <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                            <i class="bi bi-trash-fill"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada data pengguna</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <a href="create_user.php" class="btn btn-outline-primary me-2"><i class="bi bi-plus-circle"></i> Tambah Pengguna</a>
                <a href="cetak.php" class="btn btn-outline-secondary" target="_blank"><i class="bi bi-printer"></i> Cetak</a>
            </div>
        </div>
    </div>
</div>

<?php include('./template/foot.php'); ?>

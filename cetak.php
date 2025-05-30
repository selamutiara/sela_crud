<?php
include('./config/database_connection.php');

function getAllUser($db) {
    $sql = "SELECT * FROM users";
    return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

$users = getAllUser($db);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Daftar Pengguna</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            color: #000;
            background: #fff;
            margin: 40px;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            color: #444;
            margin-bottom: 10px;
        }

        .line {
            width: 100%;
            height: 2px;
            background: #f1c6fa;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #999;
            padding: 8px 10px;
            text-align: center;
        }

        th {
            background-color: #f7d5fc;
            color: #333;
        }

        tbody tr:nth-child(even) {
            background-color: #fef6ff;
        }

        .footer {
            margin-top: 40px;
            font-size: 12px;
            text-align: right;
            color: #777;
        }

        .no-print {
            text-align: center;
            margin-top: 30px;
        }

        .no-print button,
        .no-print a {
            background: #f3b4ff;
            color: #000;
            border: none;
            padding: 10px 16px;
            margin: 5px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
        }

        .no-print button:hover,
        .no-print a:hover {
            background: #e39df9;
        }

        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <h2>📋 Daftar Pengguna</h2>
    <div class="line"></div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pengguna</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($users)) : ?>
            <?php $no = 1; foreach ($users as $user): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="3">Tidak ada data pengguna</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: <?= date('d-m-Y H:i') ?>
    </div>

    <div class="no-print">
        <button onclick="window.print()">🖨 Cetak Halaman Ini</button>
        <a href="javascript:window.close()">Tutup</a>
    </div>

</body>
</html>

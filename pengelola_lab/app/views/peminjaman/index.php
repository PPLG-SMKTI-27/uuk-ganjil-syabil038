<!DOCTYPE html>
<html>
<head>
    <title>Data Peminjaman</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 5px 10px; text-decoration: none; border: none; cursor: pointer; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-warning { background: #ffc107; color: black; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .success { color: green; padding: 10px; background: #d4edda; }
        .error { color: red; padding: 10px; background: #f8d7da; }
        .status-pending { color: #856404; background: #fff3cd; padding: 3px 8px; border-radius: 3px; }
        .status-disetujui { color: #155724; background: #d4edda; padding: 3px 8px; border-radius: 3px; }
        .status-ditolak { color: #721c24; background: #f8d7da; padding: 3px 8px; border-radius: 3px; }
        .status-dikembalikan { color: #0c5460; background: #d1ecf1; padding: 3px 8px; border-radius: 3px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Data Peminjaman</h2>
        <div>
            <a href="index.php?action=dashboard" class="btn">Dashboard</a>
            <a href="index.php?action=peminjaman&subaction=create" class="btn btn-primary">Ajukan Peminjaman</a>
            <a href="index.php?action=logout" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <?php if ($_SESSION['user']['nama_role'] === 'admin'): ?>
                <th>Aksi</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data['peminjaman'])): ?>
                <tr>
                    <td colspan="<?php echo $_SESSION['user']['nama_role'] === 'admin' ? '6' : '5'; ?>" style="text-align: center;">Tidak ada data peminjaman</td>
                </tr>
            <?php else: ?>
                <?php foreach ($data['peminjaman'] as $index => $peminjaman): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($peminjaman['nama_peminjam']); ?></td>
                    <td><?php echo $peminjaman['tanggal_peninjaman']; ?></td>
                    <td><?php echo $peminjaman['tanggal_kembalikan']; ?></td>
                    <td>
                        <?php 
                        $status_class = 'status-' . $peminjaman['status'];
                        $status_text = ucfirst($peminjaman['status']);
                        echo "<span class='$status_class'>$status_text</span>";
                        ?>
                    </td>
                    <?php if ($_SESSION['user']['nama_role'] === 'admin'): ?>
                    <td>
                        <?php if ($peminjaman['status'] === 'pending'): ?>
                            <a href="index.php?action=peminjaman&subaction=update_status&id=<?php echo $peminjaman['id']; ?>&status=disetujui" class="btn btn-success">Setujui</a>
                            <a href="index.php?action=peminjaman&subaction=update_status&id=<?php echo $peminjaman['id']; ?>&status=ditolak" class="btn btn-danger">Tolak</a>
                        <?php elseif ($peminjaman['status'] === 'disetujui'): ?>
                            <a href="index.php?action=peminjaman&subaction=update_status&id=<?php echo $peminjaman['id']; ?>&status=dikembalikan" class="btn btn-secondary">Tandai Kembali</a>
                        <?php else: ?>
                            <span>-</span>
                        <?php endif; ?>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
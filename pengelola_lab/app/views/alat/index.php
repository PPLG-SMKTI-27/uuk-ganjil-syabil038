<!DOCTYPE html>
<html>
<head>
    <title>Data Alat Lab</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 5px 10px; text-decoration: none; border: none; cursor: pointer; }
        .btn-primary { background: #007bff; color: white; }
        .btn-warning { background: #ffc107; color: black; }
        .btn-danger { background: #dc3545; color: white; }
        .success { color: green; padding: 10px; background: #d4edda; }
        .error { color: red; padding: 10px; background: #f8d7da; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Data Alat Lab</h2>
        <div>
            <a href="index.php?action=dashboard" class="btn">Dashboard</a>
            <a href="index.php?action=alat&subaction=create" class="btn btn-primary">Tambah Alat</a>
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
                <th>Nama Alat</th>
                <th>Deskripsi</th>
                <th>Jumlah Total</th>
                <th>Jumlah Tersedia</th>
                <th>Lokasi</th>
                <?php if ($_SESSION['user']['nama_role'] === 'admin'): ?>
                <th>Aksi</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data['alat'])): ?>
                <tr>
                    <td colspan="<?php echo $_SESSION['user']['nama_role'] === 'admin' ? '7' : '6'; ?>" style="text-align: center;">Tidak ada data alat</td>
                </tr>
            <?php else: ?>
                <?php foreach ($data['alat'] as $index => $alat): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($alat['nama_alat']); ?></td>
                    <td><?php echo htmlspecialchars($alat['deskripsi']); ?></td>
                    <td><?php echo $alat['jumlah_total']; ?></td>
                    <td><?php echo $alat['jumlah_tersedia']; ?></td>
                    <td><?php echo htmlspecialchars($alat['lokasi']); ?></td>
                    <?php if ($_SESSION['user']['nama_role'] === 'admin'): ?>
                    <td>
                        <a href="index.php?action=alat&subaction=edit&id=<?php echo $alat['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="index.php?action=alat&subaction=delete&id=<?php echo $alat['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus alat?')">Hapus</a>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
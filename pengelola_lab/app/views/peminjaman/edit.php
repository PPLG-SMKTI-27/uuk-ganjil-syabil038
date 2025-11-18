<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: #f8f9fa; padding: 20px; border-radius: 5px; text-align: center; }
        .stat-number { font-size: 2em; font-weight: bold; color: #007bff; }
        .menu { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; }
        .menu-item { background: #007bff; color: white; padding: 20px; text-align: center; text-decoration: none; border-radius: 5px; }
        .menu-item:hover { background: #0056b3; }
        .btn { padding: 10px 15px; text-decoration: none; border: none; cursor: pointer; }
        .btn-danger { background: #dc3545; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Dashboard Peminjaman Lab</h1>
        <div>
            <span>Selamat datang, <?php echo htmlspecialchars($_SESSION['user']['nama']); ?> (<?php echo $_SESSION['user']['nama_role']; ?>)</span>
            <a href="index.php?action=logout" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div style="color: green; padding: 10px; background: #d4edda; margin-bottom: 20px;">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div style="color: red; padding: 10px; background: #f8d7da; margin-bottom: 20px;">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="stats">
        <div class="stat-card">
            <div class="stat-number"><?php echo count($data['peminjaman']); ?></div>
            <div>Total Peminjaman</div>
        </div>
        
        <?php if ($_SESSION['user']['nama_role'] === 'admin'): ?>
        <div class="stat-card">
            <div class="stat-number"><?php echo count($data['alat']); ?></div>
            <div>Total Alat Lab</div>
        </div>
        <?php endif; ?>
        
        <div class="stat-card">
            <?php 
            $pending = array_filter($data['peminjaman'], function($p) { 
                return $p['status'] === 'pending'; 
            }); 
            ?>
            <div class="stat-number"><?php echo count($pending); ?></div>
            <div>Peminjaman Pending</div>
        </div>
    </div>

    <div class="menu">
        <a href="index.php?action=peminjaman" class="menu-item">
            Data Peminjaman
        </a>
        
        <a href="index.php?action=peminjaman&subaction=create" class="menu-item">
            Ajukan Peminjaman
        </a>
        
        <a href="index.php?action=alat" class="menu-item">
            Data Alat Lab
        </a>
        
        <?php if ($_SESSION['user']['nama_role'] === 'admin'): ?>
        <a href="index.php?action=alat&subaction=create" class="menu-item">
            Tambah Alat Lab
        </a>
        <?php endif; ?>
    </div>

    <div style="margin-top: 30px;">
        <h3>Peminjaman Terbaru</h3>
        <?php if (empty($data['peminjaman'])): ?>
            <p>Tidak ada data peminjaman</p>
        <?php else: ?>
            <ul>
                <?php 
                $recent_peminjaman = array_slice($data['peminjaman'], 0, 5);
                foreach ($recent_peminjaman as $peminjaman): 
                ?>
                <li>
                    <?php echo htmlspecialchars($peminjaman['nama_peminjam']); ?> - 
                    <?php echo $peminjaman['tanggal_peninjaman']; ?> s/d <?php echo $peminjaman['tanggal_kembalikan']; ?> - 
                    <strong><?php echo ucfirst($peminjaman['status']); ?></strong>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>
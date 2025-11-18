<!DOCTYPE html>
<html>
<head>
    <title>Tambah Alat Lab</title>
    <style>
        body { font-family: Arial; max-width: 600px; margin: 20px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], textarea { width: 100%; padding: 8px; border: 1px solid #ddd; }
        textarea { height: 100px; }
        .btn { padding: 10px 15px; text-decoration: none; border: none; cursor: pointer; margin-right: 10px; }
        .btn-primary { background: #007bff; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
    <h2>Tambah Alat Lab</h2>

    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Nama Alat:</label>
            <input type="text" name="nama_alat" required>
        </div>

        <div class="form-group">
            <label>Deskripsi:</label>
            <textarea name="deskripsi"></textarea>
        </div>

        <div class="form-group">
            <label>Jumlah Total:</label>
            <input type="number" name="jumlah_total" min="1" required>
        </div>

        <div class="form-group">
            <label>Lokasi:</label>
            <input type="text" name="lokasi">
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php?action=alat" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</body>
</html>
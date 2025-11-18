<!DOCTYPE html>
<html>
<head>
    <title>Ajukan Peminjaman</title>
    <style>
        body { font-family: Arial; max-width: 800px; margin: 20px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="date"], select { padding: 8px; border: 1px solid #ddd; }
        .btn { padding: 10px 15px; text-decoration: none; border: none; cursor: pointer; margin-right: 10px; }
        .btn-primary { background: #007bff; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .error { color: red; margin-bottom: 15px; }
        .alat-item { border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px; }
        .alat-header { display: flex; justify-content: between; align-items: center; margin-bottom: 10px; }
        .remove-alat { background: #dc3545; color: white; border: none; padding: 5px 10px; cursor: pointer; }
        .add-alat { background: #28a745; color: white; border: none; padding: 10px 15px; cursor: pointer; margin-bottom: 15px; }
    </style>
</head>
<body>
    <h2>Ajukan Peminjaman Alat Lab</h2>

    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" id="peminjamanForm">
        <div class="form-group">
            <label>Tanggal Pinjam:</label>
            <input type="date" name="tanggal_peninjaman" required>
        </div>

        <div class="form-group">
            <label>Tanggal Kembali:</label>
            <input type="date" name="tanggal_kembalikan" required>
        </div>

        <h3>Alat yang Dipinjam</h3>
        
        <div id="alat-container">
            <div class="alat-item">
                <div class="form-group">
                    <label>Alat:</label>
                    <select name="alat_id[]" required onchange="updateMaxJumlah(this)">
                        <option value="">Pilih Alat</option>
                        <?php foreach ($data['alat_tersedia'] as $alat): ?>
                            <option value="<?php echo $alat['id']; ?>" data-max="<?php echo $alat['jumlah_tersedia']; ?>">
                                <?php echo htmlspecialchars($alat['nama_alat']); ?> (Tersedia: <?php echo $alat['jumlah_tersedia']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jumlah:</label>
                    <input type="number" name="jumlah[]" min="1" max="1" value="1" required>
                </div>
            </div>
        </div>

        <button type="button" class="add-alat" onclick="addAlat()">Tambah Alat Lain</button>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
            <a href="index.php?action=peminjaman" class="btn btn-secondary">Kembali</a>
        </div>
    </form>

    <script>
        function addAlat() {
            const container = document.getElementById('alat-container');
            const newAlat = container.firstElementChild.cloneNode(true);
            
            // Reset values
            newAlat.querySelector('select').selectedIndex = 0;
            newAlat.querySelector('input[type="number"]').value = 1;
            newAlat.querySelector('input[type="number"]').max = 1;
            
            // Add remove button if not exists
            if (!newAlat.querySelector('.remove-alat')) {
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'remove-alat';
                removeBtn.textContent = 'Hapus';
                removeBtn.onclick = function() { this.parentElement.remove(); };
                newAlat.appendChild(removeBtn);
            }
            
            container.appendChild(newAlat);
        }

        function updateMaxJumlah(select) {
            const max = select.options[select.selectedIndex].getAttribute('data-max');
            const jumlahInput = select.parentElement.parentElement.querySelector('input[type="number"]');
            jumlahInput.max = max || 1;
            if (jumlahInput.value > max) {
                jumlahInput.value = max;
            }
        }

        // Add remove button to first item if there are multiple alat options
        document.addEventListener('DOMContentLoaded', function() {
            if (document.querySelectorAll('#alat-container .alat-item').length > 1) {
                document.querySelectorAll('#alat-container .alat-item').forEach(item => {
                    if (!item.querySelector('.remove-alat')) {
                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.className = 'remove-alat';
                        removeBtn.textContent = 'Hapus';
                        removeBtn.onclick = function() { this.parentElement.remove(); };
                        item.appendChild(removeBtn);
                    }
                });
            }
        });
    </script>
</body>
</html>
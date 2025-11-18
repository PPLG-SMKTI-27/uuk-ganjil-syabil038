<?php
require_once 'Database.php';

class Peminjaman extends Database {
    private $table_name = "peninjaman";
    private $detail_table = "detail_peninjaman";
    
    public function getAll() {
        $query = "SELECT p.*, u.nama as nama_peminjam 
                 FROM " . $this->table_name . " p
                 JOIN users u ON p.user_id = u.id
                 ORDER BY p.id DESC";
        $stmt = $this->executeQuery($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getByUserId($user_id) {
        $query = "SELECT p.*, u.nama as nama_peminjam 
                 FROM " . $this->table_name . " p
                 JOIN users u ON p.user_id = u.id
                 WHERE p.user_id = :user_id
                 ORDER BY p.id DESC";
        $params = [':user_id' => $user_id];
        $stmt = $this->executeQuery($query, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getById($id) {
        $query = "SELECT p.*, u.nama as nama_peminjam 
                 FROM " . $this->table_name . " p
                 JOIN users u ON p.user_id = u.id
                 WHERE p.id = :id";
        $params = [':id' => $id];
        $stmt = $this->executeQuery($query, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getDetailPeminjaman($peminjaman_id) {
        $query = "SELECT dp.*, a.nama_alat 
                 FROM " . $this->detail_table . " dp
                 JOIN alat_lab a ON dp.alat_id = a.id
                 WHERE dp.peninjaman_id = :peninjaman_id";
        $params = [':peninjaman_id' => $peminjaman_id];
        $stmt = $this->executeQuery($query, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function create($data) {
        // Insert peminjaman
        $query = "INSERT INTO " . $this->table_name . " 
                 (user_id, tanggal_peninjaman, tanggal_kembalikan, status) 
                 VALUES (:user_id, :tanggal_peninjaman, :tanggal_kembalikan, :status)";
        
        $params = [
            ':user_id' => $data['user_id'],
            ':tanggal_peninjaman' => $data['tanggal_peninjaman'],
            ':tanggal_kembalikan' => $data['tanggal_kembalikan'],
            ':status' => 'pending'
        ];
        
        $stmt = $this->executeQuery($query, $params);
        $peminjaman_id = $this->connection->lastInsertId();
        
        // Insert detail peminjaman
        foreach ($data['alat'] as $alat) {
            $query_detail = "INSERT INTO " . $this->detail_table . " 
                           (peninjaman_id, alat_id, jumlah) 
                           VALUES (:peninjaman_id, :alat_id, :jumlah)";
            
            $params_detail = [
                ':peninjaman_id' => $peminjaman_id,
                ':alat_id' => $alat['id'],
                ':jumlah' => $alat['jumlah']
            ];
            
            $this->executeQuery($query_detail, $params_detail);
            
            // Update jumlah tersedia alat
            $alat_model = new Alat();
            $alat_data = $alat_model->getById($alat['id']);
            $new_jumlah = $alat_data['jumlah_tersedia'] - $alat['jumlah'];
            $alat_model->updateJumlahTersedia($alat['id'], $new_jumlah);
        }
        
        return $peminjaman_id;
    }
    
    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table_name . " 
                 SET status = :status 
                 WHERE id = :id";
        
        $params = [
            ':status' => $status,
            ':id' => $id
        ];
        
        $stmt = $this->executeQuery($query, $params);
        return $stmt->rowCount();
    }
}
?>
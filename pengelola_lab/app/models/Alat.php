<?php
require_once 'Database.php';

class Alat extends Database {
    private $table_name = "alat_lab";
    
    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->executeQuery($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $params = [':id' => $id];
        $stmt = $this->executeQuery($query, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (nama_alat, deskripsi, jumlah_total, jumlah_tersedia, lokasi) 
                 VALUES (:nama_alat, :deskripsi, :jumlah_total, :jumlah_tersedia, :lokasi)";
        
        $params = [
            ':nama_alat' => $data['nama_alat'],
            ':deskripsi' => $data['deskripsi'],
            ':jumlah_total' => $data['jumlah_total'],
            ':jumlah_tersedia' => $data['jumlah_tersedia'],
            ':lokasi' => $data['lokasi']
        ];
        
        $stmt = $this->executeQuery($query, $params);
        return $stmt;
    }
    
    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                 SET nama_alat = :nama_alat, deskripsi = :deskripsi, 
                     jumlah_total = :jumlah_total, jumlah_tersedia = :jumlah_tersedia, 
                     lokasi = :lokasi 
                 WHERE id = :id";
        
        $params = [
            ':nama_alat' => $data['nama_alat'],
            ':deskripsi' => $data['deskripsi'],
            ':jumlah_total' => $data['jumlah_total'],
            ':jumlah_tersedia' => $data['jumlah_tersedia'],
            ':lokasi' => $data['lokasi'],
            ':id' => $id
        ];
        
        $stmt = $this->executeQuery($query, $params);
        return $stmt->rowCount();
    }
    
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $params = [':id' => $id];
        $stmt = $this->executeQuery($query, $params);
        return $stmt->rowCount();
    }
    
    public function getAlatTersedia() {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE jumlah_tersedia > 0 
                 ORDER BY nama_alat";
        $stmt = $this->executeQuery($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function updateJumlahTersedia($id, $jumlah) {
        $query = "UPDATE " . $this->table_name . " 
                 SET jumlah_tersedia = :jumlah_tersedia 
                 WHERE id = :id";
        
        $params = [
            ':jumlah_tersedia' => $jumlah,
            ':id' => $id
        ];
        
        $stmt = $this->executeQuery($query, $params);
        return $stmt->rowCount();
    }
}
?>
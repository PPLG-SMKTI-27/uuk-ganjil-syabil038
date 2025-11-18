<?php
require_once 'Database.php';

class Role extends Database {
    private $table_name = "role";
    
    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->executeQuery($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $params = [':id' => $id];
        $stmt = $this->executeQuery($query, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
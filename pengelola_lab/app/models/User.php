<?php
require_once 'Database.php';

class User extends Database {
    private $table_name = "users";
    
    public function login($username, $password) {
        $query = "SELECT u.*, r.nama_role FROM " . $this->table_name . " u 
                 JOIN role r ON u.role_id = r.id 
                 WHERE u.username = :username";
        $params = [':username' => $username];
        $stmt = $this->executeQuery($query, $params);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    
    public function getById($id) {
        $query = "SELECT u.*, r.nama_role FROM " . $this->table_name . " u 
                 JOIN role r ON u.role_id = r.id 
                 WHERE u.id = :id";
        $params = [':id' => $id];
        $stmt = $this->executeQuery($query, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getAll() {
        $query = "SELECT u.*, r.nama_role FROM " . $this->table_name . " u 
                 JOIN role r ON u.role_id = r.id";
        $stmt = $this->executeQuery($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
<?php
require_once 'config/database.php';

class Database {
    protected $connection;
    
    public function __construct() {
        $db_config = new DatabaseConfig();
        $this->connection = $db_config->getConnection();
    }
    
    protected function executeQuery($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch(PDOException $e) {
            throw new Exception("Query error: " . $e->getMessage());
        }
    }
}
?>
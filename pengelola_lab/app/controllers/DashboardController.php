<?php
require_once 'app/models/Peminjaman.php';
require_once 'app/models/Alat.php';

class DashboardController {
    private $peminjamanModel;
    private $alatModel;
    
    public function __construct() {
        $this->peminjamanModel = new Peminjaman();
        $this->alatModel = new Alat();
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /peminjaman_lab/index.php');
            exit();
        }
    }
    
    public function index() {
        $data = [];
        
        if ($_SESSION['user']['nama_role'] === 'admin') {
            $data['peminjaman'] = $this->peminjamanModel->getAll();
            $data['alat'] = $this->alatModel->getAll();
        } else {
            $data['peminjaman'] = $this->peminjamanModel->getByUserId($_SESSION['user']['id']);
        }
        
        require 'app/views/dashboard/index.php';
    }
}
?>
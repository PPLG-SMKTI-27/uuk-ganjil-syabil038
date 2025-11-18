<?php
require_once 'app/models/Alat.php';

class AlatController {
    private $alatModel;
    
    public function __construct() {
        $this->alatModel = new Alat();
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /peminjaman_lab/index.php');
            exit();
        }
    }
    
    public function index() {
        $data['alat'] = $this->alatModel->getAll();
        require 'app/views/alat/index.php';
    }
    
    public function create() {
        if ($_SESSION['user']['nama_role'] !== 'admin') {
            $_SESSION['error'] = "Anda tidak memiliki akses!";
            header('Location: /peminjaman_lab/index.php?action=alat');
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_alat' => $_POST['nama_alat'],
                'deskripsi' => $_POST['deskripsi'],
                'jumlah_total' => $_POST['jumlah_total'],
                'jumlah_tersedia' => $_POST['jumlah_total'],
                'lokasi' => $_POST['lokasi']
            ];
            
            if ($this->alatModel->create($data)) {
                $_SESSION['success'] = "Alat berhasil ditambahkan!";
                header('Location: /peminjaman_lab/index.php?action=alat');
                exit();
            } else {
                $error = "Gagal menambahkan alat!";
            }
        }
        
        require 'app/views/alat/create.php';
    }
    
    public function edit() {
        if ($_SESSION['user']['nama_role'] !== 'admin') {
            $_SESSION['error'] = "Anda tidak memiliki akses!";
            header('Location: /peminjaman_lab/index.php?action=alat');
            exit();
        }
        
        $id = $_GET['id'];
        $data['alat'] = $this->alatModel->getById($id);
        
        if (!$data['alat']) {
            $_SESSION['error'] = "Alat tidak ditemukan!";
            header('Location: /peminjaman_lab/index.php?action=alat');
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $update_data = [
                'nama_alat' => $_POST['nama_alat'],
                'deskripsi' => $_POST['deskripsi'],
                'jumlah_total' => $_POST['jumlah_total'],
                'jumlah_tersedia' => $_POST['jumlah_tersedia'],
                'lokasi' => $_POST['lokasi']
            ];
            
            if ($this->alatModel->update($id, $update_data) > 0) {
                $_SESSION['success'] = "Alat berhasil diupdate!";
                header('Location: /peminjaman_lab/index.php?action=alat');
                exit();
            } else {
                $error = "Gagal mengupdate alat!";
            }
        }
        
        require 'app/views/alat/edit.php';
    }
    
    public function delete() {
        if ($_SESSION['user']['nama_role'] !== 'admin') {
            $_SESSION['error'] = "Anda tidak memiliki akses!";
            header('Location: /peminjaman_lab/index.php?action=alat');
            exit();
        }
        
        $id = $_GET['id'];
        
        if ($this->alatModel->delete($id) > 0) {
            $_SESSION['success'] = "Alat berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Gagal menghapus alat!";
        }
        
        header('Location: /peminjaman_lab/index.php?action=alat');
        exit();
    }
}
?>
<?php
require_once 'app/models/Peminjaman.php';
require_once 'app/models/Alat.php';

class PeminjamanController {
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
        if ($_SESSION['user']['nama_role'] === 'admin') {
            $data['peminjaman'] = $this->peminjamanModel->getAll();
        } else {
            $data['peminjaman'] = $this->peminjamanModel->getByUserId($_SESSION['user']['id']);
        }
        
        require 'app/views/peminjaman/index.php';
    }
    
    public function create() {
        $data['alat_tersedia'] = $this->alatModel->getAlatTersedia();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $alat_data = [];
            foreach ($_POST['alat_id'] as $key => $alat_id) {
                if ($_POST['jumlah'][$key] > 0) {
                    $alat_data[] = [
                        'id' => $alat_id,
                        'jumlah' => $_POST['jumlah'][$key]
                    ];
                }
            }
            
            if (empty($alat_data)) {
                $error = "Pilih minimal satu alat!";
            } else {
                $peminjaman_data = [
                    'user_id' => $_SESSION['user']['id'],
                    'tanggal_peninjaman' => $_POST['tanggal_peninjaman'],
                    'tanggal_kembalikan' => $_POST['tanggal_kembalikan'],
                    'alat' => $alat_data
                ];
                
                if ($this->peminjamanModel->create($peminjaman_data)) {
                    $_SESSION['success'] = "Peminjaman berhasil diajukan!";
                    header('Location: /peminjaman_lab/index.php?action=peminjaman');
                    exit();
                } else {
                    $error = "Gagal mengajukan peminjaman!";
                }
            }
        }
        
        require 'app/views/peminjaman/create.php';
    }
    
    public function updateStatus() {
        if ($_SESSION['user']['nama_role'] !== 'admin') {
            $_SESSION['error'] = "Anda tidak memiliki akses!";
            header('Location: /peminjaman_lab/index.php?action=peminjaman');
            exit();
        }
        
        $id = $_GET['id'];
        $status = $_GET['status'];
        
        if ($this->peminjamanModel->updateStatus($id, $status) > 0) {
            $_SESSION['success'] = "Status peminjaman berhasil diupdate!";
        } else {
            $_SESSION['error'] = "Gagal mengupdate status!";
        }
        
        header('Location: /peminjaman_lab/index.php?action=peminjaman');
        exit();
    }
}
?>
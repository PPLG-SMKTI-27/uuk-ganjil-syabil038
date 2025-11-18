<?php
require_once 'app/models/User.php';

class AuthController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
        session_start();
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $user = $this->userModel->login($username, $password);
            
            if ($user) {
                $_SESSION['user'] = $user;
                header('Location: /peminjaman_lab/index.php?action=dashboard');
                exit();
            } else {
                $error = "Username atau password salah!";
            }
        }
        
        require 'app/views/auth/login.php';
    }
    
    public function logout() {
        session_destroy();
        header('Location: /peminjaman_lab/index.php');
        exit();
    }
}
?>
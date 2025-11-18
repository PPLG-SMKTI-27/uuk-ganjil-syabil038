<?php
// Konfigurasi aplikasi
class Config {
    public static $app_name = "Sistem Peminjaman Alat Lab";
    public static $base_url = "http://localhost/peminjaman_lab/";
    
    // Konfigurasi database
    public static function getDBConfig() {
        return [
            'host' => 'localhost',
            'dbname' => 'pengelola_lab',
            'username' => 'root',
            'password' => ''
        ];
    }
    
    // Role yang diizinkan
    public static function getAllowedRoles() {
        return ['admin', 'guru', 'siswa'];
    }
    
    // Status peminjaman
    public static function getStatusPeminjaman() {
        return ['pending', 'disetujui', 'ditolak', 'dikembalikan'];
    }
}
?>
<?php
// Sertakan file connect.php untuk melakukan koneksi ke database
require_once 'connect.php';

// Buat database jika belum ada
$sql = "CREATE DATABASE IF NOT EXISTS database_name";
if (mysqli_query($conn, $sql)) {
    echo "Database berhasil dibuat atau sudah ada.";
} else {
    echo "Terjadi kesalahan saat membuat database: " . mysqli_error($conn);
}

// Tutup koneksi ke server MySQL
mysqli_close($conn);
?>

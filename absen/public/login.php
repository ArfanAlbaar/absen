<?php
session_start();

// Sertakan file connect.php untuk melakukan koneksi ke database
require_once '../config/connectDsn.php';

// Fungsi untuk melakukan verifikasi login
function login($nidn, $password, $remember) {
    global $conn;

    // Validasi NIDN
    $valid_nidn = preg_match('/^\d{10}$/', $nidn);

    if (!$valid_nidn) {
        echo "<script>alert('NIDN tidak valid.'); window.location.href = 'login_page.html';</script>";
        exit();
    }

    // Query untuk mencari dosen berdasarkan NIDN dan password
    $sql = "SELECT * FROM dosen WHERE nidn = '$nidn' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    // Periksa apakah dosen dengan NIDN dan password tersebut ditemukan
    if (mysqli_num_rows($result) == 1) {
        // Login berhasil
        $_SESSION['nidn'] = $nidn;

        // Set cookie jika remember me dicentang
        if ($remember) {
            $cookie_name = 'remember_me';
            $cookie_value = $nidn;
            $expiry_time = time() + (3600 * 24); // Cookie berlaku selama 1 hari
            setcookie($cookie_name, $cookie_value, $expiry_time, '/');
        }

        header('Location: index.php');
        exit();
    } else {
        // Login gagal
        echo "<script>alert('NIDN atau Password salah.'); window.location.href = 'login_page.html';</script>";
    }
}

// Periksa apakah form login telah disubmit
if (isset($_POST['submit'])) {
    $nidn = $_POST['nidn'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    login($nidn, $password, $remember);
} elseif (isset($_COOKIE['remember_me']) && !isset($_SESSION['nidn'])) {
    // Jika pengguna sudah login sebelumnya (cookie remember me ada) dan sesi belum ada
    $nidn = $_COOKIE['remember_me'];
    login($nidn, '', true);
}

// Tutup koneksi ke server MySQL
mysqli_close($conn);
?>

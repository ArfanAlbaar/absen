<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "absensi_mahasiswa";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$selectedNIM = $_POST['selectedNIM'];
$nama = $_POST['nama'];
$absensi = $_POST['absensi'];
$alasan = $_POST['alasan'];

// Periksa apakah NIM ada di database
$checkQuery = "SELECT COUNT(*) as count FROM mahasiswa WHERE nim = '$selectedNIM'";
$checkResult = $conn->query($checkQuery);
$checkData = $checkResult->fetch_assoc();

if ($checkData['count'] > 0) {
    $sql = "INSERT INTO absensi_table (nim, nama, absensi, alasan) VALUES ('$selectedNIM', '$nama', '$absensi', '$alasan')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil disimpan.'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Data gagal disimpan.'); window.location.href = 'index.php';</script>";
    }
} else {
    echo "<script>alert('NIM atau Nama tidak ditemukan dalam database.'); window.location.href = 'index.php';</script>";
}

$conn->close();
?>

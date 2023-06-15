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

$sql = "INSERT INTO absensi_table (nim, nama, absensi, alasan) VALUES ('$selectedNIM', '$nama', '$absensi', '$alasan')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Data berhasil disimpan.'); window.location.href = 'index.php';</script>";
} else {
    echo "<script>alert('Data gagal disimpan.'); window.location.href = 'index.php';</script>";
}

$conn->close();
?>

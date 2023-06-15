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
$absensi = $_POST['absensi'];
$alasan = $_POST['alasan'];

$sql = "INSERT INTO absensi_table (nim, absensi, alasan) VALUES ('$selectedNIM', '$absensi', '$alasan')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Data berhasil disimpan.'); window.location.href = 'index.php';</script>";
} else {
    echo "<script>alert('Data gagal disimpan.'); window.location.href = 'index.php';</script>";
}

$conn->close();
?>

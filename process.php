<?php
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data dari formulir
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $tanggal = date('Y-m-d');
    $jenisAbsensi = $_POST['jenis_absensi'];
    $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';

    // Memasukkan data ke dalam tabel mahasiswa
    $sql = "INSERT INTO mahasiswa (NIM, Nama, Tanggal, Jenis_absensi, Keterangan)
            VALUES ('$nim', '$nama', '$tanggal', '$jenisAbsensi', '$keterangan')";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil disimpan.";
    } else {
        echo "Terjadi kesalahan: " . $conn->error;
    }
}

$conn->close();
?>

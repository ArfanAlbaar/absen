<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "absensi_mahasiswa";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$term = $_GET['term'];

$sql = "SELECT nim, nama FROM mahasiswa WHERE nim LIKE '$term%'";
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            'nim' => $row['nim'],
            'nama' => $row['nama']
        );
    }
}

echo json_encode($data);

$conn->close();
?>

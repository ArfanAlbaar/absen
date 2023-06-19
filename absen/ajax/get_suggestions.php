<?php
require '../config/connectMhs.php';

$term = $_GET['term'];

$sql = "SELECT nim, nama FROM mahasiswa WHERE nim LIKE '%$term%' OR nama LIKE '%$term%'";
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

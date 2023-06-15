<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    // Fungsi untuk membuat header laporan
    function Header()
    {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Laporan Absensi', 0, 1, 'C');
        $this->Ln(5);
    }

    // Fungsi untuk membuat tabel laporan
    function CreateTable($header, $data)
    {
        // Menghitung lebar kolom untuk NIM dan Nama
        $nimWidth = 0;
        $namaWidth = 0;
        $waktuWidth = 0;
        foreach ($data as $row) {
            $nimWidth = max($nimWidth, $this->GetStringWidth($row[0]));
            $namaWidth = max($namaWidth, $this->GetStringWidth($row[1]));
            $waktuWidth = max($waktuWidth, $this->GetStringWidth($row[4]));
        }

        // Set lebar kolom
        $columnWidths = array($nimWidth, $namaWidth, 40, 40, $waktuWidth + 10); // Menambahkan sedikit lebar untuk kolom waktu

        // Header
        $this->SetFont('Arial', 'B', 12);
        $this->Cell($columnWidths[0], 10, $header[0], 1, 0, 'C'); // NIM
        $this->Cell($columnWidths[1], 10, $header[1], 1, 0, 'C'); // Nama
        $this->Cell($columnWidths[2], 10, $header[2], 1, 0, 'C'); // Tipe Absensi
        $this->Cell($columnWidths[3], 10, $header[3], 1, 0, 'C'); // Alasan
        $this->Cell($columnWidths[4], 10, $header[4], 1, 0, 'C'); // Waktu
        $this->Ln();

        // Data
        $this->SetFont('Arial', '', 12);
        foreach ($data as $row) {
            for ($i = 0; $i < count($row); $i++) {
                // Memformat cell untuk nama
                if ($i == 1) {
                    $nama = $row[$i];
                    if (strlen($nama) > 25) {
                        $nama = substr($nama, 0, 25); // Menghapus huruf setelah 25 digit
                    }
                    $this->Cell($columnWidths[$i], 10, $nama, 1, 0, 'L'); // Nama
                } else {
                    $this->Cell($columnWidths[$i], 10, $row[$i], 1, 0, 'C'); // NIM, Tipe Absensi, Alasan, Waktu
                }
            }
            $this->Ln();
        }
    }
}

// Membuat objek PDF
$pdf = new PDF('L', 'mm', 'A4');

// Mengambil data dari database
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'absensi_mahasiswa';
$mysqli = new mysqli($host, $user, $password, $database);
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

$query = "SELECT * FROM absensi_table";
$result = $mysqli->query($query);

// Menyiapkan data untuk ditampilkan pada tabel laporan
$header = array('NIM', 'Nama', 'Tipe Absensi', 'Alasan', 'Waktu');
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = array(
        $row['nim'],
        $row['nama'],
        $row['absensi'],
        $row['alasan'],
        $row['timestamp_column']
    );
}

// Menutup koneksi database
$mysqli->close();

// Menambahkan halaman baru pada PDF
$pdf->AddPage();

// Membuat tabel laporan
$pdf->CreateTable($header, $data);

// Menampilkan PDF
$pdf->Output();
?>

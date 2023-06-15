CREATE TABLE absensi_table (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20),
    nama VARCHAR(255), -- Tambahkan kolom nama
    absensi VARCHAR(20),
    alasan VARCHAR(255),
    timestamp_column TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

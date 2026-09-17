-- create_tanggapans_table

CREATE TABLE IF NOT EXISTS `tanggapan` (
    id_tanggapan         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_aspirasi          INT UNSIGNED NOT NULL,
    status               ENUM('menunggu', 'proses', 'selesai') NOT NULL DEFAULT 'menunggu',
    feedback             TEXT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    FOREIGN KEY (id_aspirasi) REFERENCES aspirasi(id_aspirasi) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

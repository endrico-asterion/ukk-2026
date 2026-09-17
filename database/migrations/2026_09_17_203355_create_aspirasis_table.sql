-- create_aspirasis_table

CREATE TABLE IF NOT EXISTS `aspirasi` (
    id_aspirasi         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_siswa            INT UNSIGNED NOT NULL,
    id_kategori         INT UNSIGNED NOT NULL,
    lokasi              VARCHAR(100) NOT NULL,
    keterangan          VARCHAR(255) NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa) ON DELETE CASCADE,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

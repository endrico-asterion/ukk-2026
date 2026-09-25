-- create_alats_table

CREATE TABLE IF NOT EXISTS `alat` (
    id_alat         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode_alat       VARCHAR(50) NOT NULL,
    nama_alat       VARCHAR(225) NOT NULL,
    id_kategori     INT UNSIGNED NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

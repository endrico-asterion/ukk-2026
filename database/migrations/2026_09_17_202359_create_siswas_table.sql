-- create_siswas_table

CREATE TABLE IF NOT EXISTS `siswa` (
    id_siswa      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id       INT UNSIGNED NOT NULL,
    nis           VARCHAR(20) NOT NULL UNIQUE,
    kelas         VARCHAR(10) NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

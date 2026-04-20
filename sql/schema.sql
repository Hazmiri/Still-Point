CREATE TABLE users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_users_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE instruments (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(120) NOT NULL,
  cue_type ENUM('playing','break','training') NOT NULL,
  material VARCHAR(80) NOT NULL,
  length_mm SMALLINT UNSIGNED NOT NULL,
  weight_g SMALLINT UNSIGNED NOT NULL,
  tip_mm DECIMAL(4,1) NOT NULL,
  description TEXT NOT NULL,
  image_path VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  INDEX idx_instruments_type (cue_type),
  INDEX idx_instruments_material (material),
  INDEX idx_instruments_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
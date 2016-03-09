CREATE TABLE IF NOT EXISTS `gps_client` (
  `position_id` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `numero` VARCHAR(256) NOT NULL,
  `imei` VARCHAR(120) NOT NULL,
  `battery` DECIMAL(11,2) DEFAULT NULL,
  `latitude` DECIMAL(11,6) DEFAULT NULL COMMENT 'Divisée par 600 000 pour obtenir la valeur en degré',
  `longitude` DECIMAL(11,6) DEFAULT NULL COMMENT 'Divisée par 600 000 pour obtenir la valeur en degré',
  `date_creation` DATETIME DEFAULT NULL COMMENT 'Date de création de l''enregistrement',
  `date_gps` DATETIME DEFAULT NULL COMMENT 'Date du GPS',
  `date_cell` DATETIME DEFAULT NULL COMMENT 'Date du cellulaire',
  `score` INT(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

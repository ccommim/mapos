-- Adiciona flag de habilitado/desabilitado para tecnicos

SET @col_exists := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'cus_tecnico'
      AND COLUMN_NAME = 'status'
);

SET @sql := IF(
    @col_exists = 0,
    'ALTER TABLE `cus_tecnico` ADD COLUMN `status` TINYINT(1) NOT NULL DEFAULT 1 AFTER `nome`',
    'SELECT 1'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

UPDATE `cus_tecnico`
SET `status` = 1
WHERE `status` IS NULL;

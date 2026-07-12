-- Atualização para cadastro e vínculo de técnicos

CREATE TABLE IF NOT EXISTS `cus_tecnico` (
  `idTecnico` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `criado_por` varchar(100) DEFAULT NULL,
  `criado_em` datetime DEFAULT NULL,
  `alterado_por` varchar(100) DEFAULT NULL,
  `alterado_em` datetime DEFAULT NULL,
  PRIMARY KEY (`idTecnico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `os`
  ADD COLUMN `cust_tecnicos` TEXT NULL AFTER `clientes_id`;

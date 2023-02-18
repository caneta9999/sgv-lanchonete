-- -----------------------------------------------------
-- Schema PROJETO_FACULDADE
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema PROJETO_FACULDADE
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `PROJETO_FACULDADE` DEFAULT CHARACTER SET utf8 ;
USE `PROJETO_FACULDADE` ;

-- -----------------------------------------------------
-- Table `PROJETO_FACULDADE`.`Produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PROJETO_FACULDADE`.`Produto` (
  `codigoProduto` INT NOT NULL AUTO_INCREMENT,
  `nomeProduto` VARCHAR(50) NOT NULL,
  `valorProduto` DECIMAL(11,2) NOT NULL,
  PRIMARY KEY (`codigoProduto`),
  UNIQUE INDEX `nomeProduto_UNIQUE` (`nomeProduto` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PROJETO_FACULDADE`.`Comanda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PROJETO_FACULDADE`.`Comanda` (
  `codigoComanda` INT NOT NULL AUTO_INCREMENT,
  `valorTotalComanda` DECIMAL(11,2) NOT NULL,
  `fechadaComanda` DECIMAL(1,0) NOT NULL,
  `trocoComanda` DECIMAL(11,2) NOT NULL,
  PRIMARY KEY (`codigoComanda`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PROJETO_FACULDADE`.`ItemComanda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PROJETO_FACULDADE`.`ItemComanda` (
  `codigoItemComanda` INT NOT NULL AUTO_INCREMENT,
  `Produto_codigoProduto` INT NOT NULL,
  `Comanda_codigoComanda` INT NOT NULL,
  `quantidadeItemComanda` DECIMAL(9,0) NOT NULL,
  PRIMARY KEY (`codigoItemComanda`),
  INDEX `fk_Produto_has_Comanda_Comanda1_idx` (`Comanda_codigoComanda` ASC) ,
  INDEX `fk_Produto_has_Comanda_Produto_idx` (`Produto_codigoProduto` ASC) ,
  CONSTRAINT `fk_Produto_has_Comanda_Produto`
    FOREIGN KEY (`Produto_codigoProduto`)
    REFERENCES `PROJETO_FACULDADE`.`Produto` (`codigoProduto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Produto_has_Comanda_Comanda1`
    FOREIGN KEY (`Comanda_codigoComanda`)
    REFERENCES `PROJETO_FACULDADE`.`Comanda` (`codigoComanda`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PROJETO_FACULDADE`.`Conta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PROJETO_FACULDADE`.`Conta` (
  `codigoConta` INT NOT NULL AUTO_INCREMENT,
  `nomeConta` VARCHAR(50) NOT NULL,
  `saldoConta` DECIMAL(11,2) NOT NULL,
  PRIMARY KEY (`codigoConta`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PROJETO_FACULDADE`.`Recebimento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PROJETO_FACULDADE`.`Recebimento` (
  `codigoRecebimento` INT NOT NULL AUTO_INCREMENT,
  `metodoPagamentoRecebimento` VARCHAR(20) NOT NULL,
  `Conta_codigoConta` INT NOT NULL,
  `Comanda_codigoComanda` INT NOT NULL,
  `valorRecebimento` DECIMAL(11,2) NOT NULL,
  PRIMARY KEY (`codigoRecebimento`),
  INDEX `fk_Recebimento_Conta1_idx` (`Conta_codigoConta` ASC) ,
  INDEX `fk_Recebimento_Comanda1_idx` (`Comanda_codigoComanda` ASC) ,
  CONSTRAINT `fk_Recebimento_Conta1`
    FOREIGN KEY (`Conta_codigoConta`)
    REFERENCES `PROJETO_FACULDADE`.`Conta` (`codigoConta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Recebimento_Comanda1`
    FOREIGN KEY (`Comanda_codigoComanda`)
    REFERENCES `PROJETO_FACULDADE`.`Comanda` (`codigoComanda`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PROJETO_FACULDADE`.`Funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PROJETO_FACULDADE`.`Funcionario` (
  `codigoFuncionario` INT NOT NULL AUTO_INCREMENT,
  `loginFuncionario` VARCHAR(50) NOT NULL,
  `senhaFuncionario` VARCHAR(50) NOT NULL,
  `nomeFuncionario` VARCHAR(100) NOT NULL,
  `CPF` DECIMAL(11,0) NOT NULL,
  `administrador` DECIMAL(1,0) NOT NULL,
  PRIMARY KEY (`codigoFuncionario`),
  UNIQUE INDEX `loginFuncionario_UNIQUE` (`loginFuncionario` ASC),
   UNIQUE INDEX `CPF_UNIQUE` (`CPF` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PROJETO_FACULDADE`.`Atendimento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PROJETO_FACULDADE`.`Atendimento` (
  `codigoAtendimento` INT NOT NULL AUTO_INCREMENT,
  `Funcionario_codigoFuncionario` INT NOT NULL,
  `Comanda_codigoComanda` INT NOT NULL,
  `dataHoraAtendimento` DATETIME NOT NULL,
  `status` DECIMAL(1,0) NOT NULL,
  INDEX `fk_Funcionario_has_Comanda_Funcionario1_idx` (`Funcionario_codigoFuncionario` ASC),
  PRIMARY KEY (`codigoAtendimento`),
  INDEX `fk_Atendimento_Comanda1_idx` (`Comanda_codigoComanda` ASC),
  CONSTRAINT `fk_Funcionario_has_Comanda_Funcionario1`
    FOREIGN KEY (`Funcionario_codigoFuncionario`)
    REFERENCES `PROJETO_FACULDADE`.`Funcionario` (`codigoFuncionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Atendimento_Comanda1`
    FOREIGN KEY (`Comanda_codigoComanda`)
    REFERENCES `PROJETO_FACULDADE`.`Comanda` (`codigoComanda`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

INSERT INTO `Produto` (`codigoProduto`, `nomeProduto`, `valorProduto`) VALUES
(1,'Prato 1', '25.00'),
(2,'Prato 2', '20.00'),
(3,'Refrigerante 1 350ml', '4.10');

INSERT INTO `Funcionario` (`codigoFuncionario`, `loginFuncionario`, `senhaFuncionario`, `nomeFuncionario`, `CPF`, `administrador`) VALUES
(1, 'guest123', 'A234567A', 'guest', '1', '1');

INSERT INTO `Conta` (`codigoConta`,`nomeConta`,`saldoConta`) VALUES
(1,'Conta 1', 250),
(2,'Conta 2',-500);

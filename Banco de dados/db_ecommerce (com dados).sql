/*
 Navicat Premium Data Transfer

 Source Server         : localhost 3312
 Source Server Type    : MySQL
 Source Server Version : 100421
 Source Host           : localhost:3312
 Source Schema         : db_ecommerce

 Target Server Type    : MySQL
 Target Server Version : 100421
 File Encoding         : 65001

 Date: 10/02/2022 11:47:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_addresses
-- ----------------------------
DROP TABLE IF EXISTS `tb_addresses`;
CREATE TABLE `tb_addresses`  (
  `idaddress` int NOT NULL AUTO_INCREMENT,
  `idperson` int NOT NULL,
  `desaddress` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `descomplement` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `descity` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `desstate` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `descountry` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nrzipcode` int NOT NULL,
  `dtregister` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`idaddress`) USING BTREE,
  INDEX `fk_addresses_persons_idx`(`idperson`) USING BTREE,
  CONSTRAINT `fk_addresses_persons` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_addresses
-- ----------------------------

-- ----------------------------
-- Table structure for tb_carts
-- ----------------------------
DROP TABLE IF EXISTS `tb_carts`;
CREATE TABLE `tb_carts`  (
  `idcart` int NOT NULL,
  `dessessionid` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `iduser` int NULL DEFAULT NULL,
  `idaddress` int NULL DEFAULT NULL,
  `vlfreight` decimal(10, 2) NULL DEFAULT NULL,
  `dtregister` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`idcart`) USING BTREE,
  INDEX `FK_carts_users_idx`(`iduser`) USING BTREE,
  INDEX `fk_carts_addresses_idx`(`idaddress`) USING BTREE,
  CONSTRAINT `fk_carts_addresses` FOREIGN KEY (`idaddress`) REFERENCES `tb_addresses` (`idaddress`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_carts_users` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_carts
-- ----------------------------

-- ----------------------------
-- Table structure for tb_cartsproducts
-- ----------------------------
DROP TABLE IF EXISTS `tb_cartsproducts`;
CREATE TABLE `tb_cartsproducts`  (
  `idcartproduct` int NOT NULL AUTO_INCREMENT,
  `idcart` int NOT NULL,
  `idproduct` int NOT NULL,
  `dtremoved` datetime(0) NOT NULL,
  `dtregister` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`idcartproduct`) USING BTREE,
  INDEX `FK_cartsproducts_carts_idx`(`idcart`) USING BTREE,
  INDEX `FK_cartsproducts_products_idx`(`idproduct`) USING BTREE,
  CONSTRAINT `fk_cartsproducts_carts` FOREIGN KEY (`idcart`) REFERENCES `tb_carts` (`idcart`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cartsproducts_products` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_cartsproducts
-- ----------------------------

-- ----------------------------
-- Table structure for tb_categories
-- ----------------------------
DROP TABLE IF EXISTS `tb_categories`;
CREATE TABLE `tb_categories`  (
  `idcategory` int NOT NULL AUTO_INCREMENT,
  `descategory` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dtregister` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`idcategory`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_categories
-- ----------------------------
INSERT INTO `tb_categories` VALUES (3, 'Apple', '2022-01-10 20:45:04');
INSERT INTO `tb_categories` VALUES (4, 'Android', '2022-01-10 21:00:52');
INSERT INTO `tb_categories` VALUES (5, 'Motorola', '2022-01-10 21:01:06');
INSERT INTO `tb_categories` VALUES (6, 'Sansung', '2022-01-10 21:01:37');
INSERT INTO `tb_categories` VALUES (7, 'Nokia', '2022-01-12 13:39:54');
INSERT INTO `tb_categories` VALUES (8, 'Xiaomi', '2022-01-17 21:06:46');

-- ----------------------------
-- Table structure for tb_orders
-- ----------------------------
DROP TABLE IF EXISTS `tb_orders`;
CREATE TABLE `tb_orders`  (
  `idorder` int NOT NULL AUTO_INCREMENT,
  `idcart` int NOT NULL,
  `iduser` int NOT NULL,
  `idstatus` int NOT NULL,
  `vltotal` decimal(10, 2) NOT NULL,
  `dtregister` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`idorder`) USING BTREE,
  INDEX `FK_orders_carts_idx`(`idcart`) USING BTREE,
  INDEX `FK_orders_users_idx`(`iduser`) USING BTREE,
  INDEX `fk_orders_ordersstatus_idx`(`idstatus`) USING BTREE,
  CONSTRAINT `fk_orders_carts` FOREIGN KEY (`idcart`) REFERENCES `tb_carts` (`idcart`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_ordersstatus` FOREIGN KEY (`idstatus`) REFERENCES `tb_ordersstatus` (`idstatus`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_users` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_orders
-- ----------------------------

-- ----------------------------
-- Table structure for tb_ordersstatus
-- ----------------------------
DROP TABLE IF EXISTS `tb_ordersstatus`;
CREATE TABLE `tb_ordersstatus`  (
  `idstatus` int NOT NULL AUTO_INCREMENT,
  `desstatus` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dtregister` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`idstatus`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_ordersstatus
-- ----------------------------
INSERT INTO `tb_ordersstatus` VALUES (1, 'Em Aberto', '2017-03-13 03:00:00');
INSERT INTO `tb_ordersstatus` VALUES (2, 'Aguardando Pagamento', '2017-03-13 03:00:00');
INSERT INTO `tb_ordersstatus` VALUES (3, 'Pago', '2017-03-13 03:00:00');
INSERT INTO `tb_ordersstatus` VALUES (4, 'Entregue', '2017-03-13 03:00:00');

-- ----------------------------
-- Table structure for tb_persons
-- ----------------------------
DROP TABLE IF EXISTS `tb_persons`;
CREATE TABLE `tb_persons`  (
  `idperson` int NOT NULL AUTO_INCREMENT,
  `desperson` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `desemail` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nrphone` bigint NULL DEFAULT NULL,
  `dtregister` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`idperson`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_persons
-- ----------------------------
INSERT INTO `tb_persons` VALUES (1, 'João Rangel', 'admin@hcode.com.br', 2147483647, '2017-03-01 03:00:00');
INSERT INTO `tb_persons` VALUES (7, 'Suporte', 'suporte@hcode.com.br', 1112345678, '2017-03-15 16:10:27');
INSERT INTO `tb_persons` VALUES (9, 'Jonas Leite', 'email@gmail.com', 19988887777, '2021-12-20 13:37:19');
INSERT INTO `tb_persons` VALUES (10, 'Gabriel Pelizario', 'email@email.com.br', 19988887777, '2022-01-03 19:19:38');
INSERT INTO `tb_persons` VALUES (11, 'Gabriel Pelizario', 'ge.pelizario@gmail.com', 19988887777, '2022-01-03 21:25:54');
INSERT INTO `tb_persons` VALUES (12, 'Damaris Pelizario', 'gabrielpelizario2013@gmail.com', 19988887777, '2022-01-04 19:17:36');

-- ----------------------------
-- Table structure for tb_products
-- ----------------------------
DROP TABLE IF EXISTS `tb_products`;
CREATE TABLE `tb_products`  (
  `idproduct` int NOT NULL AUTO_INCREMENT,
  `desproduct` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `vlprice` decimal(10, 2) NOT NULL,
  `vlwidth` decimal(10, 2) NOT NULL,
  `vlheight` decimal(10, 2) NOT NULL,
  `vllength` decimal(10, 2) NOT NULL,
  `vlweight` decimal(10, 2) NOT NULL,
  `desurl` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dtregister` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`idproduct`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_products
-- ----------------------------
INSERT INTO `tb_products` VALUES (4, 'Forno Micro-Ondas Electrolux Mtd30 20 Litros 110v', 490.99, 34.10, 28.90, 46.10, 11.40, 'Micro-Ondas Electrolux Mtd30', '2022-01-18 09:33:34');
INSERT INTO `tb_products` VALUES (5, 'Smart Tv Led 32\'\' Samsung Tizen Hd 32t4300', 1499.99, 15.00, 73.00, 46.00, 4.10, 'Smart Tv Led 32\'\' Samsung', '2022-01-20 17:34:18');
INSERT INTO `tb_products` VALUES (6, 'Smartphone Motorola Moto G5 Plus', 1135.23, 15.20, 7.40, 0.70, 0.16, 'smartphone-motorola-moto-g5-plus', '2022-01-25 09:26:48');
INSERT INTO `tb_products` VALUES (7, 'Smartphone Moto Z Play', 1887.78, 14.10, 0.90, 1.16, 0.13, 'smartphone-moto-z-play', '2022-01-25 09:26:48');
INSERT INTO `tb_products` VALUES (8, 'Smartphone Samsung Galaxy J5 Pro', 1299.00, 14.60, 7.10, 0.80, 0.16, 'smartphone-samsung-galaxy-j5', '2022-01-25 09:26:48');
INSERT INTO `tb_products` VALUES (9, 'Smartphone Samsung Galaxy J7 Prime', 1149.00, 15.10, 7.50, 0.80, 0.16, 'smartphone-samsung-galaxy-j7', '2022-01-25 09:26:48');
INSERT INTO `tb_products` VALUES (10, 'Smartphone Samsung Galaxy J3 Dual', 679.90, 14.20, 7.10, 0.70, 0.14, 'smartphone-samsung-galaxy-j3', '2022-01-25 09:26:48');

-- ----------------------------
-- Table structure for tb_productscategories
-- ----------------------------
DROP TABLE IF EXISTS `tb_productscategories`;
CREATE TABLE `tb_productscategories`  (
  `idcategory` int NOT NULL,
  `idproduct` int NOT NULL,
  PRIMARY KEY (`idcategory`, `idproduct`) USING BTREE,
  INDEX `fk_productscategories_products_idx`(`idproduct`) USING BTREE,
  CONSTRAINT `fk_productscategories_categories` FOREIGN KEY (`idcategory`) REFERENCES `tb_categories` (`idcategory`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_productscategories_products` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_productscategories
-- ----------------------------
INSERT INTO `tb_productscategories` VALUES (4, 6);
INSERT INTO `tb_productscategories` VALUES (4, 7);
INSERT INTO `tb_productscategories` VALUES (4, 8);
INSERT INTO `tb_productscategories` VALUES (4, 9);
INSERT INTO `tb_productscategories` VALUES (4, 10);
INSERT INTO `tb_productscategories` VALUES (5, 6);
INSERT INTO `tb_productscategories` VALUES (5, 7);
INSERT INTO `tb_productscategories` VALUES (6, 5);
INSERT INTO `tb_productscategories` VALUES (6, 8);
INSERT INTO `tb_productscategories` VALUES (6, 9);
INSERT INTO `tb_productscategories` VALUES (6, 10);

-- ----------------------------
-- Table structure for tb_users
-- ----------------------------
DROP TABLE IF EXISTS `tb_users`;
CREATE TABLE `tb_users`  (
  `iduser` int NOT NULL AUTO_INCREMENT,
  `idperson` int NOT NULL,
  `deslogin` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `despassword` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `inadmin` tinyint NOT NULL DEFAULT 0,
  `dtregister` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`iduser`) USING BTREE,
  INDEX `FK_users_persons_idx`(`idperson`) USING BTREE,
  CONSTRAINT `fk_users_persons` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_users
-- ----------------------------
INSERT INTO `tb_users` VALUES (1, 1, 'admin', '$2y$12$YlooCyNvyTji8bPRcrfNfOKnVMmZA9ViM2A3IpFjmrpIbp5ovNmga', 1, '2017-03-13 03:00:00');
INSERT INTO `tb_users` VALUES (7, 7, 'suporte', '$2y$12$HFjgUm/mk1RzTy4ZkJaZBe0Mc/BA2hQyoUckvm.lFa6TesjtNpiMe', 1, '2017-03-15 16:10:27');
INSERT INTO `tb_users` VALUES (9, 9, 'Jonas', 'root', 1, '2021-12-20 13:37:19');
INSERT INTO `tb_users` VALUES (10, 10, 'Gabriel', '$2y$12$VvkZUN84S3vhl7JMco5.W.7S5dPbi0wlPlbAnRYOv3W4oFPtJHp7S', 1, '2022-01-03 19:19:38');
INSERT INTO `tb_users` VALUES (11, 11, 'Gabriel', '$2y$12$.zBkAonDm11AaeouUfOXgOicyRisru.GDvJeyhOSXoP64aBWOZCFC', 1, '2022-01-03 21:25:54');
INSERT INTO `tb_users` VALUES (12, 12, 'damaris', '$2y$12$Nc6DotaF.yW7J5THMvs7QefKCDzcLS7vhU2Q.tjAWyMVTzY2nqG7S', 1, '2022-01-04 19:17:36');

-- ----------------------------
-- Table structure for tb_userslogs
-- ----------------------------
DROP TABLE IF EXISTS `tb_userslogs`;
CREATE TABLE `tb_userslogs`  (
  `idlog` int NOT NULL AUTO_INCREMENT,
  `iduser` int NOT NULL,
  `deslog` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `desip` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `desuseragent` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dessessionid` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `desurl` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dtregister` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`idlog`) USING BTREE,
  INDEX `fk_userslogs_users_idx`(`iduser`) USING BTREE,
  CONSTRAINT `fk_userslogs_users` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_userslogs
-- ----------------------------

-- ----------------------------
-- Table structure for tb_userspasswordsrecoveries
-- ----------------------------
DROP TABLE IF EXISTS `tb_userspasswordsrecoveries`;
CREATE TABLE `tb_userspasswordsrecoveries`  (
  `idrecovery` int NOT NULL AUTO_INCREMENT,
  `iduser` int NOT NULL,
  `desip` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dtrecovery` datetime(0) NULL DEFAULT NULL,
  `dtregister` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`idrecovery`) USING BTREE,
  INDEX `fk_userspasswordsrecoveries_users_idx`(`iduser`) USING BTREE,
  CONSTRAINT `fk_userspasswordsrecoveries_users` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_userspasswordsrecoveries
-- ----------------------------
INSERT INTO `tb_userspasswordsrecoveries` VALUES (1, 7, '127.0.0.1', NULL, '2017-03-15 16:10:59');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (2, 7, '127.0.0.1', '2017-03-15 13:33:45', '2017-03-15 16:11:18');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (3, 7, '127.0.0.1', '2017-03-15 13:37:35', '2017-03-15 16:37:12');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (4, 10, '127.0.0.1', NULL, '2022-01-03 19:20:01');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (5, 10, '127.0.0.1', NULL, '2022-01-03 19:47:52');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (6, 10, '127.0.0.1', NULL, '2022-01-03 20:19:20');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (7, 10, '127.0.0.1', NULL, '2022-01-03 20:24:49');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (8, 10, '127.0.0.1', NULL, '2022-01-03 20:28:28');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (9, 10, '127.0.0.1', NULL, '2022-01-03 20:35:06');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (10, 10, '127.0.0.1', NULL, '2022-01-03 20:39:31');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (11, 10, '127.0.0.1', NULL, '2022-01-03 20:46:54');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (12, 10, '127.0.0.1', NULL, '2022-01-03 20:47:37');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (13, 10, '127.0.0.1', NULL, '2022-01-03 20:48:26');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (14, 10, '127.0.0.1', NULL, '2022-01-03 20:50:19');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (15, 10, '127.0.0.1', NULL, '2022-01-03 20:51:04');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (16, 10, '127.0.0.1', NULL, '2022-01-03 20:54:13');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (17, 10, '127.0.0.1', NULL, '2022-01-03 20:55:51');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (18, 10, '127.0.0.1', NULL, '2022-01-03 20:56:51');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (19, 10, '127.0.0.1', NULL, '2022-01-03 21:11:58');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (20, 10, '127.0.0.1', NULL, '2022-01-03 21:15:07');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (21, 10, '127.0.0.1', NULL, '2022-01-03 21:18:42');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (22, 11, '127.0.0.1', NULL, '2022-01-03 21:26:08');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (23, 11, '127.0.0.1', NULL, '2022-01-03 21:34:31');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (24, 11, '127.0.0.1', NULL, '2022-01-03 21:35:36');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (25, 10, '127.0.0.1', NULL, '2022-01-04 09:30:37');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (26, 10, '127.0.0.1', NULL, '2022-01-04 09:53:22');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (27, 10, '127.0.0.1', NULL, '2022-01-04 09:58:58');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (28, 10, '127.0.0.1', NULL, '2022-01-04 10:30:47');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (29, 10, '127.0.0.1', NULL, '2022-01-04 13:55:46');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (30, 10, '127.0.0.1', NULL, '2022-01-04 15:14:19');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (31, 10, '127.0.0.1', NULL, '2022-01-04 16:16:27');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (32, 10, '127.0.0.1', NULL, '2022-01-04 18:04:15');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (33, 10, '127.0.0.1', '2022-01-04 19:13:57', '2022-01-04 19:10:26');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (34, 10, '127.0.0.1', NULL, '2022-01-04 19:19:06');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (35, 10, '127.0.0.1', NULL, '2022-01-04 19:20:46');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (36, 12, '127.0.0.1', '2022-01-04 19:26:57', '2022-01-04 19:26:14');
INSERT INTO `tb_userspasswordsrecoveries` VALUES (37, 12, '127.0.0.1', '2022-01-04 19:43:10', '2022-01-04 19:42:44');

-- ----------------------------
-- Procedure structure for sp_categories_save
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_categories_save`;
delimiter ;;
CREATE PROCEDURE `sp_categories_save`(pidcategory INT,
pdescategory VARCHAR(64))
BEGIN
	
	IF pidcategory > 0 THEN
		
		UPDATE tb_categories
        SET descategory = pdescategory
        WHERE idcategory = pidcategory;
        
    ELSE
		
		INSERT INTO tb_categories (descategory) VALUES(pdescategory);
        
        SET pidcategory = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_categories WHERE idcategory = pidcategory;
    
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for sp_products_save
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_products_save`;
delimiter ;;
CREATE PROCEDURE `sp_products_save`(pidproduct int(11),
pdesproduct varchar(64),
pvlprice decimal(10,2),
pvlwidth decimal(10,2),
pvlheight decimal(10,2),
pvllength decimal(10,2),
pvlweight decimal(10,2),
pdesurl varchar(128))
BEGIN
	
	IF pidproduct > 0 THEN
		
		UPDATE tb_products
        SET 
			desproduct = pdesproduct,
            vlprice = pvlprice,
            vlwidth = pvlwidth,
            vlheight = pvlheight,
            vllength = pvllength,
            vlweight = pvlweight,
            desurl = pdesurl
        WHERE idproduct = pidproduct;
        
    ELSE
		
		INSERT INTO tb_products (desproduct, vlprice, vlwidth, vlheight, vllength, vlweight, desurl) 
        VALUES(pdesproduct, pvlprice, pvlwidth, pvlheight, pvllength, pvlweight, pdesurl);
        
        SET pidproduct = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_products WHERE idproduct = pidproduct;
    
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for sp_userspasswordsrecoveries_create
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_userspasswordsrecoveries_create`;
delimiter ;;
CREATE PROCEDURE `sp_userspasswordsrecoveries_create`(piduser INT,
pdesip VARCHAR(45))
BEGIN
  
  INSERT INTO tb_userspasswordsrecoveries (iduser, desip)
    VALUES(piduser, pdesip);
    
    SELECT * FROM tb_userspasswordsrecoveries
    WHERE idrecovery = LAST_INSERT_ID();
    
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for sp_usersupdate_save
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_usersupdate_save`;
delimiter ;;
CREATE PROCEDURE `sp_usersupdate_save`(piduser INT,
pdesperson VARCHAR(64), 
pdeslogin VARCHAR(64), 
pdespassword VARCHAR(256), 
pdesemail VARCHAR(128), 
pnrphone BIGINT, 
pinadmin TINYINT)
BEGIN
  
    DECLARE vidperson INT;
    
  SELECT idperson INTO vidperson
    FROM tb_users
    WHERE iduser = piduser;
    
    UPDATE tb_persons
    SET 
    desperson = pdesperson,
        desemail = pdesemail,
        nrphone = pnrphone
  WHERE idperson = vidperson;
    
    UPDATE tb_users
    SET
    deslogin = pdeslogin,
        despassword = pdespassword,
        inadmin = pinadmin
  WHERE iduser = piduser;
    
    SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = piduser;
    
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for sp_users_delete
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_users_delete`;
delimiter ;;
CREATE PROCEDURE `sp_users_delete`(piduser INT)
BEGIN
  
    DECLARE vidperson INT;
    
  SELECT idperson INTO vidperson
    FROM tb_users
    WHERE iduser = piduser;
    
    DELETE FROM tb_users WHERE iduser = piduser;
    DELETE FROM tb_persons WHERE idperson = vidperson;
    
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for sp_users_save
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_users_save`;
delimiter ;;
CREATE PROCEDURE `sp_users_save`(pdesperson VARCHAR(64), 
pdeslogin VARCHAR(64), 
pdespassword VARCHAR(256), 
pdesemail VARCHAR(128), 
pnrphone BIGINT, 
pinadmin TINYINT)
BEGIN
  
    DECLARE vidperson INT;
    
  INSERT INTO tb_persons (desperson, desemail, nrphone)
    VALUES(pdesperson, pdesemail, pnrphone);
    
    SET vidperson = LAST_INSERT_ID();
    
    INSERT INTO tb_users (idperson, deslogin, despassword, inadmin)
    VALUES(vidperson, pdeslogin, pdespassword, pinadmin);
    
    SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = LAST_INSERT_ID();
    
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;

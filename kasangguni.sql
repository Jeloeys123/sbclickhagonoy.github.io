/*
 Navicat Premium Data Transfer

 Source Server         : LOCALHOST
 Source Server Type    : MySQL
 Source Server Version : 100138
 Source Host           : localhost:3306
 Source Schema         : kasangguni

 Target Server Type    : MySQL
 Target Server Version : 100138
 File Encoding         : 65001

 Date: 12/12/2022 01:25:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for announcement_mstr
-- ----------------------------
DROP TABLE IF EXISTS `announcement_mstr`;
CREATE TABLE `announcement_mstr`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `BRGYCODE` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ANNCODE` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TITLE` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `STARTDATE` date NOT NULL,
  `ENDDATE` date NOT NULL,
  `CONTENT` varchar(5000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `FILE` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `STATUS` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `REMARKS` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CREATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CREATEDDATE` date NOT NULL,
  `CREATEDTIME` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `UPDATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `UPDATEDDATE` date NOT NULL,
  `UPDATEDTIME` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of announcement_mstr
-- ----------------------------

-- ----------------------------
-- Table structure for barangay_mstr
-- ----------------------------
DROP TABLE IF EXISTS `barangay_mstr`;
CREATE TABLE `barangay_mstr`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `BRGYCODE` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `BRGYNAME` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `BRGYLOGO` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `BRGYLOCATION` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `EMPTEMPLATE` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CREATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CREATEDDATE` date NOT NULL,
  `CREATEDTIME` time(0) NOT NULL,
  `UPDATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `UPDATEDDATE` date NOT NULL,
  `UPDATEDTIME` time(0) NOT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of barangay_mstr
-- ----------------------------
INSERT INTO `barangay_mstr` VALUES (1, 'B031409001', 'Abulalas', 'Abulalas.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15426.185714039995!2d120.75455187684831!3d14.850692934295997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33965100ae0fe5af%3A0xf92a92d500fe7c25!2sAbulalas%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669533547517!5m2!1sen!2sph', 'SBABULALAS', 'SBADMIN2022-01', '2022-10-03', '00:00:00', 'SBABULALAS2022-01', '2022-12-11', '10:29:18');
INSERT INTO `barangay_mstr` VALUES (2, 'B031409002', 'Carillo', 'Carillo.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3856.3750940477876!2d120.7607426147623!3d14.860289739637473!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339651196756a3c5%3A0x28e5850da60c9829!2sCarillo%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669474391978!5m2!1sen!2sph', 'SBCARILLO', 'SBADMIN2022-01', '2022-10-03', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (3, 'B031409003', 'Iba', 'Iba.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61699.614753419344!2d120.72583709099324!3d14.868640245745896!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339650e01782e7df%3A0x95873272c7d646f2!2sIba%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669474535290!5m2!1sen!2sph', 'SBIBA', 'SBADMIN2022-01', '2022-10-03', '00:00:00', 'SBIBA2022-01', '2022-12-02', '03:43:55');
INSERT INTO `barangay_mstr` VALUES (4, 'B031409004', 'Iba-Ibayo', 'Iba-Ibayo.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61698.18230360743!2d120.7358928910094!3d14.873649744933454!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396513d289f95a1%3A0x80e69c4738ee73fc!2sIba-Ibayo%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669474633719!5m2!1sen!2sph', 'SBIBAIBAYO', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (5, 'B031409005', 'Mercado', 'Mercado.png', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61711.03256356306!2d120.67985709086398!3d14.828651252234236!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339650086f75f3eb%3A0x221ba5d32051d60!2sMercado%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669474831107!5m2!1sen!2sph', 'SBMERCADO', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (6, 'B031409006', 'Palapat', 'Palapat.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61702.34226593701!2d120.72009049096235!3d14.859097147293838!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339650e6b1c26ea3%3A0x53f2b539d4ddbc2e!2sPalapat%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669474931463!5m2!1sen!2sph', 'SBPALAPAT', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (7, 'B031409007', 'Pugad', 'Pugad.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61726.15983215563!2d120.70572289069261!3d14.775507560864959!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33964fb06e692a11%3A0x20d4b4908b3665e8!2sPugad%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669475001865!5m2!1sen!2sph', 'SBPUGAD', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (8, 'B031409008', 'Sagrada Familia', 'Sagrada Familia.png', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7714.400438009538!2d120.74093542415758!3d14.81401690866723!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33964fde8754e391%3A0xe30c3e169cb4b03f!2sSagrada%20Familia%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669475111640!5m2!1sen!2sph', 'SBSAGRADA', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (9, 'B031409009', 'San Agustin', 'San Agustin.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61706.55139761597!2d120.71434359091455!3d14.844358349685102!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396505a9808730b%3A0x1f2b6103e7d26c3b!2sSan%20Agustin%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669475183000!5m2!1sen!2sph', 'SBSANAGUSTIN', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (10, 'B031409010', 'San Isidro', 'San Isidro.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d32686.138500305035!2d120.7196376880467!3d14.856046283327304!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396509283201985%3A0xa2c6cc7b7e2e669e!2sSan%20Isidro%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669533722656!5m2!1sen!2sph', 'SBSANISIDRO', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (11, 'B031409011', 'San Jose', 'San Jose.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61709.4815370498!2d120.68704259088145!3d14.834089651351535!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396500a5abfef5b%3A0x78040d6238dbff11!2sSan%20Jose%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669475513218!5m2!1sen!2sph', 'SBSANJOSE', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (12, 'B031409012', 'San Juan', 'San Juan.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15425.309358659477!2d120.73874627685075!3d14.862963484171594!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339650eec731576f%3A0x6a4e207952b6f89a!2sSan%20Juan%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669475565752!5m2!1sen!2sph', 'SBSANJOSE', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (13, 'B031409013', 'San Miguel', 'San Miguel.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15425.982074727272!2d120.7352828768489!3d14.853545134267067!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33965058a262745b%3A0x4b6fd4f3a579aa9!2sSan%20Miguel%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669475588885!5m2!1sen!2sph', 'SBSANMIGUEL', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (14, 'B031409014', 'San Nicolas', 'San Nicolas.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7714.095529037824!2d120.7328259741578!3d14.822577158645514!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396503d4a479239%3A0x9e30970a97ddc7d6!2sSan%20Nicolas%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669475615528!5m2!1sen!2sph', 'SBSANNICOLAS', 'SBADMIN2022-01', '2022-10-07', '00:00:00', 'SBSANNICOLAS2022-01', '2022-12-12', '01:20:51');
INSERT INTO `barangay_mstr` VALUES (15, 'B031409015', 'San Pablo', 'San Pablo.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7713.742123036048!2d120.75059222415855!3d14.832492908620326!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396504a57883527%3A0xb11f1fe4dbc458eb!2sSan%20Pablo%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669475645902!5m2!1sen!2sph', 'SBSANPABLO', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (16, 'B031409016', 'San Pascual', 'San Pascual.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15428.94160287024!2d120.69025882684063!3d14.812040784688087!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396454e6d3a4895%3A0x390a1af891f90c64!2sSan%20Pascual%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669475705209!5m2!1sen!2sph', 'SBSANPASCUAL', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (17, 'B031409017', 'San Pedro', 'San Pedro.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15427.165520772742!2d120.74900807684558!3d14.836962134435243!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396504ccc7c0345%3A0x5630f15b6e4c6e7a!2sSan%20Pedro%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669475737009!5m2!1sen!2sph', 'SBSANPEDRO', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (18, 'B031409018', 'San Roque', 'San Roque.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61719.89695119526!2d120.6512305907635!3d14.797532357286956!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339645521fcfa821%3A0x8876faa93b52ff0f!2sSan%20Roque%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669475762565!5m2!1sen!2sph', 'SBSANROQUE', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (19, 'B031409019', 'San Sebastian', 'San Sebastian.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7713.816825959621!2d120.73584077415826!3d14.830397458625704!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396503f32c1f015%3A0x5aa05dadf44c956d!2sSan%20Sebastian%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669475782717!5m2!1sen!2sph', 'SBSANSEBASTIAN', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (20, 'B031409020', 'Santa Cruz', 'Santa Cruz.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3857.157930212577!2d120.71950011476162!3d14.816391889665326!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33964ffd61560103%3A0x3a4b72f5fdc516b2!2sSta.%20Cruz%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669475802186!5m2!1sen!2sph', 'SBSTACRUZ', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (21, 'B031409021', 'Santa Elena', 'Santa Elena.png', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30858.725997546426!2d120.73675891769575!3d14.806121888986075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33964fd442e05b25%3A0xa60060bebcacc7ee!2sSanta%20Elena%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669533917270!5m2!1sen!2sph', 'SBSTAELENA', 'SBADMIN2022-01', '2022-10-07', '00:00:00', 'SBSTAELENA2022-01', '2022-11-30', '11:37:17');
INSERT INTO `barangay_mstr` VALUES (22, 'B031409022', 'Santa Monica', 'Santa Monica.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15426.677933122206!2d120.71116442684696!3d14.843796634365935!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339650711afdf9fb%3A0x993ea2b49ded7d03!2sSanta%20Monica%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669475968099!5m2!1sen!2sph', 'SBSTAMONICA', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (23, 'B031409023', 'Santo Niño', 'Santo Niño.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7713.606055894588!2d120.73739362415853!3d14.836308908610658!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339650450963036f%3A0x615024528daf9987!2sSanto%20Ni%C3%B1o%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669475990723!5m2!1sen!2sph', 'SBSTANIÑO', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (24, 'B031409024', 'Santo Rosario', 'Santo Rosario.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3857.1132888495677!2d120.72422631476172!3d14.818898589663732!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396501b85e69735%3A0xf85d1a28961dc!2sSto.%20Rosario%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669476091344!5m2!1sen!2sph', 'SBSTOROSARIO', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (25, 'B031409025', 'Tampok', 'Tampok.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15425.754693500381!2d120.71411957684953!3d14.856729234234784!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33965087e5369345%3A0x751ac73e79848d75!2sTampok%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669476133739!5m2!1sen!2sph', 'SBTAMPOK', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_mstr` VALUES (26, 'B031409026', 'Tibaguin', 'Tibaguin.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30863.312105779645!2d120.74048451766996!3d14.77387319029569!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33964e534c899287%3A0x3e0b8aaf1594c080!2sTibaguin%2C%20Hagonoy%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1669476187292!5m2!1sen!2sph', 'SBTIBAGUIN', 'SBADMIN2022-01', '2022-10-07', '00:00:00', '', '0000-00-00', '00:00:00');

-- ----------------------------
-- Table structure for barangay_officials
-- ----------------------------
DROP TABLE IF EXISTS `barangay_officials`;
CREATE TABLE `barangay_officials`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `BRGYCODE` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `FIRSTNAME` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `MIDDLENAME` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `LASTNAME` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `SUFFIXNAME` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `EMAIL` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `MOBILE` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `POSITION` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TAG` int NOT NULL,
  `CREATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CREATEDDATE` date NOT NULL,
  `CREATEDTIME` time(0) NOT NULL,
  `UPDATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `UPDATEDDATE` date NOT NULL,
  `UPDATEDTIME` time(0) NOT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of barangay_officials
-- ----------------------------

-- ----------------------------
-- Table structure for barangay_profile
-- ----------------------------
DROP TABLE IF EXISTS `barangay_profile`;
CREATE TABLE `barangay_profile`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `BRGYCODE` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `EMAIL` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `MOBILE` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TELEPHONE` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `BIO` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `FBLINK` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CREATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CREATEDDATE` date NOT NULL,
  `CREATEDTIME` time(0) NOT NULL,
  `UPDATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `UPDATEDDATE` date NOT NULL,
  `UPDATEDTIME` time(0) NOT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of barangay_profile
-- ----------------------------
INSERT INTO `barangay_profile` VALUES (1, 'B031409014', 'sannicolas@gmail.com', '09565724852', '123123', 'asdasdasd', '', 'SBSANNICOLAS2022-01', '2022-12-12', '01:20:51', '', '0000-00-00', '00:00:00');

-- ----------------------------
-- Table structure for barangay_representative
-- ----------------------------
DROP TABLE IF EXISTS `barangay_representative`;
CREATE TABLE `barangay_representative`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ACCCODE` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `BRGYCODE` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `EMPCODE` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `FIRSTNAME` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `MIDDLENAME` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `LASTNAME` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `SUFFIXNAME` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `GENDER` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `EMAIL` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `MOBILE` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `POSITION` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ADDRESS` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `STARTDATE` date NOT NULL,
  `ENDDATE` date NOT NULL,
  `STATUS` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CREATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CREATEDDATE` date NOT NULL,
  `CREATEDTIME` time(0) NOT NULL,
  `UPDATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `UPDATEDDATE` date NOT NULL,
  `UPDATEDTIME` time(0) NOT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of barangay_representative
-- ----------------------------
INSERT INTO `barangay_representative` VALUES (1, 'ACC0000001', '', 'SBADMIN2022-01', 'Jelo', 'Bautista', 'Manalaysay', '', 'M', 'jelomanalaysay@gmail.com', '09656408317', '', 'San Nicolas Hagonoy Bulacan', '2022-12-04', '0000-00-00', 'ACTIVE', 'SBADMIN2022-01', '2022-12-04', '00:00:00', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_representative` VALUES (2, 'ACC0000002', 'B031409001', 'SBABULALAS2022-01', 'Harlene', 'V', 'Vita', '', 'F', 'sdfsdafsdf@gmail.com', '1237889', 'BS', 'hjdhjwefhwje', '2022-12-04', '0000-00-00', 'ACTIVE', 'SBADMIN2022-01', '2022-12-04', '06:45:17', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_representative` VALUES (3, 'ACC0000003', 'B031409001', 'SBABULALAS2022-02', 'adasd', 'asd', 'asdas', 'asd', 'M', 'asd@gmail.com', 'asd', 'SK', 'dasd', '2022-12-12', '0000-00-00', 'ACTIVE', 'SBADMIN2022-01', '2022-12-12', '12:30:14', '', '0000-00-00', '00:00:00');
INSERT INTO `barangay_representative` VALUES (4, 'ACC0000004', 'B031409014', 'SBSANNICOLAS2022-01', 'asdasdasd', '', 'asdasd', '', 'M', 'asd@gmail.com', '', 'BS', '', '2022-12-12', '0000-00-00', 'ACTIVE', 'SBADMIN2022-01', '2022-12-12', '01:19:05', '', '0000-00-00', '00:00:00');

-- ----------------------------
-- Table structure for demographic_mstr
-- ----------------------------
DROP TABLE IF EXISTS `demographic_mstr`;
CREATE TABLE `demographic_mstr`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `BRGYCODE` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CENSUSYEAR` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `HOUSEHOLD_POPULATION` int NOT NULL,
  `NUMBER_OF_HOUSEHOLDS` int NOT NULL,
  `AVERAGE_HOUSEHOLD` decimal(16, 2) NOT NULL,
  `CREATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CREATEDDATE` date NOT NULL,
  `CREATEDTIME` time(0) NOT NULL,
  `UPDATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `UPDATEDDATE` date NOT NULL,
  `UPDATEDTIME` time(0) NOT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of demographic_mstr
-- ----------------------------
INSERT INTO `demographic_mstr` VALUES (1, 'B031409001', '2020', 6522, 1334, 4.89, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (2, 'B031409002', '2020', 1808, 1339, 1.35, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (3, 'B031409003', '2020', 6466, 1333, 4.85, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (4, 'B031409004', '2020', 2791, 1335, 2.09, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (5, 'B031409005', '2020', 7286, 1334, 5.46, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (6, 'B031409006', '2020', 2342, 1338, 1.75, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (7, 'B031409007', '2020', 1636, 1330, 1.23, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (8, 'B031409008', '2020', 6494, 1333, 4.87, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (9, 'B031409009', '2020', 10387, 1335, 7.78, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (10, 'B031409010', '2020', 8489, 1335, 6.36, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (11, 'B031409011', '2020', 4275, 1336, 3.20, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (12, 'B031409012', '2020', 3700, 1336, 2.77, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (13, 'B031409013', '2020', 6167, 1335, 4.62, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (14, 'B031409014', '2020', 4642, 1334, 3.48, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (15, 'B031409015', '2020', 3470, 1335, 2.60, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (16, 'B031409016', '2020', 5754, 1335, 4.31, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (17, 'B031409017', '2020', 5698, 1334, 4.27, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (18, 'B031409018', '2020', 5197, 1336, 3.89, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (19, 'B031409019', '2020', 7522, 1334, 5.64, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (20, 'B031409020', '2020', 3223, 1332, 2.42, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (21, 'B031409021', '2020', 5494, 1334, 4.12, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (22, 'B031409022', '2020', 8168, 1335, 6.12, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (23, 'B031409023', '2020', 4554, 1335, 3.41, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (24, 'B031409024', '2020', 5052, 1333, 3.79, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (25, 'B031409025', '2020', 3011, 1332, 2.26, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');
INSERT INTO `demographic_mstr` VALUES (26, 'B031409026', '2020', 3300, 1336, 2.47, 'admin', '2022-10-09', '02:57:58', '', '0000-00-00', '00:00:00');

-- ----------------------------
-- Table structure for logs_mstr
-- ----------------------------
DROP TABLE IF EXISTS `logs_mstr`;
CREATE TABLE `logs_mstr`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `BRGYCODE` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `LOGSCODE` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `LOGTITLE` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `LOGDESC` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `STATUS` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `REMARKS` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `FILE` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CREATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CREATEDDATE` date NOT NULL,
  `CREATEDTIME` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `UPDATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `UPDATEDDATE` date NOT NULL,
  `UPDATEDTIME` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of logs_mstr
-- ----------------------------

-- ----------------------------
-- Table structure for notification_mstr
-- ----------------------------
DROP TABLE IF EXISTS `notification_mstr`;
CREATE TABLE `notification_mstr`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `BRGYCODE` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `NOTIFCODE` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `REFCODE` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ICON` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `MESSAGE` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TAG` int NOT NULL,
  `CREATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CREATEDDATE` date NOT NULL,
  `CREATEDTIME` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `UPDATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `UPDATEDDATE` date NOT NULL,
  `UPDATEDTIME` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of notification_mstr
-- ----------------------------

-- ----------------------------
-- Table structure for ordinance_mstr
-- ----------------------------
DROP TABLE IF EXISTS `ordinance_mstr`;
CREATE TABLE `ordinance_mstr`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `BRGYCODE` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ORDYEAR` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ORDCODE` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ORDTITLE` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `DESCRIPTION` varchar(5000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `EFFECTIVEDATE` date NOT NULL,
  `FILE` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `SUBMITTEDDATE` date NOT NULL,
  `STATUS` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `REMARKS` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CREATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CREATEDDATE` date NOT NULL,
  `CREATEDTIME` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `UPDATEDBY` varchar(0) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `UPDATEDDATE` date NOT NULL,
  `UPDATEDTIME` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ordinance_mstr
-- ----------------------------

-- ----------------------------
-- Table structure for position_mstr
-- ----------------------------
DROP TABLE IF EXISTS `position_mstr`;
CREATE TABLE `position_mstr`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `POSITIONCODE` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `DESCRIPTION` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CREATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CREATEDDATE` date NOT NULL,
  `CREATEDTIME` time(0) NOT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of position_mstr
-- ----------------------------
INSERT INTO `position_mstr` VALUES (1, 'PB', 'Punong Barangay', '', '0000-00-00', '00:00:00');
INSERT INTO `position_mstr` VALUES (2, 'SB', 'Sangguniang Barangay Member', '', '0000-00-00', '00:00:00');
INSERT INTO `position_mstr` VALUES (3, 'SK', 'SK Chairperson', '', '0000-00-00', '00:00:00');
INSERT INTO `position_mstr` VALUES (4, 'BS', 'Barangay Secretary', '', '0000-00-00', '00:00:00');

-- ----------------------------
-- Table structure for user_mstr
-- ----------------------------
DROP TABLE IF EXISTS `user_mstr`;
CREATE TABLE `user_mstr`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `BRGYCODE` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `EMPCODE` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `USERNAME` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `PASSWORD` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `USERTYPE` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `FIRSTLOGIN` int NOT NULL,
  `LOGINATTEMPT` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `STATUS` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CREATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CREATEDDATE` date NOT NULL,
  `CREATEDTIME` time(0) NOT NULL,
  `UPDATEDBY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `UPDATEDDATE` date NOT NULL,
  `UPDATEDTIME` time(0) NOT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user_mstr
-- ----------------------------
INSERT INTO `user_mstr` VALUES (1, '', 'SBADMIN2022-01', 'SBADMIN2022-01', '41646d696e313233', 'ADM', 0, '5', 'ACTIVE', 'SBADMIN2022-01', '2022-12-04', '00:00:00', 'SBADMIN2022-01', '2022-12-04', '06:32:54');
INSERT INTO `user_mstr` VALUES (2, 'B031409001', 'SBABULALAS2022-01', 'SBABULALAS2022-01', '73626162756c616c6173', 'USR', 0, '5', 'ACTIVE', 'SBADMIN2022-01', '2022-12-04', '06:45:17', 'SBADMIN2022-01', '2022-12-04', '07:17:07');
INSERT INTO `user_mstr` VALUES (3, 'B031409001', 'SBABULALAS2022-02', 'SBABULALAS2022-02', '53424142554c414c4153323032322d3032', 'USR', 1, '5', 'ACTIVE', 'SBADMIN2022-01', '2022-12-12', '12:30:14', '', '0000-00-00', '00:00:00');
INSERT INTO `user_mstr` VALUES (4, 'B031409014', 'SBSANNICOLAS2022-01', 'SBSANNICOLAS2022-01', '736273616e6e69636f6c6173', 'USR', 0, '5', 'ACTIVE', 'SBADMIN2022-01', '2022-12-12', '01:19:05', 'SBSANNICOLAS2022-01', '2022-12-12', '01:19:27');

SET FOREIGN_KEY_CHECKS = 1;

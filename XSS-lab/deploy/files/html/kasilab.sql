CREATE DATABASE IF NOT EXISTS `kasilab`  DEFAULT CHARACTER SET latin1;

USE `kasilab`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
/*
 Navicat Premium Data Transfer

 Source Server         : localweb
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : kasilab

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 23/04/2024 09:03:18
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `thoughts`;
CREATE TABLE `thoughts`  (
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`id` int(11)
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------


SET FOREIGN_KEY_CHECKS = 1;
CREATE USER 'kasihappy'@'localhost' IDENTIFIED BY 'what_can_i_say';
GRANT ALL ON *.* to 'kasihappy'@'localhost';


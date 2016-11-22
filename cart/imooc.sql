/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50624
Source Host           : localhost:3306
Source Database       : imooc

Target Server Type    : MYSQL
Target Server Version : 50624
File Encoding         : 65001

Date: 2016-11-22 14:55:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `shop_cart`
-- ----------------------------
DROP TABLE IF EXISTS `shop_cart`;
CREATE TABLE `shop_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(20) NOT NULL,
  `userid` int(20) NOT NULL,
  `num` int(10) NOT NULL,
  `price` float(8,2) NOT NULL,
  `createtime` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_cart
-- ----------------------------

-- ----------------------------
-- Table structure for `shop_product`
-- ----------------------------
DROP TABLE IF EXISTS `shop_product`;
CREATE TABLE `shop_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(255) NOT NULL,
  `describe` char(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `originalprice` decimal(10,2) NOT NULL,
  `inventory` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `brandid` int(11) NOT NULL,
  `adminid` int(11) NOT NULL,
  `ishot` int(11) NOT NULL,
  `isputaway` smallint(6) NOT NULL,
  `isonsale` smallint(6) NOT NULL,
  `onsaleprice` decimal(10,2) NOT NULL,
  `cover` char(200) NOT NULL,
  `updatetime` datetime NOT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_product
-- ----------------------------
INSERT INTO `shop_product` VALUES ('1', 'Apple/苹果 白色运动表带', null, '2588.00', '2588.00', '100', '1', '1', '1', '1', '1', '0', '0.00', '/resource/1.jpg', '2015-12-20 17:18:50', '1417013251');
INSERT INTO `shop_product` VALUES ('2', '苹果Apple Watch 薰衣草色表带', null, '2436.00', '2888.00', '100', '1', '1', '1', '1', '1', '0', '0.00', '/resource/2.jpg', '2015-12-20 17:18:50', '1447033051');

/*
Navicat MySQL Data Transfer

Source Server         : bendi
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : oa

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-05-04 16:12:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for gb_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `gb_admin_user`;
CREATE TABLE `gb_admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT '' COMMENT '用户名',
  `password` varchar(100) DEFAULT '' COMMENT '密码',
  `name` varchar(100) DEFAULT '' COMMENT '姓名',
  `sex` tinyint(2) DEFAULT '1' COMMENT '性别，1男，0女',
  `mobile` varchar(100) DEFAULT '' COMMENT '手机号',
  `phone` varchar(100) DEFAULT '' COMMENT '家庭电话',
  `address` varchar(255) DEFAULT '' COMMENT '家庭地址',
  `cret_no` varchar(32) DEFAULT '' COMMENT '身份证号',
  `contact_name` varchar(100) DEFAULT '' COMMENT '紧急联系人',
  `contact_phone` varchar(100) DEFAULT '' COMMENT '紧急联系人电话',
  `contact_info` varchar(100) DEFAULT '' COMMENT '紧急联系人关系',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态，1正常，2锁定',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `role_id` int(11) DEFAULT '0' COMMENT '角色id',
  `is_admin` tinyint(2) DEFAULT '0' COMMENT '是否为管理员',
  `deport_id` int(11) DEFAULT '0' COMMENT '部门id',
  `head_pic` varchar(255) DEFAULT '0' COMMENT '头像',
  `content` text COMMENT '描述',
  `email` varchar(255) DEFAULT '' COMMENT '邮箱',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '是否删除, 0未删除，1删除',
  `is_mail` tinyint(2) DEFAULT '0' COMMENT '是否发送邮件, 0不发送, 1发送',
  `is_test` tinyint(2) DEFAULT '0' COMMENT '是否为测试账号',
  `is_office` tinyint(2) DEFAULT '0' COMMENT '是否为办事处人员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_admin_user
-- ----------------------------
INSERT INTO `gb_admin_user` VALUES ('1', 'admin', 'b8f0534b96bfd4a519c4894e0be3b138', '系统管理员', '1', '', '', '', '', '', '', '', '0', '1', '0', '1', '1', '0', '0', '最高权限', '', '0', '0', '0', '0');
INSERT INTO `gb_admin_user` VALUES ('2', 'aaa', 'a40fabbb52f45b4b858e290e8d35aa6d', '', '0', '', '', '', '', '', '', '', '1477296120', '1', '1', '2', '0', '2', '/avatars/avatar0.png', '', '', '0', '0', '1', '0');
INSERT INTO `gb_admin_user` VALUES ('3', 'abc', 'f1422ae3142c033c40d6b622c2f6a005', '', '1', '15757831745', '', '', '', '', '', '', '1481773408', '1', '1', '3', '0', '3', '/avatars/avatar0.png', '', '', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for gb_admin_user_log
-- ----------------------------
DROP TABLE IF EXISTS `gb_admin_user_log`;
CREATE TABLE `gb_admin_user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_id` int(11) DEFAULT '0' COMMENT '对应id',
  `ptype` varchar(30) DEFAULT 'product' COMMENT '日志类型',
  `content` text COMMENT '修改内容',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '修改者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_admin_user_log
-- ----------------------------

-- ----------------------------
-- Table structure for gb_admin_user_show
-- ----------------------------
DROP TABLE IF EXISTS `gb_admin_user_show`;
CREATE TABLE `gb_admin_user_show` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(30) DEFAULT '' COMMENT '执行点击事件',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '用户id',
  `is_background` tinyint(2) DEFAULT '0' COMMENT '是否为背景',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_admin_user_show
-- ----------------------------

-- ----------------------------
-- Table structure for gb_businesses
-- ----------------------------
DROP TABLE IF EXISTS `gb_businesses`;
CREATE TABLE `gb_businesses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `address` varchar(255) DEFAULT '' COMMENT '出差地点',
  `input_time` int(11) DEFAULT '0' COMMENT '填写时间',
  `start_time` int(11) DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) DEFAULT '0' COMMENT '结束时间',
  `days` decimal(10,2) DEFAULT '0.00' COMMENT '天数',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `no` varchar(50) DEFAULT '' COMMENT '单据号',
  `deport_id` int(11) DEFAULT '0' COMMENT '部门ID',
  `note` varchar(500) DEFAULT '' COMMENT '备注',
  `transportation` varchar(255) DEFAULT '' COMMENT '交通方式',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_businesses
-- ----------------------------

-- ----------------------------
-- Table structure for gb_businesses_attaches
-- ----------------------------
DROP TABLE IF EXISTS `gb_businesses_attaches`;
CREATE TABLE `gb_businesses_attaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) DEFAULT '0' COMMENT '广博集团出差申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_businesses_attaches
-- ----------------------------

-- ----------------------------
-- Table structure for gb_businesses_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_businesses_status`;
CREATE TABLE `gb_businesses_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `businesses_id` int(11) DEFAULT '0' COMMENT '广博集团出差申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `status` int(11) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_businesses_status
-- ----------------------------

-- ----------------------------
-- Table structure for gb_category
-- ----------------------------
DROP TABLE IF EXISTS `gb_category`;
CREATE TABLE `gb_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '' COMMENT '产品名称',
  `number` varchar(50) DEFAULT '' COMMENT '产品货号，辅代码',
  `rank` int(11) DEFAULT '0' COMMENT '排序',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '是否删除',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_category
-- ----------------------------
INSERT INTO `gb_category` VALUES ('1', '1', '', '1', '0', '1', '1', '1479261684');
INSERT INTO `gb_category` VALUES ('2', '1', '', '1', '0', '1', '1', '1480322170');
INSERT INTO `gb_category` VALUES ('3', '1', '', '1', '0', '1', '1', '1480649119');

-- ----------------------------
-- Table structure for gb_classification
-- ----------------------------
DROP TABLE IF EXISTS `gb_classification`;
CREATE TABLE `gb_classification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '' COMMENT '产品名称',
  `number` varchar(50) DEFAULT '' COMMENT '产品货号',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `sub_category_id` int(11) DEFAULT '0' COMMENT '系列id',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '是否删除',
  `rank` int(11) DEFAULT '0' COMMENT '排序',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_classification
-- ----------------------------
INSERT INTO `gb_classification` VALUES ('1', '11', '', '11', '1', '0', '11', '1', '1479261741');

-- ----------------------------
-- Table structure for gb_colums_info
-- ----------------------------
DROP TABLE IF EXISTS `gb_colums_info`;
CREATE TABLE `gb_colums_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mall_colums_id` int(11) DEFAULT '0' COMMENT '商城字段id',
  `words` varchar(50) DEFAULT '' COMMENT '字段值',
  `shop_id` int(11) DEFAULT '0' COMMENT '商城id',
  `product_id` int(11) DEFAULT '0' COMMENT '产品id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_colums_info
-- ----------------------------

-- ----------------------------
-- Table structure for gb_count_info
-- ----------------------------
DROP TABLE IF EXISTS `gb_count_info`;
CREATE TABLE `gb_count_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mall_id` int(11) DEFAULT '0' COMMENT '商城id',
  `shop_id` int(11) DEFAULT '0' COMMENT '店铺id',
  `product_id` int(11) DEFAULT '0' COMMENT '产品id',
  `nstatus` int(11) DEFAULT '0' COMMENT '是否已上新，0未上新，1上新，2下架',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '提交者',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_count_info
-- ----------------------------

-- ----------------------------
-- Table structure for gb_count_info_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_count_info_status`;
CREATE TABLE `gb_count_info_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `count_info_id` int(11) DEFAULT '0' COMMENT '汇总id',
  `mall_status_id` int(11) DEFAULT '0' COMMENT '状态id，字段mall_colums表id',
  `status` tinyint(2) DEFAULT '0' COMMENT '状态，0未提交，1提交，2拒绝',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `checked_time` int(11) DEFAULT '0' COMMENT '审核通过时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_count_info_status
-- ----------------------------

-- ----------------------------
-- Table structure for gb_count_info_status_attach
-- ----------------------------
DROP TABLE IF EXISTS `gb_count_info_status_attach`;
CREATE TABLE `gb_count_info_status_attach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `count_info_status_id` int(11) DEFAULT '0' COMMENT '汇总id',
  `url` varchar(255) DEFAULT '' COMMENT '附件地址',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_count_info_status_attach
-- ----------------------------

-- ----------------------------
-- Table structure for gb_deport
-- ----------------------------
DROP TABLE IF EXISTS `gb_deport`;
CREATE TABLE `gb_deport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '' COMMENT '部门名称',
  `content` text COMMENT '部门描述',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `rank` int(11) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_deport
-- ----------------------------
INSERT INTO `gb_deport` VALUES ('1', '系统管理部门', '系统管理部门', '0', '0', '0', '0');
INSERT INTO `gb_deport` VALUES ('2', 'a', '', '1477296088', '0', '1', '1');
INSERT INTO `gb_deport` VALUES ('3', ' aa', '', '1481773306', '0', '1', '0');

-- ----------------------------
-- Table structure for gb_deport_message
-- ----------------------------
DROP TABLE IF EXISTS `gb_deport_message`;
CREATE TABLE `gb_deport_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deport_id` int(11) DEFAULT '0' COMMENT '部门id',
  `msg` text COMMENT '内容',
  `create_time` int(11) DEFAULT '0' COMMENT '时间',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_deport_message
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_businesses
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_businesses`;
CREATE TABLE `gb_do_businesses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(255) DEFAULT '' COMMENT '流程名称',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `start_time` int(11) DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) DEFAULT '0' COMMENT '结束时间',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `no` varchar(50) DEFAULT '' COMMENT '单据号',
  `office_id` int(11) DEFAULT '0' COMMENT '办事处',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_businesses
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_businesses_attaches
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_businesses_attaches`;
CREATE TABLE `gb_do_businesses_attaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_leaves_id` int(11) DEFAULT '0' COMMENT '内销办事处出差申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_businesses_attaches
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_businesses_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_businesses_status`;
CREATE TABLE `gb_do_businesses_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_business_id` int(11) DEFAULT '0' COMMENT '内销办事处出差申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_businesses_status
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_customer_returns
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_customer_returns`;
CREATE TABLE `gb_do_customer_returns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `office_id` int(11) DEFAULT '0' COMMENT '办事处id',
  `user_name` varchar(100) DEFAULT '0' COMMENT '客户名称',
  `reason` varchar(255) DEFAULT '' COMMENT '退货原因',
  `succ_num` int(11) DEFAULT '0' COMMENT '总合格',
  `warn_num` int(11) DEFAULT '0' COMMENT '总待修',
  `err_num` int(11) DEFAULT '0' COMMENT '总报废',
  `user_rate` decimal(10,2) DEFAULT '0.00' COMMENT '客户年累计退货率',
  `warn_rate` decimal(10,2) DEFAULT '0.00' COMMENT '客户年累计报损率',
  `do_user_rate` decimal(10,2) DEFAULT '0.00' COMMENT '办事处年累计退货率',
  `do_warn_rate` decimal(10,2) DEFAULT '0.00' COMMENT '办事处年累计报损率',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `no` varchar(100) DEFAULT '' COMMENT '单据号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_customer_returns
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_customer_return_attaches
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_customer_return_attaches`;
CREATE TABLE `gb_do_customer_return_attaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_customer_return_id` int(11) DEFAULT '0' COMMENT '内销市场客户退货申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_customer_return_attaches
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_customer_return_items
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_customer_return_items`;
CREATE TABLE `gb_do_customer_return_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_customer_return_id` int(11) DEFAULT '0' COMMENT '内销市场客户退货申请单id',
  `attr_name` varchar(100) DEFAULT '' COMMENT '属性',
  `number` varchar(100) DEFAULT '0' COMMENT '型号',
  `name` varchar(100) DEFAULT '0' COMMENT '名称',
  `num` varchar(100) DEFAULT '0' COMMENT '数量',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '单价',
  `total_price` decimal(10,2) DEFAULT '0.00' COMMENT '金额',
  `status` tinyint(2) DEFAULT '0' COMMENT '仓库主管确认类型：0未确认，1合格，2待修，3报废',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_customer_return_items
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_customer_return_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_customer_return_status`;
CREATE TABLE `gb_do_customer_return_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_customer_return_id` int(11) DEFAULT '0' COMMENT '内销市场客户退货申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `status` tinyint(3) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(100) DEFAULT '' COMMENT '附件地址',
  `name` varchar(100) DEFAULT '' COMMENT '附件说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_customer_return_status
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_designs
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_designs`;
CREATE TABLE `gb_do_designs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `office_id` int(11) DEFAULT '0' COMMENT '办事处经理',
  `salesman` varchar(100) DEFAULT '' COMMENT '业务员',
  `apply_time` int(11) DEFAULT '0' COMMENT '申请时间',
  `qq` varchar(100) DEFAULT '' COMMENT '广告设计后接收人QQ号',
  `shop_name` varchar(100) DEFAULT '' COMMENT '店铺',
  `management_name` varchar(100) DEFAULT '' COMMENT '经营负责人',
  `phone` varchar(255) DEFAULT '' COMMENT '联系电话',
  `address` varchar(255) DEFAULT '' COMMENT '联系地址',
  `distributor_name` varchar(100) DEFAULT '' COMMENT '上级经销商',
  `shop_type` tinyint(2) DEFAULT '0' COMMENT '会员店形式，1原广博终端店升级为会员店，2新开会员店',
  `qy_type` tinyint(2) DEFAULT '0' COMMENT '签约方式，1销售合同，2三方协议',
  `qy_price` decimal(10,2) DEFAULT '0.00' COMMENT '签约金额',
  `first_price` decimal(10,2) DEFAULT '0.00' COMMENT '首次进货金额',
  `first_num` int(11) DEFAULT '0' COMMENT '首次进货数量',
  `gg_num` int(11) DEFAULT '0' COMMENT '高柜',
  `zd_num` int(11) DEFAULT '0' COMMENT '中岛',
  `publish_con` varchar(100) DEFAULT '' COMMENT '广告发布（店招/室内）',
  `user_type` int(11) DEFAULT '0' COMMENT '客户类型：1托盘商/合作办事处，2核心客户，3重点客户，4生意客户',
  `content` varchar(255) DEFAULT '' COMMENT '备注',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '所需费用',
  `wh_content` varchar(255) DEFAULT '' COMMENT '室内广告（宽*高）设计中需增加任何产品形像图的请说明',
  `other_content` varchar(255) DEFAULT '' COMMENT '其它物料',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `no` varchar(50) DEFAULT '' COMMENT '单据号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_designs
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_design_attaches
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_design_attaches`;
CREATE TABLE `gb_do_design_attaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_design_id` int(11) DEFAULT '0' COMMENT '内销广告设计制作申请表id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_design_attaches
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_design_items
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_design_items`;
CREATE TABLE `gb_do_design_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_design_id` int(11) DEFAULT '0' COMMENT '内销广告设计制作申请表id',
  `order_time` int(11) DEFAULT '0' COMMENT '日期',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '进货金额',
  `num` int(11) DEFAULT '0' COMMENT '品项数量',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_design_items
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_design_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_design_status`;
CREATE TABLE `gb_do_design_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_design_id` int(11) DEFAULT '0' COMMENT '内销广告设计制作申请表id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `status` tinyint(3) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_design_status
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_explosions
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_explosions`;
CREATE TABLE `gb_do_explosions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) DEFAULT '' COMMENT '客户名称',
  `shop_name` varchar(255) DEFAULT '' COMMENT '店铺名称',
  `shop_year` varchar(255) DEFAULT '' COMMENT '年度指标',
  `shop_type` varchar(255) DEFAULT '' COMMENT '店铺类型及等级',
  `shop_url` varchar(255) DEFAULT '' COMMENT '店铺链接',
  `activity_time` int(11) DEFAULT '0' COMMENT '活动时间',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `no` varchar(100) DEFAULT '' COMMENT '单据号',
  `platform` varchar(100) DEFAULT '' COMMENT '活动平台',
  `activity_cost` decimal(10,2) DEFAULT '0.00' COMMENT '活动付费',
  `explosion_goal` varchar(255) DEFAULT '' COMMENT '爆款目的',
  `related_products` varchar(255) DEFAULT '' COMMENT '关联销售产品',
  `last_month_sales` int(7) DEFAULT '0' COMMENT '上月店铺销量',
  `last_week_sales` int(7) DEFAULT '0' COMMENT '上周店铺销量',
  `gb_sale_items` int(7) DEFAULT '0' COMMENT '广博在售单品数',
  `poi` float DEFAULT '0' COMMENT '转化率',
  `content` varchar(255) DEFAULT '' COMMENT '爆款单品政策内容说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_explosions
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_explosion_attaches
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_explosion_attaches`;
CREATE TABLE `gb_do_explosion_attaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_explosion_id` int(11) DEFAULT '0' COMMENT '内销办事处电商爆款申请表id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_explosion_attaches
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_explosion_items
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_explosion_items`;
CREATE TABLE `gb_do_explosion_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_explosion_id` int(11) DEFAULT '0' COMMENT '内销办事处电商爆款申请表id',
  `product_id` int(11) DEFAULT '0' COMMENT '产品id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `apply_price` decimal(10,2) DEFAULT '0.00' COMMENT '申请价格',
  `apply_num` int(11) DEFAULT '0' COMMENT '申请数量',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '零售价',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_explosion_items
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_explosion_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_explosion_status`;
CREATE TABLE `gb_do_explosion_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_explosion_id` int(11) DEFAULT '0' COMMENT '内销办事处电商爆款申请表id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `status` tinyint(2) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(100) DEFAULT '' COMMENT '附件地址',
  `name` varchar(100) DEFAULT '' COMMENT '附件说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_explosion_status
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_leaves
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_leaves`;
CREATE TABLE `gb_do_leaves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `ptype` int(11) DEFAULT '0' COMMENT '请假类别：1探亲假，2事假，3病假，4婚假，5丧假，6公假，7工伤，8产假，9其他',
  `start_time` int(11) DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) DEFAULT '0' COMMENT '结束时间',
  `days` decimal(10,2) DEFAULT '0.00' COMMENT '所用时间',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `no` varchar(50) DEFAULT '' COMMENT '单据号',
  `deport_id` int(11) DEFAULT '0' COMMENT '部门ID',
  `job` varchar(255) DEFAULT '' COMMENT '职务',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_leaves
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_leaves_attaches
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_leaves_attaches`;
CREATE TABLE `gb_do_leaves_attaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_leaves_id` int(11) DEFAULT '0' COMMENT '内销办事处请假单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_leaves_attaches
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_leaves_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_leaves_status`;
CREATE TABLE `gb_do_leaves_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leaves_id` int(11) DEFAULT '0' COMMENT '内销办事处请假单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `status` int(11) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_leaves_status
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_out_orders
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_out_orders`;
CREATE TABLE `gb_do_out_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `office_id` int(11) DEFAULT '0' COMMENT '办事外/人员',
  `address` varchar(100) DEFAULT '' COMMENT '前往何处',
  `lw_time` int(11) DEFAULT '0' COMMENT '来往时间',
  `content` varchar(255) DEFAULT '' COMMENT '事由',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `no` varchar(50) DEFAULT '' COMMENT '单据号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_out_orders
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_out_order_attaches
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_out_order_attaches`;
CREATE TABLE `gb_do_out_order_attaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_out_order_id` int(11) DEFAULT '0' COMMENT '内销办事处临时外出单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_out_order_attaches
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_out_order_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_out_order_status`;
CREATE TABLE `gb_do_out_order_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_out_order_id` int(11) DEFAULT '0' COMMENT '内销办事处临时外出单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_out_order_status
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_overdue_deliveries
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_overdue_deliveries`;
CREATE TABLE `gb_do_overdue_deliveries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `office_id` int(11) DEFAULT '0' COMMENT '部门/业务员',
  `apply_time` int(11) DEFAULT '0' COMMENT '申请时间',
  `user_name` varchar(255) DEFAULT '' COMMENT '客户名称',
  `apply_type` decimal(10,2) DEFAULT '0.00' COMMENT '申请性质',
  `credit_price` decimal(10,2) DEFAULT '0.00' COMMENT '授信额度',
  `flow_price` decimal(10,2) DEFAULT '0.00' COMMENT '超额金额',
  `days` int(11) DEFAULT '0' COMMENT '付款期限',
  `total_price` decimal(10,2) DEFAULT '0.00' COMMENT '应收款金额',
  `flow_time` int(11) DEFAULT '0' COMMENT '超期时间',
  `flow_time_price` decimal(10,2) DEFAULT '0.00' COMMENT '超期金额',
  `apply_delivery_num` int(11) DEFAULT '0' COMMENT '申请发货数',
  `delivery_price` decimal(10,2) DEFAULT '0.00' COMMENT '发货金额',
  `content` varchar(255) DEFAULT '' COMMENT '备注或原因',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `no` varchar(100) DEFAULT '' COMMENT '单据号',
  `is_del` tinyint(1) DEFAULT '0' COMMENT '是否被删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_overdue_deliveries
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_overdue_delivery_attaches
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_overdue_delivery_attaches`;
CREATE TABLE `gb_do_overdue_delivery_attaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_overdue_delivery_id` int(11) DEFAULT '0' COMMENT '内销超额超期发货申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_overdue_delivery_attaches
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_overdue_delivery_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_overdue_delivery_status`;
CREATE TABLE `gb_do_overdue_delivery_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_overdue_delivery_id` int(11) DEFAULT '0' COMMENT '内销超额超期发货申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `status` tinyint(2) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(100) DEFAULT '' COMMENT '附件地址',
  `name` varchar(100) DEFAULT '' COMMENT '附件说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_overdue_delivery_status
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_post_codes
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_post_codes`;
CREATE TABLE `gb_do_post_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `market_name` varchar(100) DEFAULT '' COMMENT '超市名称',
  `shop_name` varchar(100) DEFAULT '' COMMENT '店别',
  `reason` varchar(255) DEFAULT '' COMMENT '贴码原因',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `no` varchar(50) DEFAULT '' COMMENT '单据号',
  `office_id` int(11) DEFAULT '0' COMMENT '办事处',
  `apply_time` int(11) DEFAULT '0' COMMENT '申请日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_post_codes
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_post_code_attaches
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_post_code_attaches`;
CREATE TABLE `gb_do_post_code_attaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_post_code_id` int(11) DEFAULT '0' COMMENT '内销贴码产品申请流程单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_post_code_attaches
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_post_code_products
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_post_code_products`;
CREATE TABLE `gb_do_post_code_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_post_code_id` int(11) DEFAULT '0' COMMENT '内销贴码产品申请流程单id',
  `product_id` int(11) DEFAULT '0' COMMENT '产品id',
  `change_id` int(11) DEFAULT '0' COMMENT '替代产品id',
  `plan_order_price` decimal(10,2) DEFAULT '0.00' COMMENT '订单计划单价',
  `plan_change_price` decimal(10,2) DEFAULT '0.00' COMMENT '替代计划单价',
  `unit` varchar(20) DEFAULT '' COMMENT '单位',
  `num` int(11) DEFAULT '0' COMMENT '数量',
  `status` tinyint(2) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `barcode` varchar(50) DEFAULT '' COMMENT '贴码条形码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_post_code_products
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_post_code_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_post_code_status`;
CREATE TABLE `gb_do_post_code_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_post_code_id` int(11) DEFAULT '0' COMMENT '内销贴码产品申请流程单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `status` tinyint(2) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_post_code_status
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_promotions
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_promotions`;
CREATE TABLE `gb_do_promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `send_time` int(11) DEFAULT '0' COMMENT '提交时间',
  `user_name` varchar(100) DEFAULT '' COMMENT '客户名称',
  `no` varchar(50) DEFAULT '' COMMENT '合同号',
  `ht_time` int(11) DEFAULT '0' COMMENT '合同时间',
  `promotion_content` varchar(255) DEFAULT '' COMMENT '促销内容说明',
  `main_content` varchar(255) DEFAULT '' COMMENT '重点产口需求说明',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '应收货款金额',
  `promotion_credit` decimal(10,2) DEFAULT '0.00' COMMENT '促销额度',
  `promotion_start_time` int(11) DEFAULT '0' COMMENT '促销活动开始时间',
  `promotion_end_time` int(11) DEFAULT '0' COMMENT '促销活动结束时间',
  `over_price` decimal(10,2) DEFAULT '0.00' COMMENT '到期货款金额',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_promotions
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_promotion_attaches
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_promotion_attaches`;
CREATE TABLE `gb_do_promotion_attaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_promotion_id` int(11) DEFAULT '0' COMMENT '内销办事处促销申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_promotion_attaches
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_promotion_meetings
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_promotion_meetings`;
CREATE TABLE `gb_do_promotion_meetings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) DEFAULT '' COMMENT '客户名称',
  `address` varchar(255) DEFAULT '' COMMENT '会议地点',
  `meeting_time` int(11) DEFAULT '0' COMMENT '会议时间',
  `zc_lh` varchar(50) DEFAULT '' COMMENT '专场/联合',
  `plan_price` decimal(10,2) DEFAULT '0.00' COMMENT '预计销售目标（万）',
  `back_price` decimal(10,2) DEFAULT '0.00' COMMENT '计划回款（万）',
  `back_end_time` int(11) DEFAULT '0' COMMENT '汇款时间截止',
  `ptype` int(11) DEFAULT '0' COMMENT '会议目的，1新客户开发，2产品推广（重点产品推进），3客户产品扩充，4客户维护，5新区域品牌推广，6销售提升',
  `zc_time` int(11) DEFAULT '0' COMMENT '政策时间',
  `content` varchar(255) DEFAULT '' COMMENT '促销产品及政策',
  `ad_content` varchar(255) DEFAULT '' COMMENT '广告制作例费用说明',
  `fixed_price` decimal(10,2) DEFAULT '0.00' COMMENT '固定会议费',
  `wl_content` varchar(255) DEFAULT '' COMMENT '物料申请',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `no` varchar(50) DEFAULT '' COMMENT '单据号',
  `is_del` int(11) DEFAULT '0' COMMENT '是否删除，0：未删除，1：删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_promotion_meetings
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_promotion_meeting_attaches
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_promotion_meeting_attaches`;
CREATE TABLE `gb_do_promotion_meeting_attaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_promotion_meeting_id` int(11) DEFAULT '0' COMMENT '公司临时审批表id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_promotion_meeting_attaches
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_promotion_meeting_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_promotion_meeting_status`;
CREATE TABLE `gb_do_promotion_meeting_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_promotion_meeting_id` int(11) DEFAULT '0' COMMENT '公司临时审批表id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(2) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_promotion_meeting_status
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_promotion_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_promotion_status`;
CREATE TABLE `gb_do_promotion_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_promotion_id` int(11) DEFAULT '0' COMMENT '内销办事处促销申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `status` tinyint(2) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_promotion_status
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_propagandas
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_propagandas`;
CREATE TABLE `gb_do_propagandas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naddress` varchar(255) DEFAULT '' COMMENT '区域市场',
  `office_id` int(11) DEFAULT '0' COMMENT '办事处经理',
  `salesman` varchar(100) DEFAULT '' COMMENT '业务员',
  `apply_time` int(11) DEFAULT '0' COMMENT '申请时间',
  `qq` varchar(100) DEFAULT '' COMMENT '广告设计后接收人QQ号',
  `shop_name` varchar(100) DEFAULT '' COMMENT '店名',
  `management_name` varchar(100) DEFAULT '' COMMENT '经营负责人',
  `phone` varchar(255) DEFAULT '' COMMENT '联系电话',
  `address` varchar(255) DEFAULT '' COMMENT '联系地址',
  `distributor_name` varchar(100) DEFAULT '' COMMENT '上级经销商',
  `shop_type` tinyint(2) DEFAULT '0' COMMENT '会员店形式，1原广博终端店升级为会员店，2新开会员店',
  `qy_type` tinyint(2) DEFAULT '0' COMMENT '签约方式，1销售合同，2三方协议',
  `qy_price` decimal(10,2) DEFAULT '0.00' COMMENT '签约金额',
  `first_price` decimal(10,2) DEFAULT '0.00' COMMENT '首次进货金额',
  `first_num` int(11) DEFAULT '0' COMMENT '首次进货数量',
  `gg_num` int(11) DEFAULT '0' COMMENT '高柜',
  `zd_num` int(11) DEFAULT '0' COMMENT '中岛',
  `publish_con` varchar(100) DEFAULT '' COMMENT '广告发布（店招/室内）',
  `user_type` int(11) DEFAULT '0' COMMENT '客户类型：1托盘商/合作办事处，2核心客户，3重点客户，4生意客户',
  `g_num` int(11) DEFAULT '0' COMMENT '高柜',
  `z_num` int(11) DEFAULT '0' COMMENT '中柜',
  `o_num` int(11) DEFAULT '0' COMMENT '其他',
  `content` varchar(255) DEFAULT '' COMMENT '备注',
  `wl_name` varchar(100) DEFAULT '' COMMENT '名称及数量',
  `other_content` varchar(255) DEFAULT '' COMMENT '其它物料',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `no` varchar(50) DEFAULT '' COMMENT '单据号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_propagandas
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_propaganda_attaches
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_propaganda_attaches`;
CREATE TABLE `gb_do_propaganda_attaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_propaganda_id` int(11) DEFAULT '0' COMMENT '内销广告宣传物料申请表id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_propaganda_attaches
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_propaganda_items
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_propaganda_items`;
CREATE TABLE `gb_do_propaganda_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_propaganda_id` int(11) DEFAULT '0' COMMENT '内销广告宣传物料申请表id',
  `order_time` int(11) DEFAULT '0' COMMENT '日期',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '进货金额',
  `num` int(11) DEFAULT '0' COMMENT '品项数量',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_propaganda_items
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_propaganda_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_propaganda_status`;
CREATE TABLE `gb_do_propaganda_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_propaganda_id` int(11) DEFAULT '0' COMMENT '内销广告宣传物料申请表id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `status` tinyint(2) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_propaganda_status
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_turn_goods
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_turn_goods`;
CREATE TABLE `gb_do_turn_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `office_id` int(11) DEFAULT '0' COMMENT '办事外/人员',
  `phone` varchar(50) DEFAULT '' COMMENT '电话',
  `postage` decimal(10,2) DEFAULT '0.00' COMMENT '邮费',
  `consignee` varchar(100) DEFAULT '' COMMENT '收货人',
  `address` varchar(255) DEFAULT '' COMMENT '地址',
  `reason` varchar(255) DEFAULT '' COMMENT '调货原因',
  `tg_time` int(11) DEFAULT '0' COMMENT '调货时间',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_turn_goods
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_turn_good_attaches
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_turn_good_attaches`;
CREATE TABLE `gb_do_turn_good_attaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_turn_good_id` int(11) DEFAULT '0' COMMENT '内销办事处调货报告id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_turn_good_attaches
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_turn_good_items
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_turn_good_items`;
CREATE TABLE `gb_do_turn_good_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_turn_good_id` int(11) DEFAULT '0' COMMENT '内销办事处调货报告id',
  `number` varchar(50) DEFAULT '' COMMENT '物料编码',
  `name` varchar(100) DEFAULT '' COMMENT '物料名称',
  `num` int(11) DEFAULT '0' COMMENT '件数',
  `office_id` int(11) DEFAULT '0' COMMENT '调出办事处',
  `content` varchar(255) DEFAULT '' COMMENT '备注',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_turn_good_items
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_turn_good_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_turn_good_status`;
CREATE TABLE `gb_do_turn_good_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_turn_good_id` int(11) DEFAULT '0' COMMENT '内销办事处调货报告id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_turn_good_status
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_uses
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_uses`;
CREATE TABLE `gb_do_uses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reason` varchar(255) DEFAULT '' COMMENT '领用原因',
  `is_back` tinyint(2) DEFAULT '0' COMMENT '是否归还',
  `back_time` int(11) DEFAULT '0' COMMENT '归还时间',
  `is_return` tinyint(2) DEFAULT '0' COMMENT '是否无法归还',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_uses
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_use_attaches
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_use_attaches`;
CREATE TABLE `gb_do_use_attaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_use_id` int(11) DEFAULT '0' COMMENT '内销办事处领用申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_use_attaches
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_use_items
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_use_items`;
CREATE TABLE `gb_do_use_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_use_id` int(11) DEFAULT '0' COMMENT '内销办事处领用申请单id',
  `product_id` int(11) DEFAULT '0' COMMENT '产品id',
  `num` int(11) DEFAULT '0' COMMENT '数量',
  `unit` varchar(30) DEFAULT '' COMMENT '单位',
  `content` varchar(255) DEFAULT '' COMMENT '备注',
  `back_num` int(11) DEFAULT '0' COMMENT '归还数量',
  `back_time` int(11) DEFAULT '0' COMMENT '归还时间',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_use_items
-- ----------------------------

-- ----------------------------
-- Table structure for gb_do_use_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_do_use_status`;
CREATE TABLE `gb_do_use_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_use_id` int(11) DEFAULT '0' COMMENT '内销办事处领用申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `status` tinyint(2) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_do_use_status
-- ----------------------------

-- ----------------------------
-- Table structure for gb_items
-- ----------------------------
DROP TABLE IF EXISTS `gb_items`;
CREATE TABLE `gb_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '' COMMENT '项目名称',
  `ptype_id` int(11) DEFAULT '0' COMMENT '项目分类id',
  `content` text COMMENT '项目描述',
  `creater_id` int(11) DEFAULT '0' COMMENT '提交项目者id',
  `create_time` int(11) DEFAULT '0' COMMENT '项目创建时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新项目时间',
  `status` int(11) DEFAULT '0' COMMENT '项目状态',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '项目是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建人id',
  `rank` int(11) DEFAULT '0' COMMENT '排序值',
  `number` varchar(100) DEFAULT '' COMMENT '货号',
  `is_over` tinyint(2) DEFAULT '0' COMMENT '是否结束',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_items
-- ----------------------------

-- ----------------------------
-- Table structure for gb_items_attach
-- ----------------------------
DROP TABLE IF EXISTS `gb_items_attach`;
CREATE TABLE `gb_items_attach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT '0' COMMENT '项目id',
  `name` varchar(100) DEFAULT '' COMMENT '分类名称',
  `durl` varchar(255) DEFAULT '' COMMENT '附件下载地址',
  `create_time` int(11) DEFAULT '0' COMMENT '添加附件时间',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '提交者id',
  `item_status_id` int(11) DEFAULT '0' COMMENT '当前状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_items_attach
-- ----------------------------

-- ----------------------------
-- Table structure for gb_item_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_item_status`;
CREATE TABLE `gb_item_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ptype_status_id` int(11) DEFAULT '0' COMMENT '分类状态id',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `item_id` int(11) DEFAULT '0' COMMENT '项目id',
  `create_time` int(11) DEFAULT '0' COMMENT '当前状态时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_item_status
-- ----------------------------

-- ----------------------------
-- Table structure for gb_leaves
-- ----------------------------
DROP TABLE IF EXISTS `gb_leaves`;
CREATE TABLE `gb_leaves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `start_time` int(11) DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) DEFAULT '0' COMMENT '结束时间',
  `days` decimal(10,2) DEFAULT '0.00' COMMENT '天数',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `no` varchar(50) DEFAULT '' COMMENT '单据号',
  `ptype` int(11) DEFAULT '0' COMMENT '请假类别：1探亲假，2事假，3病假，4婚假，5丧假，6公假，7工伤，8产假，9其他',
  `name` varchar(100) DEFAULT '' COMMENT '姓名',
  `deport_id` int(11) DEFAULT '0' COMMENT '部门ID',
  `job_id` varchar(50) DEFAULT '' COMMENT '工号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_leaves
-- ----------------------------

-- ----------------------------
-- Table structure for gb_leaves_attaches
-- ----------------------------
DROP TABLE IF EXISTS `gb_leaves_attaches`;
CREATE TABLE `gb_leaves_attaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leaves_id` int(11) DEFAULT '0' COMMENT '广博集团请假单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_leaves_attaches
-- ----------------------------

-- ----------------------------
-- Table structure for gb_leaves_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_leaves_status`;
CREATE TABLE `gb_leaves_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leaves_id` int(11) DEFAULT '0' COMMENT '广博集团请假单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `status` int(11) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_leaves_status
-- ----------------------------

-- ----------------------------
-- Table structure for gb_mall
-- ----------------------------
DROP TABLE IF EXISTS `gb_mall`;
CREATE TABLE `gb_mall` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '' COMMENT '商城名',
  `is_del` int(11) DEFAULT '0' COMMENT '是否删除，0：未删除，1：删除',
  `rank` int(11) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_mall
-- ----------------------------
INSERT INTO `gb_mall` VALUES ('1', '京东渠道上新明细', '0', '1');
INSERT INTO `gb_mall` VALUES ('2', '京东POP', '0', '2');
INSERT INTO `gb_mall` VALUES ('3', '天猫', '0', '3');
INSERT INTO `gb_mall` VALUES ('4', '淘宝', '0', '4');
INSERT INTO `gb_mall` VALUES ('5', 'KA', '0', '5');
INSERT INTO `gb_mall` VALUES ('6', '市场', '0', '6');

-- ----------------------------
-- Table structure for gb_mall_colums
-- ----------------------------
DROP TABLE IF EXISTS `gb_mall_colums`;
CREATE TABLE `gb_mall_colums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mall_id` int(11) DEFAULT '0' COMMENT '商城id',
  `name` varchar(30) DEFAULT '' COMMENT '字段名',
  `ptype_status_id` int(11) DEFAULT '0' COMMENT '状态id,0:自定义,10:到货时间',
  `rank` int(11) DEFAULT '0' COMMENT '排序',
  `is_text` tinyint(2) DEFAULT '0' COMMENT '是否允许文本',
  `is_attach` tinyint(2) DEFAULT '0' COMMENT '是否允许附件',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_mall_colums
-- ----------------------------
INSERT INTO `gb_mall_colums` VALUES ('1', '1', '', '1', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('2', '1', '', '2', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('3', '1', '', '4', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('4', '1', '', '5', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('5', '1', '', '7', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('6', '1', '京东编码', '0', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('7', '1', '到货时间', '10', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('8', '1', '发货', '0', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('9', '1', '渠道上新', '0', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('10', '2', '', '1', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('11', '2', '', '2', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('12', '2', '', '4', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('13', '2', '', '5', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('14', '2', '', '7', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('15', '2', '商城编码', '0', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('16', '2', '到货时间', '10', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('17', '2', '发货', '0', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('18', '2', '渠道上新', '0', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('19', '3', '', '1', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('20', '3', '', '2', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('21', '3', '', '4', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('22', '3', '', '5', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('23', '3', '', '7', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('24', '3', '商城编码', '0', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('25', '3', '到货时间', '10', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('26', '3', '发货', '0', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('27', '3', '渠道上新', '0', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('28', '4', '', '1', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('29', '4', '', '2', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('30', '4', '', '4', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('31', '4', '', '5', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('32', '4', '', '7', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('33', '4', '商城编码', '0', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('34', '4', '到货时间', '10', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('35', '4', '发货', '0', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('36', '4', '渠道上新', '0', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('37', '5', '', '1', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('38', '5', '', '2', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('39', '5', '', '4', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('40', '5', '', '5', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('41', '5', '', '7', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('42', '5', '商城编码', '0', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('43', '5', '到货时间', '10', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('44', '5', '发货', '0', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('45', '5', '渠道上新', '0', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('46', '6', '', '1', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('47', '6', '', '2', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('48', '6', '', '4', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('49', '6', '', '5', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('50', '6', '', '7', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('51', '6', '商城编码', '0', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('52', '6', '到货时间', '10', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('53', '6', '发货', '0', '0', '0', '0');
INSERT INTO `gb_mall_colums` VALUES ('54', '6', '渠道上新', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for gb_menus
-- ----------------------------
DROP TABLE IF EXISTS `gb_menus`;
CREATE TABLE `gb_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '' COMMENT '菜单名称',
  `controller_name` varchar(100) DEFAULT '' COMMENT '控制器权限代码',
  `action_name` varchar(100) DEFAULT '' COMMENT '页面权限代码',
  `params` varchar(255) DEFAULT '' COMMENT '参数',
  `class_code` varchar(50) DEFAULT '' COMMENT '样式代码',
  `ptype` tinyint(2) DEFAULT '0' COMMENT '分类：0最高级，1下级，2再下级',
  `rank` int(11) DEFAULT '0' COMMENT '排序',
  `is_show` tinyint(2) DEFAULT '1' COMMENT '是否显示，0不显示，1显示',
  `parent_id` int(11) DEFAULT '0' COMMENT '上级菜单id',
  `content` varchar(255) DEFAULT '' COMMENT '菜单权限描述',
  `is_power` tinyint(2) DEFAULT '1' COMMENT '是否参与权限控制，1参与，0不参与',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url` varchar(100) DEFAULT '' COMMENT '链接',
  `first_code` varchar(100) DEFAULT 'hsub' COMMENT '菜单栏样式1',
  `second_code` varchar(100) DEFAULT 'submenu nav-hide' COMMENT '菜单栏样式2',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_menus
-- ----------------------------
INSERT INTO `gb_menus` VALUES ('1', '首页', 'Index', 'index', '', 'tachometer', '0', '1', '1', '0', '', '1', '0', 'Index/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('2', '产品分类', '', '', '', 'list', '0', '3', '1', '0', '', '1', '0', 'javascript:void(0);', 'tag', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('3', '产品开发', 'Product', 'index', '', 'list', '0', '4', '1', '0', '', '1', '0', 'javascript:void(0);', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('4', '产品进度', 'ProductOrder', 'index', '', 'list', '0', '5', '1', '0', '', '1', '0', 'javascript:void(0);', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('5', '产品图片', 'ProductPic', 'index', '', 'list', '0', '6', '1', '0', '', '1', '0', 'javascript:void(0);', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('6', '平台上新', 'ProductSx', 'index', '', 'list', '0', '7', '1', '0', '', '1', '0', 'javascript:void(0);', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('7', '部门管理', '', '', '', 'desktop', '0', '8', '1', '0', '', '1', '0', 'javascript:void(0);', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('8', '流程说明资料', '', '', '', 'picture-o', '0', '9', '1', '0', '', '1', '0', 'javascript:void(0);', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('9', '大类列表', 'Category', 'index', '', '', '1', '2', '1', '2', '', '1', '0', 'Category/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('10', '添加大类', 'Category', 'add_info', '', '', '1', '3', '1', '2', '', '1', '0', 'Category/add_info', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('11', '产品系列', 'SubCategory', 'index', '', '', '1', '4', '1', '2', '', '1', '0', 'SubCategory/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('12', '添加系列', 'SubCategory', 'add_info', '', '', '1', '5', '1', '2', '', '1', '0', 'SubCategory/add_info', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('13', '产品列表', 'Product', 'index', '', '', '1', '2', '1', '3', '', '1', '0', 'Product/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('14', '新建产品', 'Product', 'add_info', '', '', '1', '3', '1', '3', '', '1', '0', 'Product/add_info', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('15', '未完成项目', 'ProductOrder', 'index', '', '', '1', '3', '1', '4', '', '1', '0', 'ProductOrder/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('16', '全部项目', 'ProductOrder', 'list_items', '', '', '1', '2', '1', '4', '', '1', '0', 'ProductOrder/list_items', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('17', '历史删除项目', 'ProductOrder', 'history', '', '', '1', '4', '1', '4', '', '1', '0', 'ProductOrder/history', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('18', '未完成项目', 'ProductPic', 'index', '', '', '1', '3', '1', '5', '', '1', '0', 'ProductPic/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('19', '全部项目', 'ProductPic', 'list_items', '', '', '1', '2', '1', '5', '', '1', '0', 'ProductPic/list_items', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('20', '历史删除项目', 'ProductPic', 'history', '', '', '1', '4', '1', '5', '', '1', '0', 'ProductPic/history', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('21', '汇总', 'CountInfo', 'index', '', '', '1', '2', '1', '6', '', '1', '0', 'CountInfo/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('24', '部门列表', 'Deport', 'index', '', '', '1', '2', '1', '7', '', '1', '0', 'Deport/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('25', '添加部门', 'Deport', 'add_info', '', '', '1', '3', '1', '7', '', '1', '0', 'Deport/add_info', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('26', '角色列表', 'Roles', 'index', '', '', '1', '4', '1', '7', '', '1', '0', 'Roles/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('27', '添加角色', 'Roles', 'add_info', '', '', '1', '5', '1', '7', '', '1', '0', 'Roles/add_info', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('28', '人员列表', 'AdminUser', 'index', '', '', '1', '6', '1', '7', '', '1', '0', 'AdminUser/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('29', '添加人员', 'AdminUser', 'add_info', '', '', '1', '7', '1', '7', '', '1', '0', 'AdminUser/add_info', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('30', '权限列表', 'Menus', 'index', '', '', '1', '8', '1', '7', '', '1', '0', 'Menus/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('31', '产品审核', 'Product', 'check', '', '', '1', '4', '0', '3', '', '1', '0', 'Product/check', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('32', '产品进度维护', 'ProductOrder', 'edit', '', '', '1', '5', '0', '4', '', '1', '0', 'Product/edit', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('33', '产品进度删除', 'ProductOrder', 'del', '', '', '1', '6', '0', '4', '', '1', '0', 'Product/del', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('34', '产品开发', 'Ptypes', 'detail', 'id=1', '', '1', '2', '1', '8', '', '1', '0', 'Ptypes/detail?id=1', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('35', '产品进度', 'Ptypes', 'detail', 'id=2', '', '1', '3', '1', '8', '', '1', '0', 'Ptypes/detail?id=2', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('36', '产品图片', 'Ptypes', 'detail', 'id=3', '', '1', '4', '1', '8', '', '1', '0', 'Ptypes/detail?id=3', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('37', '分类维护', 'Ptypes', 'edit', '', '', '1', '5', '0', '8', '', '1', '0', '', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('38', '删除产品图片', 'ProductOrder', 'del', '', '', '1', '6', '0', '5', '', '1', '0', 'ProductOrder/del', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('39', '商城维护', '', '', '', 'tag', '0', '10', '1', '0', '', '1', '0', 'javascript:void(0)', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('40', '商城列表', 'Mall', 'index', '', '', '1', '2', '1', '39', '', '1', '0', 'Mall/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('41', '商城添加', 'Mall', 'add_info', '', '', '1', '3', '1', '39', '', '1', '0', 'Mall/add_info', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('42', '商店列表', 'Shop', 'index', '', '', '1', '4', '1', '39', '', '1', '0', 'Shop/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('43', '商店添加', 'Shop', 'add_info', '', '', '1', '5', '1', '39', '', '1', '0', 'Shop/add_info', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('44', '修改产品', 'Product', 'edit', '', '', '1', '5', '0', '3', '', '1', '0', 'Product/edit', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('45', '添加汇总', 'CountInfo', 'add_info', '', '', '1', '3', '1', '6', '', '1', '0', 'CountInfo/add_info', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('46', '修改商城内容', 'CountInfo', 'upload', '', '', '1', '4', '0', '6', '', '1', '0', 'CountInfo/upload', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('47', '删除店铺统计', 'ShopCount', 'del', '', '', '1', '5', '0', '6', '', '1', '0', 'ShopCount/del', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('48', '产品价格', 'ProductBase', 'index', '', 'list', '0', '8', '1', '0', '', '1', '0', 'ProductBase/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('49', '产品价格列表', 'ProductBase', 'index', '', '', '1', '2', '1', '48', '', '1', '0', 'ProductBase/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('50', '添加产品价格', 'ProductBase', 'add_info', '', '', '1', '2', '1', '48', '', '1', '0', 'ProductBase/add_info', 'hsub', 'submenu nav-hide', '2');
INSERT INTO `gb_menus` VALUES ('51', '删除', 'ProductBase', 'del', '', '', '1', '2', '0', '48', '', '1', '0', 'ProductBase/del', 'hsub', 'submenu nav-hide', '3');
INSERT INTO `gb_menus` VALUES ('52', '修改', 'ProductBase', 'edit', '', '', '1', '2', '0', '48', '', '1', '0', 'ProductBase/edit', 'hsub', 'submenu nav-hide', '4');
INSERT INTO `gb_menus` VALUES ('53', '类别列表', 'Classification', 'index', '', '', '1', '6', '1', '2', '', '1', '0', 'Classification/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('54', '添加类别', 'Classification', 'add_info', '', '', '1', '7', '1', '2', '', '1', '0', 'Classification/add_info', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('55', '工作流程', '', '', '', 'list-alt', '0', '2', '1', '0', '', '1', '0', 'javascript:void(0);', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('56', '公司临时审批表', 'Temporary', 'index', '', '', '1', '2', '1', '55', '', '1', '0', 'Temporary/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('57', '广博集团出差申请单', 'Business', 'index', '', '', '1', '3', '1', '55', '', '1', '0', 'Business/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('58', '广博集团请假单', 'Leave', 'index', '', '', '1', '4', '1', '55', '', '1', '0', 'Leave/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('59', '内销办事处请假单', 'DoLeave', 'index', '', '', '1', '5', '1', '55', '', '1', '0', 'DoLeave/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('60', '内销办事处出差申请单', 'DoBusiness', 'index', '', '', '1', '6', '1', '55', '', '1', '0', 'DoBusiness/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('61', '内销办事处领用申请单', 'DoUse', 'index', '', '', '1', '7', '1', '55', '', '1', '0', 'DoUse/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('62', '内销办事处促销申请单', 'DoPromotion', 'index', '', '', '1', '8', '1', '55', '', '1', '0', 'DoPromotions/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('63', '内销办事处调货报告', 'DoTurnGood', 'index', '', '', '1', '9', '1', '55', '', '1', '0', 'DoTurnGood/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('64', '内销办事处临时外出单', 'DoOutOrder', 'index', '', '', '1', '10', '1', '55', '', '1', '0', 'DoOutOrder/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('65', '内销推广会申请表', 'DoPromotionMeeting', 'index', '', '', '1', '11', '1', '55', '', '1', '0', 'DoPromotionMeeting/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('66', '内销广告设计制作申请表', 'DoDesign', 'index', '', '', '1', '12', '1', '55', '', '1', '0', 'DoDesign/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('67', '内销广告宣传物料申请表', 'DoPropaganda', 'index', '', '', '1', '13', '1', '55', '', '1', '0', 'DoPropaganda/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('68', '内销贴码产品申请流程单', 'DoPostCode', 'index', '', '', '1', '14', '1', '55', '', '1', '0', 'DoPostCode/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('69', '内销市场客户退货申请单', 'DoCustomerReturn', 'index', '', '', '1', '15', '1', '55', '', '1', '0', 'DoCustomerReturn/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('70', '内销办事处电商爆款申请表', 'DoExplosion', 'index', '', '', '1', '15', '1', '55', '', '1', '0', 'DoExplosion/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('71', '内销超额超期发货申请单', 'DoOverdueDelivery', 'index', '', '', '1', '17', '1', '55', '', '1', '0', 'DoOverdueDelivery/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('72', '添加', 'Temporary', 'add', '', '', '1', '17', '0', '56', '', '1', '0', 'Temporary/add', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('73', '修改', 'Temporary', 'edit', '', '', '1', '17', '0', '56', '', '1', '0', 'Temporary/edit', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('74', '详情', 'Temporary', 'detail', '', '', '1', '17', '0', '56', '', '1', '0', 'Temporary/detail', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('75', '工作流程配置', 'ProcessType', 'index', '', 'pencil-square-o', '0', '1', '1', '0', '', '1', '0', 'ProcessType/index', 'hsub', 'submenu nav-hide', '1');

-- ----------------------------
-- Table structure for gb_process_types
-- ----------------------------
DROP TABLE IF EXISTS `gb_process_types`;
CREATE TABLE `gb_process_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '' COMMENT '流程名称',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `rank` int(11) DEFAULT '0' COMMENT '排序',
  `controller_name` varchar(50) DEFAULT NULL,
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  `update_user_id` int(11) DEFAULT '0' COMMENT '操作人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_process_types
-- ----------------------------
INSERT INTO `gb_process_types` VALUES ('1', '公司临时审批表', '公司临时审批表', '0', '1', '0', '1', 'Temporary', '0', '0');
INSERT INTO `gb_process_types` VALUES ('2', '广博集团出差申请单', '广博集团出差申请单', '0', '1', '0', '2', 'Business', '0', '0');
INSERT INTO `gb_process_types` VALUES ('3', '广博集团请假单', '广博集团请假单', '0', '1', '0', '3', 'Leave', '0', '0');
INSERT INTO `gb_process_types` VALUES ('4', '内销办事处请假单', '内销办事处请假单', '0', '1', '0', '4', 'DoLeave', '0', '0');
INSERT INTO `gb_process_types` VALUES ('5', '内销办事处出差申请单', '内销办事处出差申请单', '0', '1', '0', '5', 'DoBusiness', '0', '0');
INSERT INTO `gb_process_types` VALUES ('6', '内销办事处领用申请单', '内销办事处领用申请单', '0', '1', '0', '6', 'DoUse', '0', '0');
INSERT INTO `gb_process_types` VALUES ('7', '内销办事处促销申请单', '内销办事处促销申请单', '0', '1', '0', '7', 'DoPromotions', '0', '0');
INSERT INTO `gb_process_types` VALUES ('8', '内销办事处调货报告', '内销办事处调货报告', '0', '1', '0', '7', 'DoTurnGood', '0', '0');
INSERT INTO `gb_process_types` VALUES ('9', '内销办事处临时外出单', '内销办事处临时外出单', '0', '1', '0', '9', 'DoOutOrder', '0', '0');
INSERT INTO `gb_process_types` VALUES ('10', '内销推广会申请表', '内销推广会申请表', '0', '1', '0', '10', 'DoPromotionMeeting', '0', '0');
INSERT INTO `gb_process_types` VALUES ('11', '内销广告设计制作申请表', '内销广告设计制作申请表', '0', '1', '0', '11', 'DoDesign', '0', '0');
INSERT INTO `gb_process_types` VALUES ('12', '内销广告宣传物料申请表', '内销广告宣传物料申请表', '0', '1', '0', '12', 'DoPropaganda', '0', '0');
INSERT INTO `gb_process_types` VALUES ('13', '内销贴码产品申请流程单', '内销贴码产品申请流程单', '0', '1', '0', '13', 'DoPostCode', '0', '0');
INSERT INTO `gb_process_types` VALUES ('14', '内销市场客户退货申请单', '内销市场客户退货申请单', '0', '1', '0', '14', 'DoCustomerReturn', '0', '0');
INSERT INTO `gb_process_types` VALUES ('15', '内销办事处电商爆款申请表', '内销办事处电商爆款申请表', '0', '1', '0', '15', 'DoExplosion', '0', '0');
INSERT INTO `gb_process_types` VALUES ('16', '内销超额超期发货申请单', '内销超额超期发货申请单', '0', '1', '0', '16', 'DoOverdueDelivery', '0', '0');

-- ----------------------------
-- Table structure for gb_process_type_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_process_type_status`;
CREATE TABLE `gb_process_type_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `process_type_id` int(11) DEFAULT '0' COMMENT '工作流程id',
  `name` varchar(100) DEFAULT '' COMMENT '状态名称',
  `content` text COMMENT '状态描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `checked_user_id` int(11) DEFAULT '0' COMMENT '审核人',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `rank` int(11) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_process_type_status
-- ----------------------------

-- ----------------------------
-- Table structure for gb_products
-- ----------------------------
DROP TABLE IF EXISTS `gb_products`;
CREATE TABLE `gb_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '' COMMENT '产品名称',
  `code` varchar(100) DEFAULT '' COMMENT '物料代码',
  `number` varchar(50) DEFAULT '' COMMENT '产品货号，辅代码',
  `days` int(11) DEFAULT '0' COMMENT '生产周期',
  `category_id` int(11) DEFAULT '0' COMMENT '大类id',
  `sub_category_id` int(11) DEFAULT '0' COMMENT '产品系列id',
  `now_price` decimal(10,2) DEFAULT '0.00' COMMENT '现价',
  `sold_price` decimal(10,2) DEFAULT '0.00' COMMENT '售价',
  `min_price` decimal(10,2) DEFAULT '0.00' COMMENT '最低售价',
  `min_num` int(11) DEFAULT '0' COMMENT '起订量',
  `ptime` int(11) DEFAULT '0' COMMENT '完成时间',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `send_content` varchar(255) DEFAULT '' COMMENT '上市说明',
  `rank` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(2) DEFAULT '0' COMMENT '0:待审核，1:审核通过，2:审核不通过',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `pic_path` varchar(255) DEFAULT '' COMMENT '产品图片',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `classification_id` int(11) DEFAULT '0' COMMENT '分类id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_products
-- ----------------------------
INSERT INTO `gb_products` VALUES ('1', '1', '1', '1', '11', '1', '1', '11.00', '11.00', '11.00', '11', '1479952954', '', '', '0', '1', '1479261764', '/uploadfiles/products/2016-11-16/IMG_0816.JPG', '1', '1');

-- ----------------------------
-- Table structure for gb_product_attach
-- ----------------------------
DROP TABLE IF EXISTS `gb_product_attach`;
CREATE TABLE `gb_product_attach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT '0' COMMENT '商品id',
  `name` varchar(100) DEFAULT '' COMMENT '附件名称',
  `url` varchar(255) DEFAULT '' COMMENT '附件路径',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_product_attach
-- ----------------------------

-- ----------------------------
-- Table structure for gb_product_base
-- ----------------------------
DROP TABLE IF EXISTS `gb_product_base`;
CREATE TABLE `gb_product_base` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT '0' COMMENT '产品大类',
  `sub_category_id` int(11) DEFAULT '0' COMMENT '产品系列',
  `number` varchar(100) DEFAULT '' COMMENT '辅代码',
  `code` varchar(100) DEFAULT '' COMMENT '物料代码',
  `sold_price` decimal(10,2) DEFAULT '0.00' COMMENT '统一售价',
  `now_price` decimal(10,2) DEFAULT '0.00' COMMENT '现价',
  `name` varchar(50) DEFAULT '' COMMENT '产品名称',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `pic_path` varchar(255) DEFAULT '' COMMENT '图片',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '删除',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `rank` int(11) DEFAULT '0' COMMENT '排序',
  `min_price` decimal(10,2) DEFAULT '0.00' COMMENT '最小价格',
  `classification_id` int(11) DEFAULT '0' COMMENT '最小分类id',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_product_base
-- ----------------------------
INSERT INTO `gb_product_base` VALUES ('1', '1', '1', '1', '1', '11.00', '11.00', '1', '', '/uploadfiles/products/2016-11-16/IMG_0816.JPG', '1', '0', '1479261764', '0', '11.00', '1', '0');

-- ----------------------------
-- Table structure for gb_product_order
-- ----------------------------
DROP TABLE IF EXISTS `gb_product_order`;
CREATE TABLE `gb_product_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT '0' COMMENT '产品id',
  `order_time` int(11) DEFAULT '0' COMMENT '下单时间',
  `order_num` int(11) DEFAULT '0' COMMENT '下单总数',
  `jd_num` int(11) DEFAULT '0' COMMENT '京东',
  `tm_num` int(11) DEFAULT '0' COMMENT '天猫',
  `tb_num` int(11) DEFAULT '0' COMMENT '淘宝',
  `ka_num` int(11) DEFAULT '0' COMMENT 'KA',
  `sc_num` int(11) DEFAULT '0' COMMENT '市场',
  `deliver_time` int(11) DEFAULT '0' COMMENT '大货前样',
  `dh_time` int(11) DEFAULT '0' COMMENT '到货时间',
  `dh_num` int(11) DEFAULT '0' COMMENT '到货数量',
  `content` varchar(255) DEFAULT '' COMMENT '备注',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '是否删除',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  `rank` int(11) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_product_order
-- ----------------------------
INSERT INTO `gb_product_order` VALUES ('1', '1', '1479348176', '0', '11', '11', '11', '11', '8', '1479434584', '1479520986', '2147483647', '', '1479261768', '1', '0', '1479261800', '0');

-- ----------------------------
-- Table structure for gb_product_order_deliver
-- ----------------------------
DROP TABLE IF EXISTS `gb_product_order_deliver`;
CREATE TABLE `gb_product_order_deliver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_order_id` int(11) DEFAULT '0' COMMENT '产品id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `num` int(11) DEFAULT '0' COMMENT '收货数量',
  `deliver_time` int(11) DEFAULT '0' COMMENT '收货时间',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_product_order_deliver
-- ----------------------------
INSERT INTO `gb_product_order_deliver` VALUES ('1', '1', '', '2147483647', '1479520986', '1', '1479261800');

-- ----------------------------
-- Table structure for gb_product_pic
-- ----------------------------
DROP TABLE IF EXISTS `gb_product_pic`;
CREATE TABLE `gb_product_pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT '0' COMMENT '产品id',
  `status` tinyint(2) DEFAULT '0' COMMENT '状态，1:交样，2方案，3方案审核，4拍照，5详情页制做，6详情页审核，7首图制作，8首页审核，9完成',
  `ptype_id` int(11) DEFAULT '0' COMMENT '分类id',
  `finish_time` int(11) DEFAULT '0' COMMENT '完成',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `is_over` tinyint(2) DEFAULT '0' COMMENT '是否结束，0：未结束，1：结束',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '是否删除，0：未删除，1：删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_product_pic
-- ----------------------------
INSERT INTO `gb_product_pic` VALUES ('1', '1', '1', '0', '0', '1479261800', '0', '1', '1');

-- ----------------------------
-- Table structure for gb_product_pic_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_product_pic_status`;
CREATE TABLE `gb_product_pic_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_pic_id` int(11) DEFAULT '0' COMMENT '产品图片进度表id',
  `ptype_status_id` int(11) DEFAULT '0' COMMENT '当前状态id',
  `create_time` int(11) DEFAULT '0' COMMENT '提交时间',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '提交者id',
  `checked_user_id` int(11) DEFAULT '0' COMMENT '审核人id',
  `checked_time` int(11) DEFAULT '0' COMMENT '审核时间',
  `status` tinyint(2) DEFAULT '0' COMMENT '状态，0未提交，1提交，2拒绝',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '0未删除，1删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_product_pic_status
-- ----------------------------
INSERT INTO `gb_product_pic_status` VALUES ('1', '1', '1', '1479261800', '1', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for gb_product_pic_status_attach
-- ----------------------------
DROP TABLE IF EXISTS `gb_product_pic_status_attach`;
CREATE TABLE `gb_product_pic_status_attach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text COMMENT '填写内容',
  `url` varchar(255) DEFAULT '' COMMENT '附件路径',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '上传者',
  `create_time` int(11) DEFAULT '0' COMMENT '上传时间',
  `product_pic_status_id` int(11) DEFAULT '0' COMMENT '更新状态表id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_product_pic_status_attach
-- ----------------------------

-- ----------------------------
-- Table structure for gb_product_pic_status_log
-- ----------------------------
DROP TABLE IF EXISTS `gb_product_pic_status_log`;
CREATE TABLE `gb_product_pic_status_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_pic_status_id` int(11) DEFAULT '0' COMMENT '产品图片进度状态id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_product_pic_status_log
-- ----------------------------

-- ----------------------------
-- Table structure for gb_ptypes
-- ----------------------------
DROP TABLE IF EXISTS `gb_ptypes`;
CREATE TABLE `gb_ptypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '' COMMENT '分类名称',
  `status` int(11) DEFAULT '0' COMMENT '状态：0待审核，1审核通过，2审核不通过',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建人id',
  `checked_id` int(11) DEFAULT '0' COMMENT '审核人id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `checked_time` int(11) DEFAULT '0' COMMENT '审核时间',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '是否删除',
  `content` text COMMENT '说明',
  `rank` int(11) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_ptypes
-- ----------------------------
INSERT INTO `gb_ptypes` VALUES ('1', '产品开发', '1', '1', '0', '0', '0', '0', '产品开发', '1');
INSERT INTO `gb_ptypes` VALUES ('2', '产品进度', '1', '1', '0', '0', '0', '0', '产品进度', '2');
INSERT INTO `gb_ptypes` VALUES ('3', '产品图片', '1', '1', '0', '0', '0', '0', '产品图片', '3');

-- ----------------------------
-- Table structure for gb_ptype_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_ptype_status`;
CREATE TABLE `gb_ptype_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '' COMMENT '状态名称',
  `ptype_id` int(11) DEFAULT '0' COMMENT '分类id',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `rank` int(11) DEFAULT '0' COMMENT '排序值',
  `is_attach` tinyint(2) DEFAULT '0' COMMENT '是否支持上传附件',
  `is_text` tinyint(2) DEFAULT '0' COMMENT '是否可填写文本',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_ptype_status
-- ----------------------------
INSERT INTO `gb_ptype_status` VALUES ('1', '交样', '3', '1', '0', '1', '1', '1');
INSERT INTO `gb_ptype_status` VALUES ('2', '文案', '3', '1', '0', '2', '1', '1');
INSERT INTO `gb_ptype_status` VALUES ('3', '方案审核', '3', '1', '0', '3', '1', '0');
INSERT INTO `gb_ptype_status` VALUES ('4', '拍照', '3', '1', '0', '4', '1', '1');
INSERT INTO `gb_ptype_status` VALUES ('5', '详情页制作', '3', '1', '0', '5', '1', '0');
INSERT INTO `gb_ptype_status` VALUES ('6', '详情页审核', '3', '1', '0', '6', '1', '0');
INSERT INTO `gb_ptype_status` VALUES ('7', '首页制作', '3', '1', '0', '7', '1', '1');
INSERT INTO `gb_ptype_status` VALUES ('8', '首页审核', '3', '1', '0', '8', '1', '1');
INSERT INTO `gb_ptype_status` VALUES ('9', '完成', '3', '1', '0', '9', '1', '1');

-- ----------------------------
-- Table structure for gb_roles
-- ----------------------------
DROP TABLE IF EXISTS `gb_roles`;
CREATE TABLE `gb_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '' COMMENT '角色名称',
  `content` text COMMENT '角色描述',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建人id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `deport_id` int(11) DEFAULT '0' COMMENT '部门id',
  `rank` int(11) DEFAULT '0' COMMENT '排序',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '是否删除',
  `attach_power_ids` varchar(255) DEFAULT '0' COMMENT '有上传状态的id列表',
  `text_power_ids` varchar(255) DEFAULT '0' COMMENT '有填写文字的权限的id列表',
  `check_power_ids` varchar(255) DEFAULT '0' COMMENT '有审核权限的id集合',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_roles
-- ----------------------------
INSERT INTO `gb_roles` VALUES ('1', '系统管理员', '系统管理员', '0', '0', '1', '0', '0', '1,2,3,4,5,6,7,8,9', '1,2,3,4,5,6,7,8,9', '1,2,3,4,5,6,7,8,9');
INSERT INTO `gb_roles` VALUES ('2', 'aa', '', '1', '1477296099', '2', '0', '0', null, null, null);
INSERT INTO `gb_roles` VALUES ('3', 'aa', '', '1', '1481773362', '3', '0', '0', null, null, null);

-- ----------------------------
-- Table structure for gb_role_menus
-- ----------------------------
DROP TABLE IF EXISTS `gb_role_menus`;
CREATE TABLE `gb_role_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT '0' COMMENT '角色id',
  `menus_id` int(11) DEFAULT '0' COMMENT '菜单权限id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=473 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_role_menus
-- ----------------------------
INSERT INTO `gb_role_menus` VALUES ('471', '1', '75');
INSERT INTO `gb_role_menus` VALUES ('470', '1', '71');
INSERT INTO `gb_role_menus` VALUES ('469', '1', '70');
INSERT INTO `gb_role_menus` VALUES ('468', '1', '69');
INSERT INTO `gb_role_menus` VALUES ('467', '1', '68');
INSERT INTO `gb_role_menus` VALUES ('466', '1', '67');
INSERT INTO `gb_role_menus` VALUES ('465', '1', '66');
INSERT INTO `gb_role_menus` VALUES ('464', '1', '65');
INSERT INTO `gb_role_menus` VALUES ('463', '1', '64');
INSERT INTO `gb_role_menus` VALUES ('462', '1', '63');
INSERT INTO `gb_role_menus` VALUES ('461', '1', '62');
INSERT INTO `gb_role_menus` VALUES ('460', '1', '61');
INSERT INTO `gb_role_menus` VALUES ('459', '1', '60');
INSERT INTO `gb_role_menus` VALUES ('458', '1', '59');
INSERT INTO `gb_role_menus` VALUES ('457', '1', '58');
INSERT INTO `gb_role_menus` VALUES ('456', '1', '57');
INSERT INTO `gb_role_menus` VALUES ('455', '1', '56');
INSERT INTO `gb_role_menus` VALUES ('454', '1', '55');
INSERT INTO `gb_role_menus` VALUES ('453', '1', '43');
INSERT INTO `gb_role_menus` VALUES ('452', '1', '42');
INSERT INTO `gb_role_menus` VALUES ('451', '1', '41');
INSERT INTO `gb_role_menus` VALUES ('450', '1', '40');
INSERT INTO `gb_role_menus` VALUES ('449', '1', '39');
INSERT INTO `gb_role_menus` VALUES ('448', '1', '37');
INSERT INTO `gb_role_menus` VALUES ('447', '1', '36');
INSERT INTO `gb_role_menus` VALUES ('446', '1', '35');
INSERT INTO `gb_role_menus` VALUES ('445', '1', '34');
INSERT INTO `gb_role_menus` VALUES ('444', '1', '8');
INSERT INTO `gb_role_menus` VALUES ('443', '1', '30');
INSERT INTO `gb_role_menus` VALUES ('442', '1', '29');
INSERT INTO `gb_role_menus` VALUES ('441', '1', '28');
INSERT INTO `gb_role_menus` VALUES ('440', '1', '27');
INSERT INTO `gb_role_menus` VALUES ('439', '1', '26');
INSERT INTO `gb_role_menus` VALUES ('438', '1', '25');
INSERT INTO `gb_role_menus` VALUES ('437', '1', '24');
INSERT INTO `gb_role_menus` VALUES ('436', '1', '7');
INSERT INTO `gb_role_menus` VALUES ('435', '1', '45');
INSERT INTO `gb_role_menus` VALUES ('434', '1', '21');
INSERT INTO `gb_role_menus` VALUES ('433', '1', '6');
INSERT INTO `gb_role_menus` VALUES ('432', '1', '38');
INSERT INTO `gb_role_menus` VALUES ('431', '1', '20');
INSERT INTO `gb_role_menus` VALUES ('430', '1', '19');
INSERT INTO `gb_role_menus` VALUES ('429', '1', '18');
INSERT INTO `gb_role_menus` VALUES ('428', '1', '5');
INSERT INTO `gb_role_menus` VALUES ('427', '1', '33');
INSERT INTO `gb_role_menus` VALUES ('426', '1', '32');
INSERT INTO `gb_role_menus` VALUES ('425', '1', '17');
INSERT INTO `gb_role_menus` VALUES ('424', '1', '16');
INSERT INTO `gb_role_menus` VALUES ('423', '1', '15');
INSERT INTO `gb_role_menus` VALUES ('422', '1', '4');
INSERT INTO `gb_role_menus` VALUES ('421', '1', '44');
INSERT INTO `gb_role_menus` VALUES ('420', '1', '31');
INSERT INTO `gb_role_menus` VALUES ('419', '1', '14');
INSERT INTO `gb_role_menus` VALUES ('418', '1', '13');
INSERT INTO `gb_role_menus` VALUES ('417', '1', '3');
INSERT INTO `gb_role_menus` VALUES ('416', '1', '54');
INSERT INTO `gb_role_menus` VALUES ('415', '1', '53');
INSERT INTO `gb_role_menus` VALUES ('414', '1', '12');
INSERT INTO `gb_role_menus` VALUES ('413', '1', '11');
INSERT INTO `gb_role_menus` VALUES ('412', '1', '10');
INSERT INTO `gb_role_menus` VALUES ('411', '1', '9');
INSERT INTO `gb_role_menus` VALUES ('410', '1', '2');
INSERT INTO `gb_role_menus` VALUES ('409', '1', '1');
INSERT INTO `gb_role_menus` VALUES ('472', '3', '5');
INSERT INTO `gb_role_menus` VALUES ('345', '2', '38');
INSERT INTO `gb_role_menus` VALUES ('344', '2', '20');
INSERT INTO `gb_role_menus` VALUES ('343', '2', '19');
INSERT INTO `gb_role_menus` VALUES ('342', '2', '18');
INSERT INTO `gb_role_menus` VALUES ('341', '2', '5');
INSERT INTO `gb_role_menus` VALUES ('340', '2', '3');
INSERT INTO `gb_role_menus` VALUES ('339', '2', '9');
INSERT INTO `gb_role_menus` VALUES ('338', '2', '2');
INSERT INTO `gb_role_menus` VALUES ('337', '2', '1');

-- ----------------------------
-- Table structure for gb_role_shop
-- ----------------------------
DROP TABLE IF EXISTS `gb_role_shop`;
CREATE TABLE `gb_role_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT '0' COMMENT '店铺id',
  `role_id` int(11) DEFAULT '0' COMMENT '角色id',
  `is_edit` tinyint(2) DEFAULT '0' COMMENT '是否有修改权限',
  `is_send` tinyint(2) DEFAULT '0' COMMENT '是否有上新权限',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '是否有删除权限',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_role_shop
-- ----------------------------

-- ----------------------------
-- Table structure for gb_shop
-- ----------------------------
DROP TABLE IF EXISTS `gb_shop`;
CREATE TABLE `gb_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mall_id` int(11) DEFAULT '0' COMMENT '商城id',
  `name` varchar(255) DEFAULT '' COMMENT '店铺名',
  `status` int(11) DEFAULT '0' COMMENT '状态，0：未审核，1：审核通过，2：审核不通过',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '0 未删除，1 删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_shop
-- ----------------------------

-- ----------------------------
-- Table structure for gb_sub_category
-- ----------------------------
DROP TABLE IF EXISTS `gb_sub_category`;
CREATE TABLE `gb_sub_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '' COMMENT '产品名称',
  `number` varchar(50) DEFAULT '' COMMENT '产品货号，辅代码',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `category_id` int(11) DEFAULT '0' COMMENT '大类id',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '是否删除',
  `rank` int(11) DEFAULT '0' COMMENT '排序',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_sub_category
-- ----------------------------
INSERT INTO `gb_sub_category` VALUES ('1', '11', '', '11', '1', '0', '1', '1', '1479261691');

-- ----------------------------
-- Table structure for gb_temporaries
-- ----------------------------
DROP TABLE IF EXISTS `gb_temporaries`;
CREATE TABLE `gb_temporaries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no` varchar(50) DEFAULT '' COMMENT '单据号',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `report_time` int(11) DEFAULT '0' COMMENT '填写报告时间',
  `is_over` int(11) DEFAULT '0' COMMENT '是否结束',
  `rank` int(11) DEFAULT '0' COMMENT '排序',
  `make_id` int(11) DEFAULT '0' COMMENT '制单人id',
  `deport_id` int(11) DEFAULT '0' COMMENT '报告递交部门',
  `user_name` varchar(100) DEFAULT '' COMMENT '报告递交人员',
  `deport_name` varchar(100) DEFAULT '' COMMENT '报告递交部门',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_temporaries
-- ----------------------------

-- ----------------------------
-- Table structure for gb_temporaries_status
-- ----------------------------
DROP TABLE IF EXISTS `gb_temporaries_status`;
CREATE TABLE `gb_temporaries_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `temporary_id` int(11) DEFAULT '0' COMMENT '公司临时审批表id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `status` int(11) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  `url_path` varchar(255) DEFAULT '' COMMENT '附件地址',
  `name` varchar(255) DEFAULT '' COMMENT '附件描述',
  `process_type_status_id` int(11) DEFAULT '0' COMMENT '审核状态id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_temporaries_status
-- ----------------------------

-- ----------------------------
-- Table structure for gb_temporary_attaches
-- ----------------------------
DROP TABLE IF EXISTS `gb_temporary_attaches`;
CREATE TABLE `gb_temporary_attaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `temporary_id` int(11) DEFAULT '0' COMMENT '公司临时审批表id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `url_path` varchar(255) DEFAULT '0' COMMENT '附件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gb_temporary_attaches
-- ----------------------------


 #部门表
create table gb_admin_user(
   id int(11) primary key not null auto_increment,
   username varchar(100) default '' comment '用户名',
   password varchar(100) default '' comment '密码',
   name varchar(100) default '' comment '姓名',
   sex tinyint(2) default 1 comment '性别，1男，0女',
   mobile varchar(100) default '' comment '手机号',
   phone varchar(100) default '' comment '家庭电话',
   address varchar(255) default '' comment '家庭地址',
   cret_no varchar(32) default '' comment '身份证号',
   contact_name varchar(100) default '' comment '紧急联系人',
   contact_phone varchar(100) default '' comment '紧急联系人电话',
   contact_info varchar(100) default '' comment '紧急联系人关系',
   create_time int(11) default 0 comment '创建时间',
   status tinyint(2) default 1 comment '状态，1正常，2锁定',
   admin_user_id int(11) default 0 comment '创建者id',
   role_id int(11) default 0 comment '角色id',
   is_admin tinyint(2) default 0 comment '是否为管理员',
   deport_id int(11) default 0 comment '部门id',
   head_pic varchar(255) default 0 comment '头像',
   content text comment '描述',
   email varchar(255) default '' comment '邮箱',
   is_del tinyint(2) default 0 comment '是否删除, 0未删除，1删除',
   is_mail tinyint(2) default 0 comment '是否发送邮件, 0不发送, 1发送'
 )default charset=utf8;

create table gb_admin_user_show(
   id int(11) primary key not null auto_increment,
   code varchar(30) default '' comment '执行点击事件',
   admin_user_id int(11) default 0 comment '用户id',
   is_background tinyint(2) default 0 comment '是否为背景'
)default charset=utf8;

 #部门表
create table gb_deport(
   id int(11) primary key not null auto_increment,
   name varchar(100) default '' comment '部门名称',
   content text comment '部门描述',
   create_time int(11) default 0 comment '创建时间',
   is_del tinyint(2) default 0 comment '是否删除',
   admin_user_id int(11) default 0 comment '创建者id',
   rank int(11) default 0 comment '排序'
)default charset=utf8;

#菜单权限表
create table gb_menus(
  id int(11) primary key not null auto_increment,
  name varchar(100) default '' comment '菜单名称',
  controller_name varchar(100) default '' comment '控制器权限代码',
  action_name varchar(100) default '' comment '页面权限代码',
  params varchar(255) default '' comment '参数',
  class_code varchar(50) default '' comment '样式代码',
  ptype tinyint(2) default '0' comment '分类：0最高级，1下级，2再下级',
  rank int(11) default 0 comment '排序',
  is_show tinyint(2) default 1 comment '是否显示，0不显示，1显示',
  parent_id int(11) default 0 comment '上级菜单id',
  content varchar(255) default '' comment '菜单权限描述',
  is_power tinyint(2) default 1 comment '是否参与权限控制，1参与，0不参与',
  create_time int(11) default 0 comment '创建时间',
  url varchar(100) default '' comment '链接',
  first_code varchar(100) default 'hsub' comment '菜单栏样式1',
  second_code varchar(100) default 'submenu nav-hide' comment '菜单栏样式2',
  admin_user_id int(11) default 0 comment '创建者id'
)default charset=utf8;

#角色表
create table gb_roles(
   id int(11) primary key not null auto_increment,
   name varchar(100) default '' comment '角色名称',
   content text comment '角色描述',
   admin_user_id int(11) default 0 comment '创建人id',
   create_time int(11) default 0 comment '创建时间',
   deport_id int(11) default 0 comment '部门id',
   rank int(11) default 0 comment '排序',
   is_del tinyint(2) default 0 comment '是否删除',
   attach_power_ids varchar(255) default 0 comment '有上传状态的id列表',
   text_power_ids varchar(255) default 0 comment '有填写文字的权限的id列表',
   check_power_ids varchar(255) default 0 comment '有审核权限的id集合'
)default charset=utf8;

#角色与菜单中间表
create table gb_role_menus(
   id int(11) primary key not null auto_increment,
   role_id int(11) default 0 comment '角色id',
   menus_id int(11) default 0 comment '菜单权限id'
)default charset=utf8;

#项目分类表
create table gb_ptypes(
  id int(11) primary key not null auto_increment,
  name varchar(100) default '' comment '分类名称',
  status int(11) default 0 comment '状态：0待审核，1审核通过，2审核不通过',
  admin_user_id int(11) default 0 comment '创建人id',
  checked_id int(11) default 0 comment '审核人id',
  create_time int(11) default 0 comment '创建时间',
  checked_time int(11) default 0 comment '审核时间',
  is_del tinyint(2) default 0 comment '是否删除',
  content text comment '说明',
  rank int(11) default 0 comment '排序'
)default charset=utf8;

#分类下状态表
create table gb_ptype_status(
  id int(11) primary key not null auto_increment,
  name varchar(100) default '' comment '状态名称',
  ptype_id int(11) default 0 comment '分类id',
  admin_user_id int(11) default 0 comment '创建者id',
  create_time int(11) default 0 comment '创建时间',
  rank int(11) default 0 comment '排序值',
  is_attach tinyint(2) default 0 comment '是否支持上传附件',
  is_text tinyint(2) default 0 comment '是否可填写文本'
)default charset=utf8;

#项目表
create table gb_items(
   id int(11) primary key not null auto_increment,
   name varchar(100) default '' comment '项目名称',
   ptype_id int(11) default 0 comment '项目分类id',
   content text comment '项目描述',
   creater_id int(11) default 0 comment '提交项目者id',
   create_time int(11) default 0 comment '项目创建时间',
   update_time int(11) default 0 comment '更新项目时间',
   status int(11) default 0 comment '项目状态',
   is_del tinyint(2) default 0 comment '项目是否删除',
   admin_user_id int(11) default 0 comment '创建人id',
   rank int(11) default 0 comment '排序值',
   number varchar(100) default '' comment '货号',
   is_over tinyint(2) default 0 comment '是否结束'
)default charset=utf8;

#项目附件
create table gb_items_attach(
   id int(11) primary key not null auto_increment,
   item_id int(11) default 0 comment '项目id',
   name varchar(100) default '' comment '分类名称',
   durl varchar(255) default '' comment '附件下载地址',
   create_time int(11) default 0 comment '添加附件时间',
   admin_user_id int(11) default 0 comment '提交者id',
   item_status_id int(11) default 0 comment '当前状态'
)default charset=utf8;

create table gb_item_status(
   id int(11) primary key not null auto_increment,
   ptype_status_id int(11) default 0 comment '分类状态id',
   admin_user_id int(11) default 0 comment '创建者id',
   item_id int(11) default 0 comment '项目id',
   create_time int(11) default 0 comment '当前状态时间'
)default charset=utf8;

create table gb_deport_message(
   id int(11) primary key not null auto_increment,
   deport_id int(11) default 0 comment '部门id',
   msg text comment '内容',
   create_time int(11) default 0 comment '时间',
   admin_user_id int(11) default 0 comment '创建者id'
)default charset=utf8;

create table gb_products(
   id int(11) primary key not null auto_increment,
   name varchar(100) default '' comment '产品名称',
   code varchar(100) default '' comment '物料代码',
   number varchar(50) default '' comment '产品货号，辅代码',
   days int(11) default 0 comment '生产周期',
   category_id int(11) default 0 comment '大类id',
   sub_category_id int(11) default 0 comment '产品系列id',
   now_price decimal(10, 2) default 0 comment '现价',
   sold_price decimal(10, 2) default 0 comment '售价',
   min_price decimal(10, 2) default 0 comment '最低售价',
   min_num int(11) default 0 comment '起订量',
   ptime int(11) default 0 comment '完成时间',
   content varchar(255) default '' comment '描述',
   send_content varchar(255) default '' comment '上市说明',
   rank int(11) default 0 comment '排序',
   status int(2) default'0' comment '0:待审核，1:审核通过，2:审核不通过',
   create_time int(11) default 0 comment '创建时间',
   pic_path varchar(255) default '' comment '产品图片',
   admin_user_id int(11) default 0 comment '创建者id'
)default charset=utf8;

create table gb_product_attach(
   id int(11) primary key not null auto_increment,
   product_id int(11) default 0 comment  '商品id',
   name varchar(100) default '' comment '附件名称',
   url varchar(255) default '' comment '附件路径',
   admin_user_id int(11) default 0 comment '创建者',
   create_time int(11) default 0 comment '创建时间'
)default charset=utf8;

create table gb_category(
   id int(11) primary key not null auto_increment,
   name varchar(100) default '' comment '产品名称',
   number varchar(50) default '' comment '产品货号，辅代码',
   rank int(11) default 0 comment '排序',
   is_del tinyint(2) default 0 comment '是否删除',
   content varchar(255) default '' comment '描述',
   admin_user_id int(11) default 0 comment '创建者',
   create_time int(11) default 0 comment '创建时间'
)default charset=utf8;

create table gb_sub_category(
   id int(11) primary key not null auto_increment,
   name varchar(100) default '' comment '产品名称',
   number varchar(50) default '' comment '产品货号，辅代码',
   content varchar(255) default '' comment '描述',
   category_id int(11) default 0 comment '大类id',
   is_del tinyint(2) default 0 comment '是否删除',
   rank int(11) default 0 comment '排序',
   admin_user_id int(11) default 0 comment '创建者',
   create_time int(11) default 0 comment '创建时间'
)default charset=utf8;

create table gb_product_order(
   id int(11) primary key not null auto_increment,
   product_id int(11) default 0 comment '产品id',
   order_time int(11) default 0 comment '下单时间',
   order_num int(11) default 0 comment '下单总数',
   jd_num int(11) default 0 comment '京东',
   tm_num int(11) default 0 comment '天猫',
   tb_num int(11) default 0 comment '淘宝',
   ka_num int(11) default 0 comment 'KA',
   sc_num int(11) default 0 comment '市场',
   deliver_time int(11) default 0 comment '大货前样',
   dh_time int(11) default 0 comment '到货时间',
   dh_num int(11) default 0 comment '到货数量',
   content varchar(255) default '' comment '备注',
   create_time int(11) default 0 comment '创建时间',
   admin_user_id int(11) default 0 comment '创建者id',
   is_del tinyint(2) default 0 comment '是否删除',
   update_time int(11) default 0 comment '更新时间',
   rank int(11) default 0 comment '排序' 
)default charset=utf8;

#产品图片进度表
create table gb_product_pic(
   id int(11) primary key not null auto_increment,
   product_id int(11) default 0 comment '产品id',
   status tinyint(2) default 0 comment '状态，1:交样，2方案，3方案审核，4拍照，5详情页制做，6详情页审核，7首图制作，8首页审核，9完成',
   ptype_id int(11) default 0 comment '分类id',
   finish_time int(11) default 0 comment '完成',
   create_time int(11) default 0 comment '创建时间',
   is_over tinyint(2) default 0 comment '是否结束，0：未结束，1：结束',
   is_del tinyint(2) default 0 comment '是否删除，0：未删除，1：删除',
   admin_user_id int(11) default 0 comment '创建者id'
)default charset=utf8;

#状态更新表
create table gb_product_pic_status(
   id int(11) primary key not null auto_increment,
   product_pic_id int(11) default 0 comment '产品图片进度表id',
   ptype_status_id int(11) default 0 comment '当前状态id',
   create_time int(11) default 0 comment '提交时间',
   admin_user_id int(11) default 0 comment '提交者id',
   checked_user_id int(11) default 0 comment '审核人id',
   checked_time int(11) default 0 comment '审核时间',
   status tinyint(2) default 0 comment '状态，0未提交，1提交，2拒绝',
   is_del tinyint(2) default 0 comment '0未删除，1删除'
)default charset=utf8;

#状态附件表
create table gb_product_pic_status_attach(
   id int(11) primary key not null auto_increment,
   content text comment '填写内容',
   url varchar(255) default '' comment '附件路径',
   admin_user_id int(11) default 0 comment '上传者',
   create_time int(11) default 0 comment '上传时间',
   product_pic_status_id int(11) default 0 comment '更新状态表id'
)default charset=utf8;

#商城表
create table gb_mall(
   id int(11) primary key not null auto_increment,
   name varchar(255) default '' comment '商城名',
   is_del int(11) default 0 comment '是否删除，0：未删除，1：删除',
   rank int(11) default 0 comment '排序'
)default charset=utf8;

#店铺表
create table gb_shop(
   id int(11) primary key not null auto_increment,
   mall_id int(11) default 0 comment '商城id',
   name varchar(255) default '' comment '店铺名',
   status int(11) default 0 comment '状态，0：未审核，1：审核通过，2：审核不通过',
   is_del tinyint(2) default 0 comment '0 未删除，1 删除'
)default charset=utf8;

#商城字段
create table gb_mall_colums(
   id int(11) primary key not null auto_increment,
   mall_id int(11) default 0 comment '商城id',
   name varchar(30) default '' comment '字段名',
   ptype_status_id int(11) default 0 comment '状态id,0:自定义,10:到货时间'
)default charset=utf8;



#汇总表
create table gb_count_info(
   id int(11) primary key not null auto_increment,
   mall_id int(11) default 0 comment '商城id',
   shop_id int(11) default 0 comment '店铺id',
   product_id int(11) default 0 comment '产品id'
)default charset=utf8;

#字段值表
create table gb_colums_info(
   id int(11) primary key not null auto_increment,
   mall_colums_id int(11) default 0 comment '商城字段id',
   words varchar(50) default '' comment '字段值',
   shop_id int(11) default 0 comment '商城id',
   product_id int(11) default 0 comment '产品id'
)default charset=utf8;


insert into gb_admin_user(id, username, password, name, content, role_id, is_admin) values(1, 'admin', 'b8f0534b96bfd4a519c4894e0be3b138', '系统管理员', '最高权限', 1, 1);
insert into gb_roles(id, deport_id, name, content, attach_power_ids, text_power_ids, check_power_ids) values(1, 1, '系统管理员', '系统管理员', '1,2,3,4,5,6,7,8,9', '1,2,3,4,5,6,7,8,9', '1,2,3,4,5,6,7,8,9');
insert into gb_deport(id, name, content) values(1, '系统管理部门', '系统管理部门');

INSERT INTO `gb_menus` VALUES ('1', '首页', 'Index', 'index', '', 'tachometer', '0', '1', '1', '0', '', '1', '0', 'Index/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('2', '产品分类', '', '', '', 'list', '0', '2', '1', '0', '', '1', '0', 'javascript:void(0);', 'tag', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('3', '产品开发', 'Product', 'index', '', 'list', '0', '3', '1', '0', '', '1', '0', 'javascript:void(0);', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('4', '产品进度', 'ProductOrder', 'index', '', 'list', '0', '4', '1', '0', '', '1', '0', 'javascript:void(0);', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('5', '产品图片', 'ProductPic', 'index', '', 'list', '0', '5', '1', '0', '', '1', '0', 'javascript:void(0);', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('6', '平台上新', 'ProductSx', 'index', '', 'list', '0', '6', '1', '0', '', '1', '0', 'javascript:void(0);', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('7', '部门管理', '', '', '', 'desktop', '0', '7', '1', '0', '', '1', '0', 'javascript:void(0);', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('8', '流程说明资料', '', '', '', 'picture-o', '0', '8', '1', '0', '', '1', '0', 'javascript:void(0);', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('9', '大类列表', 'Category', 'index', '', '', '1', '1', '1', '2', '', '1', '0', 'Category/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('10', '添加大类', 'Category', 'add_info', '', '', '1', '2', '1', '2', '', '1', '0', 'Category/add_info', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('11', '产品系列', 'SubCategory', 'index', '', '', '1', '3', '1', '2', '', '1', '0', 'SubCategory/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('12', '添加系列', 'SubCategory', 'add_info', '', '', '1', '4', '1', '2', '', '1', '0', 'SubCategory/add_info', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('13', '产品列表', 'Product', 'index', '', '', '1', '1', '1', '3', '', '1', '0', 'Product/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('14', '新建产品', 'Product', 'add_info', '', '', '1', '2', '1', '3', '', '1', '0', 'Product/add_info', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('15', '未完成项目', 'ProductOrder', 'index', '', '', '1', '2', '1', '4', '', '1', '0', 'ProductOrder/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('16', '全部项目', 'ProductOrder', 'list_items', '', '', '1', '1', '1', '4', '', '1', '0', 'ProductOrder/list_items', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('17', '历史删除项目', 'ProductOrder', 'history', '', '', '1', '3', '1', '4', '', '1', '0', 'ProductOrder/history', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('18', '未完成项目', 'ProductPic', 'index', '', '', '1', '2', '1', '5', '', '1', '0', 'ProductPic/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('19', '全部项目', 'ProductPic', 'list_items', '', '', '1', '1', '1', '5', '', '1', '0', 'ProductPic/list_items', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('20', '历史删除项目', 'ProductPic', 'history', '', '', '1', '3', '1', '5', '', '1', '0', 'ProductPic/history', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('21', '汇总', 'CountInfo', 'index', '', '', '1', '1', '1', '6', '', '1', '0', 'CountInfo/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('24', '部门列表', 'Deport', 'index', '', '', '1', '1', '1', '7', '', '1', '0', 'Deport/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('25', '添加部门', 'Deport', 'add_info', '', '', '1', '2', '1', '7', '', '1', '0', 'Deport/add_info', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('26', '角色列表', 'Roles', 'index', '', '', '1', '3', '1', '7', '', '1', '0', 'Roles/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('27', '添加角色', 'Roles', 'add_info', '', '', '1', '4', '1', '7', '', '1', '0', 'Roles/add_info', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('28', '人员列表', 'AdminUser', 'index', '', '', '1', '5', '1', '7', '', '1', '0', 'AdminUser/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('29', '添加人员', 'AdminUser', 'add_info', '', '', '1', '6', '1', '7', '', '1', '0', 'AdminUser/add_info', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('30', '权限列表', 'Menus', 'index', '', '', '1', '7', '1', '7', '', '1', '0', 'Menus/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('31', '产品审核', 'Product', 'check', '', '', '1', '3', '0', '3', '', '1', '0', 'Product/check', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('32', '产品进度维护', 'ProductOrder', 'edit', '', '', '1', '4', '0', '4', '', '1', '0', 'Product/edit', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('33', '产品进度删除', 'ProductOrder', 'del', '', '', '1', '5', '0', '4', '', '1', '0', 'Product/del', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('34', '产品开发', 'Ptypes', 'detail', 'id=1', '', '1', '1', '1', '8', '', '1', '0', 'Ptypes/detail?id=1', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('35', '产品进度', 'Ptypes', 'detail', 'id=2', '', '1', '2', '1', '8', '', '1', '0', 'Ptypes/detail?id=2', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('36', '产品图片', 'Ptypes', 'detail', 'id=3', '', '1', '3', '1', '8', '', '1', '0', 'Ptypes/detail?id=3', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('37', '分类维护', 'Ptypes', 'edit', '', '', '1', '4', '0', '8', '', '1', '0', '', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('38', '删除产品图片', 'ProductOrder', 'del', '', '', '1', '5', '0', '5', '', '1', '0', 'ProductOrder/del', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('39', '商城维护', '', '', '', 'tag', '0', '9', '1', '0', '', '1', '0', 'javascript:void(0)', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('40', '商城列表', 'Mall', 'index', '', '', '1', '1', '1', '39', '', '1', '0', 'Mall/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('41', '商城添加', 'Mall', 'add_info', '', '', '1', '2', '1', '39', '', '1', '0', 'Mall/add_info', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('42', '商店列表', 'Shop', 'index', '', '', '1', '3', '1', '39', '', '1', '0', 'Shop/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('43', '商店添加', 'Shop', 'add_info', '', '', '1', '4', '1', '39', '', '1', '0', 'Shop/add_info', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('44', '修改产品', 'Product', 'edit', '', '', '1', '4', '0', '3', '', '1', '0', 'Product/edit', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('45', '添加汇总', 'CountInfo', 'add_info', '', '', '1', '2', '1', '6', '', '1', '0', 'CountInfo/add_info', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('46', '修改商城内容', 'CountInfo', 'upload', '', '', '1', '3', '0', '6', '', '1', '0', 'CountInfo/upload', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('47', '删除店铺统计', 'ShopCount', 'del', '', '', '1', '4', '0', '6', '', '1', '0', 'ShopCount/del', 'hsub', 'submenu nav-hide', '1');






insert into gb_role_menus(role_id, menus_id) values(1,1);
insert into gb_role_menus(role_id, menus_id) values(1,2);
insert into gb_role_menus(role_id, menus_id) values(1,3);
insert into gb_role_menus(role_id, menus_id) values(1,4);
insert into gb_role_menus(role_id, menus_id) values(1,5);
insert into gb_role_menus(role_id, menus_id) values(1,6);
insert into gb_role_menus(role_id, menus_id) values(1,7);
insert into gb_role_menus(role_id, menus_id) values(1,8);
insert into gb_role_menus(role_id, menus_id) values(1,9);
insert into gb_role_menus(role_id, menus_id) values(1,10);
insert into gb_role_menus(role_id, menus_id) values(1,11);
insert into gb_role_menus(role_id, menus_id) values(1,12);
insert into gb_role_menus(role_id, menus_id) values(1,13);
insert into gb_role_menus(role_id, menus_id) values(1,14);
insert into gb_role_menus(role_id, menus_id) values(1,15);
insert into gb_role_menus(role_id, menus_id) values(1,16);
insert into gb_role_menus(role_id, menus_id) values(1,17);
insert into gb_role_menus(role_id, menus_id) values(1,18);
insert into gb_role_menus(role_id, menus_id) values(1,19);
insert into gb_role_menus(role_id, menus_id) values(1,20);
insert into gb_role_menus(role_id, menus_id) values(1,21);
insert into gb_role_menus(role_id, menus_id) values(1,22);
insert into gb_role_menus(role_id, menus_id) values(1,23);
insert into gb_role_menus(role_id, menus_id) values(1,24);
insert into gb_role_menus(role_id, menus_id) values(1,25);
insert into gb_role_menus(role_id, menus_id) values(1,26);
insert into gb_role_menus(role_id, menus_id) values(1,27);
insert into gb_role_menus(role_id, menus_id) values(1,28);
insert into gb_role_menus(role_id, menus_id) values(1,29);
insert into gb_role_menus(role_id, menus_id) values(1,30);
insert into gb_role_menus(role_id, menus_id) values(1,31);
insert into gb_role_menus(role_id, menus_id) values(1,32);
insert into gb_role_menus(role_id, menus_id) values(1,33);
insert into gb_role_menus(role_id, menus_id) values(1,34);
insert into gb_role_menus(role_id, menus_id) values(1,35);
insert into gb_role_menus(role_id, menus_id) values(1,36);
insert into gb_role_menus(role_id, menus_id) values(1,37);
insert into gb_role_menus(role_id, menus_id) values(1,38);
insert into gb_role_menus(role_id, menus_id) values(1,39);
insert into gb_role_menus(role_id, menus_id) values(1,40);
insert into gb_role_menus(role_id, menus_id) values(1,41);
insert into gb_role_menus(role_id, menus_id) values(1,42);
insert into gb_role_menus(role_id, menus_id) values(1,43);

insert into gb_ptypes(id, name, content, admin_user_id, rank, status) values(1, '产品开发', '产品开发', 1, 1, 1);
insert into gb_ptypes(id, name, content, admin_user_id, rank, status) values(2, '产品进度', '产品进度', 1, 2, 1);
insert into gb_ptypes(id, name, content, admin_user_id, rank, status) values(3, '产品图片', '产品图片', 1, 3, 1);

insert into gb_ptype_status(id, ptype_id, name, admin_user_id, is_attach, is_text, rank) values(1, 3, '交样', 1, 1, 1, 1);
insert into gb_ptype_status(id, ptype_id, name, admin_user_id, is_attach, is_text, rank) values(2, 3, '文案', 1, 1, 1, 2);
insert into gb_ptype_status(id, ptype_id, name, admin_user_id, is_attach, is_text, rank) values(3, 3, '方案审核', 1, 1, 0, 3);
insert into gb_ptype_status(id, ptype_id, name, admin_user_id, is_attach, is_text, rank) values(4, 3, '拍照', 1, 1, 1, 4);
insert into gb_ptype_status(id, ptype_id, name, admin_user_id, is_attach, is_text, rank) values(5, 3, '详情页制作', 1, 1, 0, 5);
insert into gb_ptype_status(id, ptype_id, name, admin_user_id, is_attach, is_text, rank) values(6, 3, '详情页审核', 1, 1, 0, 6);
insert into gb_ptype_status(id, ptype_id, name, admin_user_id, is_attach, is_text, rank) values(7, 3, '首页制作', 1, 1, 1, 7);
insert into gb_ptype_status(id, ptype_id, name, admin_user_id, is_attach, is_text, rank) values(8, 3, '首页审核', 1, 1, 1, 8);
insert into gb_ptype_status(id, ptype_id, name, admin_user_id, is_attach, is_text, rank) values(9, 3, '完成', 1, 1, 1, 9);


insert into gb_mall(id,name,is_del,rank) values(1,'京东渠道上新明细',0,1);
insert into gb_mall(id,name,is_del,rank) values(2,'京东POP',0,2);
insert into gb_mall(id,name,is_del,rank) values(3,'天猫',0,3);
insert into gb_mall(id,name,is_del,rank) values(4,'淘宝',0,4);
insert into gb_mall(id,name,is_del,rank) values(5,'KA',0,5);
insert into gb_mall(id,name,is_del,rank) values(6,'市场',0,6);


insert into gb_mall_colums(id,mall_id,ptype_status_id) values(1,1,1);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(2,1,2);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(3,1,4);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(4,1,5);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(5,1,7);
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(6,1,0,'京东编码');
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(7,1,10,'到货时间');
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(8,1,0,'发货');
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(9,1,0,'渠道上新');
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(10,2,1);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(11,2,2);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(12,2,4);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(13,2,5);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(14,2,7);
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(15,2,0,'商城编码');
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(16,2,10,'到货时间');
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(17,2,0,'发货');
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(18,2,0,'渠道上新');
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(19,3,1);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(20,3,2);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(21,3,4);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(22,3,5);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(23,3,7);
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(24,3,0,'商城编码');
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(25,3,10,'到货时间');
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(26,3,0,'发货');
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(27,3,0,'渠道上新');
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(28,4,1);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(29,4,2);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(30,4,4);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(31,4,5);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(32,4,7);
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(33,4,0,'商城编码');
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(34,4,10,'到货时间');
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(35,4,0,'发货');
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(36,4,0,'渠道上新');
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(37,5,1);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(38,5,2);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(39,5,4);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(40,5,5);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(41,5,7);
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(42,5,0,'商城编码');
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(43,5,10,'到货时间');
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(44,5,0,'发货');
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(45,5,0,'渠道上新');
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(46,6,1);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(47,6,2);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(48,6,4);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(49,6,5);
insert into gb_mall_colums(id,mall_id,ptype_status_id) values(50,6,7);
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(51,6,0,'商城编码');
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(52,6,10,'到货时间');
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(53,6,0,'发货');
insert into gb_mall_colums(id,mall_id,ptype_status_id,name) values(54,6,0,'渠道上新');

create table gb_admin_user_log(
   id int(11) primary key not null auto_increment,
   source_id int(11) default 0 comment '对应id',
   ptype varchar(30) default 'product' comment '日志类型',
   content text comment '修改内容',
   admin_user_id int(11) default 0 comment '修改者id',
   create_time int(11) default 0 comment '创建时间'
)default charset=utf8;


#insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id, is_show) values(44, "修改产品", "Product", "edit", "", "Product/edit", "", 1, 4, 1, 3, 0);
insert into gb_role_menus(role_id, menus_id) values(1,44);

create table gb_product_order_deliver(
   id int(11) primary key not null auto_increment,
   product_order_id int(11) default 0 comment '产品id',
   content varchar(255) default '' comment '描述',
   num int(11) default '0' comment '收货数量',
   deliver_time int(11) default 0 comment '收货时间',
   admin_user_id int(11) default 0 comment '创建者',
   create_time int(11) default 0 comment '创建时间'
)default charset=utf8;

#insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) values(45, "添加汇总", "CountInfo", "add_info", "", "CountInfo/add_info", "", 1, 2, 1, 6);
insert into gb_role_menus(role_id, menus_id) values(1,45);

create table gb_product_pic_status_log(
   id int(11) primary key not null auto_increment,
   product_pic_status_id int(11) default 0 comment '产品图片进度状态id',
   content varchar(255) default '' comment '描述',
   admin_user_id int(11) default 0 comment '创建者',
   create_time int(11) default 0 comment '创建时间'
)default charset=utf8;

alter table gb_mall_colums add rank int(11) DEFAULT '0' COMMENT '排序';

#insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id, is_show) values(46, "修改商城内容", "CountInfo", "upload", "", "CountInfo/upload", "", 1, 3, 1, 6, 0);
#insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id, is_show) values(47, "删除店铺统计", "ShopCount", "del", "", "ShopCount/del", "", 1, 4, 1, 6, 0);

create table gb_role_shop(
   id int(11) primary key not null auto_increment,
   shop_id int(11) default 0 comment '店铺id',
   role_id int(11) default 0 comment '角色id',
   is_edit tinyint(2) default 0 comment '是否有修改权限',
   is_send tinyint(2) default 0 comment '是否有上新权限',
   is_del tinyint(2) default 0 comment '是否有删除权限'
)default charset=utf8;

alter table gb_count_info add nstatus int(11) default '0' comment '是否已上新，0未上新，1上新，2下架';
alter table gb_count_info add admin_user_id int(11) default 0 comment '提交者';
alter table gb_count_info add create_time int(11) default 0 comment '创建时间';


alter table gb_mall_colums add is_text tinyint(2) default 0 comment '是否允许文本';
alter table gb_mall_colums add is_attach tinyint(2) default 0 comment '是否允许附件';

create table gb_count_info_status(
   id int(11) primary key not null auto_increment,
   count_info_id int(11) default 0 comment '汇总id',
   mall_status_id int(11) default 0 comment '状态id，字段mall_colums表id',
   status tinyint(2) default 0 comment '状态，0未提交，1提交，2拒绝',
   admin_user_id int(11) default 0 comment '创建者',
   create_time int(11) default 0 comment '创建时间',
   checked_time int(11) default 0 comment '审核通过时间'
)default charset=utf8;

create table gb_count_info_status_attach(
   id int(11) primary key not null auto_increment,
   count_info_status_id int(11) default 0 comment '汇总id',
   url varchar(255) default '' comment '附件地址',
   content varchar(255) default '' comment '描述',
   admin_user_id int(11) default 0 comment '创建者',
   create_time int(11) default 0 comment '创建时间'
)default charset=utf8;

create table gb_product_base(
   id int(11) primary key not null auto_increment,
   category_id int(11) default 0 comment '产品大类',
   sub_category_id int(11) default 0 comment '产品系列',
   number varchar(100) default '' comment '辅代码',
   code varchar(100) default '' comment '物料代码',
   sold_price decimal(10, 2) default 0 comment '统一售价',
   now_price decimal(10, 2) default 0 comment '现价',
   name varchar(50) default '' comment '产品名称',
   content varchar(255) default '' comment '描述',
   pic_path varchar(255) default '' comment '图片',
   admin_user_id int(11) default 0 comment '创建者',
   is_del tinyint(2) default 0 comment '删除',
   create_time int(11) default 0 comment '创建时间',
   rank int(11) default 0 comment '排序'
)default charset=utf8;

insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id) values(48, "产品价格", "ProductBase", "index", "", "ProductBase/index", "list", 0, 7, 1);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) values(49, "产品价格列表", "ProductBase", "index", "", "ProductBase/index", "", 1, 1, 1, 48);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) values(50, "添加产品价格", "ProductBase", "add_info", "", "ProductBase/add_info", "", 1, 1, 2, 48);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id, is_show) values(51, "删除", "ProductBase", "del", "", "ProductBase/del", "", 1, 1, 3, 48, 0);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id, is_show) values(52, "修改", "ProductBase", "edit", "", "ProductBase/edit", "", 1, 1, 4, 48, 0);

#类别表
CREATE TABLE `gb_classification` (
  id int(11) primary key not null auto_increment,
  `name` varchar(100) DEFAULT '' COMMENT '产品名称',
  `number` varchar(50) DEFAULT '' COMMENT '产品货号',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `sub_category_id` int(11) DEFAULT '0' COMMENT '系列id',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '是否删除',
  `rank` int(11) DEFAULT '0' COMMENT '排序',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


INSERT INTO `gb_menus` VALUES ('53', '类别列表', 'Classification', 'index', '', '', '1', '5', '1', '2', '', '1', '0', 'Classification/index', 'hsub', 'submenu nav-hide', '1');
INSERT INTO `gb_menus` VALUES ('54', '添加类别', 'Classification', 'add_info', '', '', '1', '6', '1', '2', '', '1', '0', 'Classification/add_info', 'hsub', 'submenu nav-hide', '1');

alter table gb_product_base add min_price decimal(10,2) default 0 comment '最小价格';
alter table gb_product_base add classification_id int(11) default 0 comment '最小分类id';
alter table gb_product_base add update_time int(11) default 0 comment '更新时间';

alter table gb_products add classification_id int(11) default 0 comment '分类id';
alter table gb_admin_user add is_test tinyint(2) default 0 comment '是否为测试账号';

CREATE TABLE gb_process_types(
  id int(11) primary key not null auto_increment,
  `name` varchar(100) DEFAULT '' COMMENT '流程名称',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `rank` int(11) default 0 comment '排序',
  `table_name` varchar(100) default '所对应的表名'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

insert into gb_process_types(id, name, content, is_del, admin_user_id, rank, table_name) values(1, '公司临时审批表',  '公司临时审批表', 0, 1, 1, 'temporaries');
insert into gb_process_types(id, name, content, is_del, admin_user_id, rank, table_name) values(2, '广博集团出差申请单', '广博集团出差申请单', 0, 1, 2, 'businesses');
insert into gb_process_types(id, name, content, is_del, admin_user_id, rank, table_name) values(3, '广博集团请假单', '广博集团请假单', 0, 1, 3, 'leaves');
insert into gb_process_types(id, name, content, is_del, admin_user_id, rank, table_name) values(4, '内销办事处请假单', '内销办事处请假单', 0, 1, 4, 'do_leaves');
insert into gb_process_types(id, name, content, is_del, admin_user_id, rank, table_name) values(5, '内销办事处出差申请单', '内销办事处出差申请单', 0, 1, 5, 'do_businesses');
insert into gb_process_types(id, name, content, is_del, admin_user_id, rank, table_name) values(6, '内销办事处领用申请单', '内销办事处领用申请单', 0, 1, 6, 'do_uses');
insert into gb_process_types(id, name, content, is_del, admin_user_id, rank, table_name) values(7, '内销办事处促销申请单', '内销办事处促销申请单', 0, 1, 7, 'do_promotions');
insert into gb_process_types(id, name, content, is_del, admin_user_id, rank, table_name) values(8, '内销办事处调货报告', '内销办事处调货报告', 0, 1, 7, 'do_turn_goods');
insert into gb_process_types(id, name, content, is_del, admin_user_id, rank, table_name) values(9, '内销办事处临时外出单', '内销办事处临时外出单', 0, 1, 9, 'do_out_orders');
insert into gb_process_types(id, name, content, is_del, admin_user_id, rank, table_name) values(10, '内销推广会申请表', '内销推广会申请表', 0, 1, 10, 'do_promotion_meetings');
insert into gb_process_types(id, name, content, is_del, admin_user_id, rank, table_name) values(11, '内销广告设计制作申请表', '内销广告设计制作申请表', 0, 1, 11, 'do_designs');
insert into gb_process_types(id, name, content, is_del, admin_user_id, rank, table_name) values(12, '内销广告宣传物料申请表', '内销广告宣传物料申请表', 0, 1, 12, 'do_propagandas');
insert into gb_process_types(id, name, content, is_del, admin_user_id, rank, table_name) values(13, '内销贴码产品申请流程单', '内销贴码产品申请流程单', 0, 1, 13, 'do_post_codes');
insert into gb_process_types(id, name, content, is_del, admin_user_id, rank, table_name) values(14, '内销市场客户退货申请单', '内销市场客户退货申请单', 0, 1, 14, 'do_customer_returns');
insert into gb_process_types(id, name, content, is_del, admin_user_id, rank, table_name) values(15, '内销办事处电商爆款申请表', '内销办事处电商爆款申请表', 0, 1, 15, 'do_explosions');
insert into gb_process_types(id, name, content, is_del, admin_user_id, rank, table_name) values(16, '内销超额超期发货申请单', '内销超额超期发货申请单', 0, 1, 16, 'do_overdue_deliveries');

#1公司临时审批表
CREATE TABLE gb_temporaries(
  id int(11) primary key not null auto_increment,
  no varchar(50) default '' comment '单据号',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  report_time int(11) default 0 comment '填写报告时间',
  is_over int(11) default 0 comment '是否结束',
  `rank` int(11) default 0 comment '排序'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_temporary_attaches(
  id int(11) primary key not null auto_increment,
  temporary_id int(11) default 0 comment '公司临时审批表id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_temporaries_status(
  id int(11) primary key not null auto_increment,
  temporary_id int(11) default 0 comment '公司临时审批表id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  status int(11) default 0 comment '状态：0未审核，1审核通过，2审核不通过'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


#2广博集团出差申请单
CREATE TABLE gb_businesses(
  id int(11) primary key not null auto_increment,
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  address varchar(255) default '' comment '出差地点',
  input_time int(11) default 0 comment '填写时间',
  start_time int(11) default 0 comment '开始时间',
  end_time int(11) default 0 comment '结束时间',
  days decimal(10,2) default 0 comment '天数',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_businesses_attaches(
  id int(11) primary key not null auto_increment,
  business_id int(11) default 0 comment '广博集团出差申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_businesses_status(
  id int(11) primary key not null auto_increment,
  businesses_id int(11) default 0 comment '广博集团出差申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  status int(11) default 0 comment '状态：0未审核，1审核通过，2审核不通过'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#3广博集团请假单
CREATE TABLE gb_leaves(
  id int(11) primary key not null auto_increment,
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  start_time int(11) default 0 comment '开始时间',
  end_time int(11) default 0 comment '结束时间',
  days decimal(10, 2) default 0 comment '天数',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_leaves_attaches(
  id int(11) primary key not null auto_increment,
  leaves_id int(11) default 0 comment '广博集团请假单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_leaves_status(
  id int(11) primary key not null auto_increment,
  leaves_id int(11) default 0 comment '广博集团请假单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  status int(11) default 0 comment '状态：0未审核，1审核通过，2审核不通过'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#4内销办事处请假单
CREATE TABLE gb_do_leaves(
  id int(11) primary key not null auto_increment,
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  ptype int(11) default 0 comment '请假类别：1探亲假，2事假，3病假，4婚假，5丧假，6公假，7工伤，8产假，9其他',
  start_time int(11) default 0 comment '开始时间',
  end_time int(11) default 0 comment '结束时间',
  days decimal(10, 2) default 0 comment '所用时间',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_leaves_attaches(
  id int(11) primary key not null auto_increment,
  do_leaves_id int(11) default 0 comment '内销办事处请假单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_leaves_status(
  id int(11) primary key not null auto_increment,
  leaves_id int(11) default 0 comment '内销办事处请假单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  status int(11) default 0 comment '状态：0未审核，1审核通过，2审核不通过'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#5内销办事处出差申请单
CREATE TABLE gb_do_businesses(
  id int(11) primary key not null auto_increment,
  `address` varchar(255) DEFAULT '' COMMENT '流程名称',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  start_time int(11) default 0 comment '开始时间',
  end_time int(11) default 0 comment '结束时间',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_businesses_attaches(
  id int(11) primary key not null auto_increment,
  do_leaves_id int(11) default 0 comment '内销办事处出差申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_businesses_status(
  id int(11) primary key not null auto_increment,
  do_business_id int(11) default 0 comment '内销办事处出差申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#6内销办事处领用申请单
CREATE TABLE gb_do_uses(
  id int(11) primary key not null auto_increment,
  reason varchar(255) DEFAULT '' COMMENT '领用原因',
  is_back tinyint(2) default 0 comment '是否归还',
  back_time int(11) default 0 comment '归还时间',
  is_return tinyint(2) default 0 comment '是否无法归还',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_use_attaches(
  id int(11) primary key not null auto_increment,
  do_use_id int(11) default 0 comment '内销办事处领用申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_use_items(
  id int(11) primary key not null auto_increment,
  do_use_id int(11) default 0 comment '内销办事处领用申请单id',
  product_id int(11) DEFAULT 0 COMMENT '产品id',
  num int(11) DEFAULT 0 COMMENT '数量',
  unit varchar(30) default '' comment '单位',
  content varchar(255) default '' comment '备注',
  back_num int(11) default 0 comment '归还数量',
  back_time int(11) default 0 comment '归还时间',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_use_status(
  id int(11) primary key not null auto_increment,
  do_use_id int(11) default 0 comment '内销办事处领用申请单id',
  content varchar(255) DEFAULT '' COMMENT '描述',
  status tinyint(2) default 0 comment '状态：0未审核，1审核通过，2审核不通过',
  admin_user_id int(11) DEFAULT '0' COMMENT '创建者id',
  create_time int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#7内销办事处促销申请单
CREATE TABLE gb_do_promotions(
  id int(11) primary key not null auto_increment,
  send_time int(11) default 0 comment '提交时间',
  `user_name` varchar(100) DEFAULT '' COMMENT '客户名称',
  no varchar(50) default '' comment '合同号',
  ht_time int(11) default 0 comment '合同时间',
  promotion_content varchar(255) default '' comment '促销内容说明',
  `main_content` varchar(255) DEFAULT '' COMMENT '重点产口需求说明',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  price decimal(10, 2) default 0 comment '应收货款金额',
  promotion_credit decimal(10, 2) default 0 comment '促销额度',
  promotion_start_time int(11) default 0 comment '促销活动开始时间',
  promotion_end_time int(11) default 0 comment '促销活动结束时间',
  over_price decimal(10, 2) default 0 comment '到期货款金额',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_promotion_attaches(
  id int(11) primary key not null auto_increment,
  do_promotion_id int(11) default 0 comment '内销办事处促销申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_promotion_status(
  id int(11) primary key not null auto_increment,
  do_promotion_id int(11) default 0 comment '内销办事处促销申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  status tinyint(2) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#8内销办事处调货报告
CREATE TABLE gb_do_turn_goods(
  id int(11) primary key not null auto_increment,
  office_id int(11) default 0 comment '办事外/人员',
  phone varchar(50) default '' comment '电话',
  postage decimal(10, 2) default 0 comment '邮费',
  consignee varchar(100) default '' comment '收货人',
  address varchar(255) DEFAULT '' COMMENT '地址',
  reason varchar(255) default '' comment '调货原因',
  tg_time int(11) default 0 comment '调货时间',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_turn_good_attaches(
  id int(11) primary key not null auto_increment,
  do_turn_good_id int(11) default 0 comment '内销办事处调货报告id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_turn_good_items(
  id int(11) primary key not null auto_increment,
  do_turn_good_id int(11) default 0 comment '内销办事处调货报告id',
  number varchar(50) default '' comment '物料编码',
  name varchar(100) default '' comment '物料名称',
  num int(11) default 0 comment '件数',
  office_id int(11) default 0 comment '调出办事处',
  content varchar(255) default '' comment '备注',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_turn_good_status(
  id int(11) primary key not null auto_increment,
  do_turn_good_id int(11) default 0 comment '内销办事处调货报告id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#9内销办事处临时外出单
CREATE TABLE gb_do_out_orders(
  id int(11) primary key not null auto_increment,
  office_id int(11) default 0 comment '办事外/人员',
  address varchar(100) DEFAULT '' COMMENT '前往何处',
  lw_time int(11) default 0 comment '来往时间',
  `content` varchar(255) DEFAULT '' COMMENT '事由',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_out_order_attaches(
  id int(11) primary key not null auto_increment,
  do_out_order_id int(11) default 0 comment '内销办事处临时外出单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_out_order_status(
  id int(11) primary key not null auto_increment,
  do_out_order_id int(11) default 0 comment '内销办事处临时外出单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#10内销推广会申请表
CREATE TABLE gb_do_promotion_meetings(
  id int(11) primary key not null auto_increment,
  user_name varchar(100) DEFAULT '' COMMENT '客户名称',
  address varchar(255) DEFAULT '' COMMENT '会议地点',
  meeting_time int(11) DEFAULT '0' COMMENT '会议时间',
  zc_lh varchar(50) default '' comment '专场/联合',
  plan_price decimal(10, 2) default 0 comment '预计销售目标（万）',
  back_price decimal(10, 2) default 0 comment '计划回款（万）',
  back_end_time int(11) default 0 comment '汇款时间截止',
  ptype int(11) default 0 comment '会议目的，1新客户开发，2产品推广（重点产品推进），3客户产品扩充，4客户维护，5新区域品牌推广，6销售提升',
  zc_time int(11) default 0 comment '政策时间',
  content varchar(255) default '' comment '促销产品及政策',
  ad_content varchar(255) default '' comment '广告制作例费用说明', 
  fixed_price decimal(10, 2) default 0 comment '固定会议费',
  wl_content varchar(255) default '' comment '物料申请',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_promotion_meeting_attaches(
  id int(11) primary key not null auto_increment,
  do_promotion_meeting_id int(11) default 0 comment '公司临时审批表id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_promotion_meeting_status(
  id int(11) primary key not null auto_increment,
  do_promotion_meeting_id int(11) default 0 comment '公司临时审批表id',
  content varchar(255) DEFAULT '' COMMENT '描述',
  admin_user_id int(11) DEFAULT '0' COMMENT '创建者id',
  create_time int(11) DEFAULT '0' COMMENT '创建时间',
  status tinyint(2) default 0 comment '状态：0未审核，1审核通过，2审核不通过'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#11内销广告设计制作申请表
CREATE TABLE gb_do_designs(
  id int(11) primary key not null auto_increment,
  office_id int(11) default 0 comment '办事处经理',
  salesman varchar(100) default '' comment '业务员',
  apply_time int(11) default 0 comment '申请时间',
  qq varchar(100) default '' comment '广告设计后接收人QQ号',
  shop_name varchar(100) default '' comment '店铺',
  management_name varchar(100) DEFAULT '' COMMENT '经营负责人',
  phone varchar(255) DEFAULT '' COMMENT '联系电话',
  address varchar(255) default '' comment '联系地址',
  distributor_name varchar(100) default '' comment '上级经销商',
  shop_type tinyint(2) default 0 comment '会员店形式，1原广博终端店升级为会员店，2新开会员店',
  qy_type tinyint(2) default 0 comment '签约方式，1销售合同，2三方协议',
  qy_price decimal(10, 2) default 0 comment '签约金额',
  first_price decimal(10, 2) default 0 comment '首次进货金额',
  first_num int(11) default 0 comment '首次进货数量',
  gg_num int(11) default 0 comment '高柜',
  zd_num int(11) default 0 comment '中岛',
  publish_con varchar(100) default '' comment '广告发布（店招/室内）',
  user_type int(11) default 0 comment '客户类型：1托盘商/合作办事处，2核心客户，3重点客户，4生意客户',
  content varchar(255) default '' comment '备注',
  price decimal(10,2) default 0 comment '所需费用',
  wh_content varchar(255) default '' comment '室内广告（宽*高）设计中需增加任何产品形像图的请说明',
  other_content varchar(255) default '' comment '其它物料',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_design_attaches(
  id int(11) primary key not null auto_increment,
  do_design_id int(11) default 0 comment '内销广告设计制作申请表id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_design_status(
  id int(11) primary key not null auto_increment,
  do_design_id int(11) default 0 comment '内销广告设计制作申请表id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  status tinyint(3) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_design_items(
  id int(11) primary key not null auto_increment,
  do_design_id int(11) default 0 comment '内销广告设计制作申请表id',
  order_time int(11) DEFAULT 0 COMMENT '日期',
  price decimal(10, 2) default 0 comment '进货金额',
  num int(11) default 0 comment '品项数量',
  admin_user_id int(11) DEFAULT '0' COMMENT '创建者id',
  create_time int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#12内销广告宣传物料申请表
CREATE TABLE gb_do_propagandas(
  id int(11) primary key not null auto_increment,
  naddress varchar(255) default '' comment '区域市场',
  office_id int(11) default 0 comment '办事处经理',
  salesman varchar(100) default '' comment '业务员',
  apply_time int(11) default 0 comment '申请时间',
  qq varchar(100) default '' comment '广告设计后接收人QQ号',
  shop_name varchar(100) default '' comment '店名',
  management_name varchar(100) DEFAULT '' COMMENT '经营负责人',
  phone varchar(255) DEFAULT '' COMMENT '联系电话',
  address varchar(255) default '' comment '联系地址',
  distributor_name varchar(100) default '' comment '上级经销商',
  shop_type tinyint(2) default 0 comment '会员店形式，1原广博终端店升级为会员店，2新开会员店',
  qy_type tinyint(2) default 0 comment '签约方式，1销售合同，2三方协议',
  qy_price decimal(10, 2) default 0 comment '签约金额',
  first_price decimal(10, 2) default 0 comment '首次进货金额',
  first_num int(11) default 0 comment '首次进货数量',
  gg_num int(11) default 0 comment '高柜',
  zd_num int(11) default 0 comment '中岛',
  publish_con varchar(100) default '' comment '广告发布（店招/室内）',
  user_type int(11) default 0 comment '客户类型：1托盘商/合作办事处，2核心客户，3重点客户，4生意客户',
  g_num int(11) DEFAULT '0' COMMENT '高柜',
  z_num int(11) DEFAULT '0' COMMENT '中柜',
  o_num int(11) DEFAULT '0' COMMENT '其他',
  content varchar(255) default '' comment '备注',
  wl_name varchar(100) default '' comment '名称及数量',
  other_content varchar(255) default '' comment '其它物料',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_propaganda_attaches(
  id int(11) primary key not null auto_increment,
  do_propaganda_id int(11) default 0 comment '内销广告宣传物料申请表id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_propaganda_items(
  id int(11) primary key not null auto_increment,
  do_propaganda_id int(11) default 0 comment '内销广告宣传物料申请表id',
  order_time int(11) DEFAULT 0 COMMENT '日期',
  price decimal(10, 2) default 0 comment '进货金额',
  num int(11) default 0 comment '品项数量',
  admin_user_id int(11) DEFAULT '0' COMMENT '创建者id',
  create_time int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_propaganda_status(
  id int(11) primary key not null auto_increment,
  do_propaganda_id int(11) default 0 comment '内销广告宣传物料申请表id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  status tinyint(2) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


#13内销贴码产品申请流程单
CREATE TABLE gb_do_post_codes(
  id int(11) primary key not null auto_increment,
  market_name varchar(100) DEFAULT '' COMMENT '超市名称',
  shop_name varchar(100) default '' comment '店别',
  reason varchar(255) DEFAULT '' COMMENT '贴码原因',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_post_code_attaches(
  id int(11) primary key not null auto_increment,
  do_post_code_id int(11) default 0 comment '内销贴码产品申请流程单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_post_code_products(
  id int(11) primary key not null auto_increment,
  do_post_code_id int(11) default 0 comment '内销贴码产品申请流程单id',
  product_id int(11) DEFAULT 0 COMMENT '产品id',
  change_id int(11) default 0 comment '替代产品id',
  plan_order_price decimal(10, 2) default 0 comment '订单计划单价',
  plan_change_price decimal(10, 2) default 0 comment '替代计划单价',
  unit varchar(20) default '' comment '单位',
  num int(11) default 0 comment '数量',
  status tinyint(2) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_post_code_status(
  id int(11) primary key not null auto_increment,
  do_post_code_id int(11) default 0 comment '内销贴码产品申请流程单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  status tinyint(2) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#14内销市场客户退货申请单
CREATE TABLE gb_do_customer_returns(
  id int(11) primary key not null auto_increment,
  office_id int(11) DEFAULT 0 COMMENT '办事处id',
  user_name varchar(100) default 0 comment '客户名称',
  reason varchar(255) DEFAULT '' COMMENT '退货原因',
  succ_num int(11) default 0 comment '总合格',
  warn_num int(11) default 0 comment '总待修',
  err_num int(11) default 0 comment '总报废',
  user_rate decimal(10, 2) default 0 comment '客户年累计退货率',
  warn_rate decimal(10, 2) default 0 comment '客户年累计报损率',
  do_user_rate decimal(10, 2) default 0 comment '办事处年累计退货率',
  do_warn_rate decimal(10, 2) default 0 comment '办事处年累计报损率',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_customer_return_items(
  id int(11) primary key not null auto_increment,
  do_customer_return_id int(11) default 0 comment '内销市场客户退货申请单id',
  attr_name varchar(100) DEFAULT '' COMMENT '属性',
  number varchar(100) DEFAULT '0' COMMENT '型号',
  name varchar(100) default 0 comment '名称',
  num varchar(100) default 0 comment '数量',
  price decimal(10, 2) default 0 comment '单价',
  total_price decimal(10, 2) default 0 comment '金额',
  status tinyint(2) default 0 comment '仓库主管确认类型：0未确认，1合格，2待修，3报废',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_customer_return_attaches(
  id int(11) primary key not null auto_increment,
  do_customer_return_id int(11) default 0 comment '内销市场客户退货申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_customer_return_status(
  id int(11) primary key not null auto_increment,
  do_customer_return_id int(11) default 0 comment '内销市场客户退货申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  status tinyint(3) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#15内销办事处电商爆款申请表
CREATE TABLE gb_do_explosions(
  id int(11) primary key not null auto_increment,
  user_name varchar(100) DEFAULT '' COMMENT '客户名称',
  shop_name varchar(255) DEFAULT '' COMMENT '店铺名称',
  shop_year varchar(255) DEFAULT '' COMMENT '年度指标',
  shop_type varchar(255) DEFAULT '' COMMENT '店铺类型及等级',
  shop_url varchar(255) DEFAULT '' COMMENT '店铺链接',
  activity_time int(11) DEFAULT 0 COMMENT '活动时间',
  
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_explosion_attaches(
  id int(11) primary key not null auto_increment,
  do_explosion_id int(11) default 0 comment '内销办事处电商爆款申请表id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_explosion_items(
  id int(11) primary key not null auto_increment,
  do_explosion_id int(11) default 0 comment '内销办事处电商爆款申请表id',
  product_id int(11) default 0 comment '产品id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  apply_price decimal(10, 2) default 0 comment '申请价格',
  apply_num int(11) default 0 comment '申请数量',
  price decimal(10,2) default 0 comment '零售价',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_explosion_status(
  id int(11) primary key not null auto_increment,
  do_explosion_id int(11) default 0 comment '内销办事处电商爆款申请表id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  status tinyint(2) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#16内销超额超期发货申请单
CREATE TABLE gb_do_overdue_deliveries(
  id int(11) primary key not null auto_increment,
  office_id int(11) default 0 comment '部门/业务员',
  apply_time int(11) default 0 comment '申请时间',
  user_name varchar(255) default '' comment '客户名称',
  apply_type decimal(10,2) DEFAULT 0 COMMENT '申请性质',
  credit_price decimal(10,2) DEFAULT 0 COMMENT '授信额度',
  flow_price decimal(10,2) DEFAULT 0 COMMENT '超额金额',
  days int(11) default 0 comment '付款期限',
  total_price decimal(10,2) default 0 comment '应收款金额',
  flow_time int(11) default 0 comment '超期时间',
  flow_time_price decimal(10, 2) default 0 comment '超期金额',
  apply_delivery_num int(11) default 0 comment '申请发货数',
  delivery_price decimal(10, 2) default 0 comment '发货金额',
  content varchar(255) default '' comment '备注或原因',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_overdue_delivery_attaches(
  id int(11) primary key not null auto_increment,
  do_overdue_delivery_id int(11) default 0 comment '内销超额超期发货申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  url_path varchar(255) default 0 comment '附件地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gb_do_overdue_delivery_status(
  id int(11) primary key not null auto_increment,
  do_overdue_delivery_id int(11) default 0 comment '内销超额超期发货申请单id',
  `content` varchar(255) DEFAULT '' COMMENT '描述',
  status tinyint(2) DEFAULT '0' COMMENT '状态：0未审核，1审核通过，2审核不通过',
  `admin_user_id` int(11) DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) 
values(55, "工作流程", "", "", "", "javascript:void(0);", "list-alt", 0, 1, 1, 0);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) 
values(56, "公司临时审批表", "Temporary", "index", "", "Temporary/index", "", 1, 1, 1, 55);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) 
values(57, "广博集团出差申请单", "Business", "index", "", "Business/index", "", 1, 2, 1, 55);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) 
values(58, "广博集团请假单", "Leave", "index", "", "Leave/index", "", 1, 3, 1, 55);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) 
values(59, "内销办事处请假单", "DoLeave", "index", "", "DoLeave/index", "", 1, 4, 1, 55);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) 
values(60, "内销办事处出差申请单", "DoBusiness", "index", "", "DoBusiness/index", "", 1, 5, 1, 55);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) 
values(61, "内销办事处领用申请单", "DoUse", "index", "", "DoUse/index", "", 1, 6, 1, 55);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) 
values(62, "内销办事处促销申请单", "DoPromotion", "index", "", "DoPromotions/index", "", 1, 7, 1, 55);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) 
values(63, "内销办事处调货报告", "DoTurnGood", "index", "", "DoTurnGood/index", "", 1, 8, 1, 55);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) 
values(64, "内销办事处临时外出单", "DoOutOrder", "index", "", "DoOutOrder/index", "", 1, 9, 1, 55);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) 
values(65, "内销推广会申请表", "DoPromotionMeeting", "index", "", "DoPromotionMeeting/index", "", 1, 10, 1, 55);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) 
values(66, "内销广告设计制作申请表", "DoDesign", "index", "", "DoDesign/index", "", 1, 11, 1, 55);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) 
values(67, "内销广告宣传物料申请表", "DoPropaganda", "index", "", "DoPropaganda/index", "", 1, 12, 1, 55);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) 
values(68, "内销贴码产品申请流程单", "DoPostCode", "index", "", "DoPostCode/index", "", 1, 13, 1, 55);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) 
values(69, "内销市场客户退货申请单", "DoCustomerReturn", "index", "", "DoCustomerReturn/index", "", 1, 14, 1, 55);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) 
values(70, "内销办事处电商爆款申请表", "DoExplosion", "index", "", "DoExplosion/index", "", 15, 1, 1, 55);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) 
values(71, "内销超额超期发货申请单", "DoOverdueDelivery", "index", "", "DoOverdueDelivery/index", "", 1, 16, 1, 55);


insert into gb_role_menus(role_id, menus_id) value(1,55);
insert into gb_role_menus(role_id, menus_id) value(1,56);
insert into gb_role_menus(role_id, menus_id) value(1,57);
insert into gb_role_menus(role_id, menus_id) value(1,58);
insert into gb_role_menus(role_id, menus_id) value(1,59);
insert into gb_role_menus(role_id, menus_id) value(1,60);
insert into gb_role_menus(role_id, menus_id) value(1,61);
insert into gb_role_menus(role_id, menus_id) value(1,62);
insert into gb_role_menus(role_id, menus_id) value(1,63);
insert into gb_role_menus(role_id, menus_id) value(1,64);
insert into gb_role_menus(role_id, menus_id) value(1,65);
insert into gb_role_menus(role_id, menus_id) value(1,66);
insert into gb_role_menus(role_id, menus_id) value(1,67);
insert into gb_role_menus(role_id, menus_id) value(1,68);
insert into gb_role_menus(role_id, menus_id) value(1,69);
insert into gb_role_menus(role_id, menus_id) value(1,70);
insert into gb_role_menus(role_id, menus_id) value(1,71);


alter table gb_temporaries add make_id int(11) default 0 comment '制单人id';
alter table gb_temporaries add deport_id int(11) default 0 comment '报告递交部门';
alter table gb_temporaries add user_name varchar(100) default '' comment '报告递交人员';
alter table gb_temporaries add deport_name varchar(100) default '' comment '报告递交部门';
alter table gb_do_overdue_deliveries add no varchar(100) default '' comment '单据号';
alter table gb_do_overdue_deliveries add is_del tinyint(1) default 0 comment '是否被删除';
alter table gb_do_explosions add no varchar(100) default '' comment '单据号';
alter table gb_do_explosions add platform varchar(100) default '' comment '活动平台';
alter table gb_do_explosions add activity_cost decimal(10,2) default 0 comment '活动付费';
alter table gb_do_explosions add explosion_goal varchar(255) default '' comment  '爆款目的';
alter table gb_do_explosions add related_products varchar(255) default '' comment  '关联销售产品';
alter table gb_do_explosions add last_month_sales int(7) default 0 comment  '上月店铺销量';
alter table gb_do_explosions add last_week_sales int(7) default 0 comment  '上周店铺销量';
alter table gb_do_explosions add gb_sale_items int(7) default 0 comment  '广博在售单品数';
alter table gb_do_explosions add poi float default 0 comment  '转化率';
alter table gb_do_explosions add content varchar(255) default '' comment  '爆款单品政策内容说明';
alter table gb_do_overdue_delivery_status add url_path varchar(100) default '' comment '附件地址';
alter table gb_do_overdue_delivery_status add name varchar(100) default '' comment '附件说明';
alter table gb_do_explosion_status add url_path varchar(100) default '' comment '附件地址';
alter table gb_do_explosion_status add name varchar(100) default '' comment '附件说明';
alter table gb_do_customer_returns add `no` varchar(100) default '' comment '单据号';
alter table gb_do_customer_return_status add url_path varchar(100) default '' comment '附件地址';
alter table gb_do_customer_return_status add name varchar(100) default '' comment '附件说明';

insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id, is_show) 
values(72, "添加", "Temporary", "add", "", "Temporary/add", "", 1, 16, 1, 56, 0);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id, is_show) 
values(73, "修改", "Temporary", "edit", "", "Temporary/edit", "", 1, 16, 1, 56, 0);
insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id, is_show) 
values(74, "详情", "Temporary", "detail", "", "Temporary/detail", "", 1, 16, 1, 56, 0);

alter table gb_temporaries_status add url_path varchar(255) default '' comment  '附件地址';
alter table gb_temporaries_status add name varchar(255) default '' comment  '附件描述';

#工作流程对应状态
CREATE TABLE gb_process_type_status(
  id int(11) primary key not null auto_increment,
  process_type_id int(11) default 0 comment '工作流程id',
  name varchar(100) DEFAULT '' COMMENT '状态名称',
  content text COMMENT '状态描述',
  is_del tinyint(3) DEFAULT 0 COMMENT '是否删除',
  checked_user_id int(11) default 0 comment '审核人',
  admin_user_id int(11) DEFAULT 0 COMMENT '创建者id',
  create_time int(11) DEFAULT 0 COMMENT '创建时间',
  rank int(11) default 0 comment '排序'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

update gb_menus set rank=rank+1 where id!=1;

insert into gb_menus(id, name, controller_name, action_name, params, url, class_code, ptype, rank, admin_user_id, parent_id) 
values(75, "工作流程配置", "ProcessType", "index", "", "ProcessType/index", "pencil-square-o", 0, 1, 1, 0);


alter table gb_process_types add update_time int(11) default 0 comment  '更新时间';
alter table gb_process_types add update_user_id int(11) default 0 comment  '操作人';

insert into gb_role_menus(role_id, menus_id) values(1, 75);

alter table gb_do_businesses add `no` varchar(50) default '' comment  '单据号';
alter table gb_do_businesses add office_id int(11) default '0' comment  '办事处';
alter table gb_do_out_orders add `no` varchar(50) default '' comment  '单据号';
alter table gb_admin_user add is_office tinyint(2) default '0' comment  '是否为办事处人员';
alter table gb_do_promotion_meetings add `no` varchar(50) default '' comment  '单据号';
alter table gb_do_designs add `no` varchar(50) default '' comment  '单据号';

update gb_menus set rank=15, ptype=1 where id=70;

alter table gb_temporaries_status add process_type_status_id int(11) default 0 comment '审核状态id';
alter table gb_process_types change table_name controller_name varchar(50);
update gb_process_types set controller_name='Temporary' where id=1;
update gb_process_types set controller_name='Business' where id=2;
update gb_process_types set controller_name='Leave' where id=3;
update gb_process_types set controller_name='DoLeave' where id=4;
update gb_process_types set controller_name='DoBusiness' where id=5;
update gb_process_types set controller_name='DoUse' where id=6;
update gb_process_types set controller_name='DoPromotions' where id=7;
update gb_process_types set controller_name='DoTurnGood' where id=8;
update gb_process_types set controller_name='DoOutOrder' where id=9;
update gb_process_types set controller_name='DoPromotionMeeting' where id=10;
update gb_process_types set controller_name='DoDesign' where id=11;
update gb_process_types set controller_name='DoPropaganda' where id=12;
update gb_process_types set controller_name='DoPostCode' where id=13;
update gb_process_types set controller_name='DoCustomerReturn' where id=14;
update gb_process_types set controller_name='DoExplosion' where id=15;
update gb_process_types set controller_name='DoOverdueDelivery' where id=16;

alter table gb_do_propagandas add `no` varchar(50) default '' comment  '单据号';
alter table gb_do_post_codes add `no` varchar(50) default '' comment  '单据号';
alter table gb_do_post_codes add office_id int(11) default '0' comment  '办事处';
alter table gb_do_post_codes add apply_time int(11) default '0' comment  '申请日期';
alter table gb_do_post_code_products add barcode varchar(50) default '' comment  '贴码条形码';
alter table gb_do_promotion_meetings add is_del int(11) default '0' comment  '是否删除，0：未删除，1：删除';


alter table gb_businesses add no varchar(50) DEFAULT '' COMMENT '单据号';
alter table gb_businesses add deport_id int(11) DEFAULT '0' COMMENT '部门ID';
alter table gb_businesses add note varchar(500) DEFAULT '' COMMENT '备注';
alter table gb_businesses add transportation varchar(255) DEFAULT '' COMMENT '交通方式';
alter table gb_leaves add no varchar(50) DEFAULT '' COMMENT '单据号';
alter table gb_leaves add ptype int(11) DEFAULT '0' COMMENT '请假类别：1探亲假，2事假，3病假，4婚假，5丧假，6公假，7工伤，8产假，9其他';
alter table gb_leaves add name varchar(100) DEFAULT '' COMMENT '姓名';
alter table gb_leaves add deport_id int(11) DEFAULT '0' COMMENT '部门ID';
alter table gb_leaves add job_id varchar(50) DEFAULT '' COMMENT '工号';
alter table gb_do_leaves add `no` varchar(50) DEFAULT '' COMMENT '单据号';
alter table gb_do_leaves add deport_id int(11) DEFAULT '0' COMMENT '部门ID';
alter table gb_do_leaves add job varchar(255) DEFAULT '' COMMENT '职务';
alter table gb_do_leaves add `no` varchar(50) DEFAULT '' COMMENT '单据号';
alter table gb_do_uses add `no` varchar(50) DEFAULT '' COMMENT '单据号';
alter table gb_do_uses add deport_id int(11) DEFAULT '0' COMMENT '职务';
alter table gb_do_uses add product_name varchar(255) DEFAULT '' COMMENT '产品名称';
alter table gb_do_promotions add dj_no varchar(50) DEFAULT '' COMMENT '单据号';
alter table gb_do_promotions add promotion_category varchar(255) DEFAULT '' COMMENT '促销品类';
alter table gb_do_promotions add gross_profit varchar(255) DEFAULT '' COMMENT '1月至本月的毛利';
alter table gb_do_promotions add exception_specification varchar(255) DEFAULT '' COMMENT '毛利异动说明';
alter table gb_do_promotions add deport_id int(11) DEFAULT '0' COMMENT '部门ID';
alter table gb_do_use_items add product_name varchar(255) DEFAULT '' COMMENT '产品名称';

#不同用户不同首页配置
CREATE TABLE gb_user_config(
  id int(11) primary key not null auto_increment,
  process_type_id int(11) default 0 comment '工作流程id',
  name varchar(100) DEFAULT '' COMMENT '状态名称',
  content text COMMENT '状态描述',
  is_del tinyint(3) DEFAULT 0 COMMENT '是否删除',
  checked_user_id int(11) default 0 comment '审核人',
  admin_user_id int(11) DEFAULT 0 COMMENT '创建者id',
  create_time int(11) DEFAULT 0 COMMENT '创建时间',
  rank int(11) default 0 comment '排序'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
alter table gb_do_use_items add product_name varchar(255) DEFAULT '' COMMENT '产品名称';

alter table gb_businesses add is_over int(11) DEFAULT '0' COMMENT '是否结束';
alter table gb_businesses_status add url_path varchar(255) default '' comment  '附件地址';
alter table gb_businesses_status add name varchar(255) default '' comment  '附件描述';
alter table gb_businesses_status add process_type_status_id int(11) default 0 comment '审核状态id';
alter table gb_leaves add is_over int(11) DEFAULT '0' COMMENT '是否结束';
alter table gb_leaves_status add url_path varchar(255) default '' comment  '附件地址';
alter table gb_leaves_status add name varchar(255) default '' comment  '附件描述';
alter table gb_leaves_status add process_type_status_id int(11) default 0 comment '审核状态id';
alter table gb_do_businesses add is_over int(11) DEFAULT '0' COMMENT '是否结束';
alter table gb_do_businesses_status add url_path varchar(255) default '' comment  '附件地址';
alter table gb_do_businesses_status add name varchar(255) default '' comment  '附件描述';
alter table gb_do_businesses_status add process_type_status_id int(11) default 0 comment '审核状态id';
alter table gb_do_uses add is_over int(11) DEFAULT '0' COMMENT '是否结束';
alter table gb_do_use_status add url_path varchar(255) default '' comment  '附件地址';
alter table gb_do_use_status add name varchar(255) default '' comment  '附件描述';
alter table gb_do_use_status add process_type_status_id int(11) default 0 comment '审核状态id';
alter table gb_do_promotions add is_over int(11) DEFAULT '0' COMMENT '是否结束';
alter table gb_do_promotion_status add url_path varchar(255) default '' comment  '附件地址';
alter table gb_do_promotion_status add name varchar(255) default '' comment  '附件描述';
alter table gb_do_promotion_status add process_type_status_id int(11) default 0 comment '审核状态id';
alter table gb_do_turn_good add is_over int(11) DEFAULT '0' COMMENT '是否结束';
alter table gb_do_turn_good_status add name varchar(255) default '' comment  '附件描述';
alter table gb_do_turn_good_status add process_type_status_id int(11) default 0 comment '审核状态id';
alter table gb_do_turn_good_status add status tinyint(2) default 0 comment '状态：0未审核，1审核通过，2审核不通过';
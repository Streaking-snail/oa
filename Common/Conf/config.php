<?php
return array(
		'URL_PATHINFO_DEPR'=>'/',
		'DB_TYPE'=>'mysql',// 数据库类型
		'DB_HOST'=>'127.0.0.1',// 服务器地址
		'DB_NAME'=>'oa',// 数据库名
		'DB_USER'=>'root',// 用户名
		'DB_PWD'=>'',// 密码
		'DB_PORT'=>3306,// 端口
		'DB_PREFIX'=>'gb_',// 数据库表前缀
		'DEFAULT_CHARSET'=> 'utf-8',
		
                
		'LAYOUT_ON'=>true,                      //开起模板
		'LAYOUT_NAME'=>'layouts/index',          //模板
		'TMPL_LAYOUT_ITEM' => '{__CONTENT__}',  //模板里替换内容
		
		'TMPL_ACTION_ERROR'     =>  THINK_PATH.'Tpl/dispatch_jump.tpl', // 默认错误跳转对应的模板文件
		'TMPL_ACTION_SUCCESS'   =>  THINK_PATH.'Tpl/dispatch_jump.tpl', // 默认成功跳转对应的模板文件
		'TMPL_EXCEPTION_FILE'   =>  THINK_PATH.'Tpl/think_exception.tpl',// 异常页面的模板文件
		
		'MODULE_DENY_LIST'      =>  array('Common', 'Runtime', 'data', 'ThinkPHP', 'Lib'),    //设置禁止访问的模块
		
		'TMPL_ACTION_ERROR'     => 'Public:error', // 默认错误跳转对应的模板文件
		'TMPL_ACTION_SUCCESS'   => 'Public:success', // 默认成功跳转对应的模板文件
		'VAR_PAGE'  =>"p",    //分页参数
		'PAGE_LISTROWS' => 10,
    
		//邮件配置
		'SP_MAIL_COMPANY' => '广博项目管理系统',
		'SP_MAIL_ADDRESS' => 'wenjiwang268@163.com',      //发件方邮箱
		'SP_MAIL_SMTP' => 'smtp.163.com',         
		'SP_MAIL_PORT' => 25,                            //smtp服务器地址
		'SP_MAIL_LOGINNAME' => 'wenjiwang268@163.com',   //邮箱用户名
		'SP_MAIL_PASSWORD' => 'bnpyrzdzchcctwyh',  //邮箱密码
		'WEBURL'=>'http://www.wenji99.com:8888/',
        'WEBROOT'=>"/home/projects/oa"
);
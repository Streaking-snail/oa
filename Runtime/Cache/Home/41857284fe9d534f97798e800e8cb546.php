<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<META content="text/html; charset=utf-8" http-equiv=Content-Type>
		<title>广博项目管理系统</title>
		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<link rel="stylesheet" href="/Public/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/Public/css/font-awesome.min.css" />
		<link rel="stylesheet" href="/Public/css/ace-fonts.css" />
		<link rel="stylesheet" href="/Public/css/ace.min.css" id="main-ace-style" />
		<!--[if lte IE 9]>
			<link rel="stylesheet" href="/Public/css/ace-part2.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="/Public/css/ace-skins.min.css" />
		<link rel="stylesheet" href="/Public/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="/Public/css/jquery.autocomplete.css" />
		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="/Public/css/ace-ie.min.css" />
		<![endif]-->
		<script src="/Public/js/ace-extra.min.js"></script>
		<!--[if lte IE 8]>
			<script src="/Public/js/html5shiv.min.js"></script>
			<script src="/Public/js/respond.min.js"></script>
		<![endif]-->
		<link rel="stylesheet" href="/Public/css/style.css">
	</head>

	<body class="<?php echo ($admin_class); ?>">
		
		<div id="navbar" class="navbar navbar-default">
	<script type="text/javascript">
		try{ace.settings.check('navbar' , 'fixed')}catch(e){}
	</script>
	<div class="navbar-container" id="navbar-container">
		<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler">
			<span class="sr-only">导航栏</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		
		<div class="navbar-header pull-left">
			<a href="<?php echo U('Home/Index/index');?>" class="navbar-brand">
				<small>
					<i class="fa fa-leaf"></i>
					广博项目管理系统
				</small>
			</a>
		</div>
		
		<div class="navbar-buttons navbar-header pull-right" role="navigation">
						<ul class="nav ace-nav">
						<!--
							<li class="grey">
								<a data-toggle="dropdown" class="dropdown-toggle" href="#" title="">
									<i class="ace-icon fa fa-tasks"></i>
									<span class="badge badge-grey">4</span>
								</a>
	
								<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
									
									<li class="dropdown-header">
										<i class="ace-icon fa fa-check"></i>
										4个任务
									</li>
	
									<li>
										<a href="#">
											<div class="clearfix">
												<span class="pull-left">Software Update</span>
												<span class="pull-right">65%</span>
											</div>
	
											<div class="progress progress-mini">
												<div style="width:65%" class="progress-bar"></div>
											</div>
										</a>
									</li>
	
									<li>
										<a href="#">
											<div class="clearfix">
												<span class="pull-left">Hardware Upgrade</span>
												<span class="pull-right">35%</span>
											</div>
	
											<div class="progress progress-mini">
												<div style="width:35%" class="progress-bar progress-bar-danger"></div>
											</div>
										</a>
									</li>
	
									<li>
										<a href="#">
											<div class="clearfix">
												<span class="pull-left">Unit Testing</span>
												<span class="pull-right">15%</span>
											</div>
	
											<div class="progress progress-mini">
												<div style="width:15%" class="progress-bar progress-bar-warning"></div>
											</div>
										</a>
									</li>
	
									<li>
										<a href="#">
											<div class="clearfix">
												<span class="pull-left">Bug Fixes</span>
												<span class="pull-right">90%</span>
											</div>
	
											<div class="progress progress-mini progress-striped active">
												<div style="width:90%" class="progress-bar progress-bar-success"></div>
											</div>
										</a>
									</li>
	
									<li class="dropdown-footer">
										<a href="#">
											See tasks with details
											<i class="ace-icon fa fa-arrow-right"></i>
										</a>
									</li>
								</ul>
							</li>
							-->
							<!--
							<li class="purple">
								<a data-toggle="dropdown" class="dropdown-toggle" href="#">
									<i class="ace-icon fa fa-bell icon-animated-bell"></i>
									<span class="badge badge-important">8</span>
								</a>
	
								<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
									<li class="dropdown-header">
										<i class="ace-icon fa fa-exclamation-triangle"></i>
										8 Notifications
									</li>
	
									<li>
										<a href="#">
											<div class="clearfix">
												<span class="pull-left">
													<i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
													New Comments
												</span>
												<span class="pull-right badge badge-info">+12</span>
											</div>
										</a>
									</li>
	
									<li>
										<a href="#">
											<i class="btn btn-xs btn-primary fa fa-user"></i>
											Bob just signed up as an editor ...
										</a>
									</li>
	
									<li>
										<a href="#">
											<div class="clearfix">
												<span class="pull-left">
													<i class="btn btn-xs no-hover btn-success fa fa-shopping-cart"></i>
													New Orders
												</span>
												<span class="pull-right badge badge-success">+8</span>
											</div>
										</a>
									</li>
	
									<li>
										<a href="#">
											<div class="clearfix">
												<span class="pull-left">
													<i class="btn btn-xs no-hover btn-info fa fa-twitter"></i>
													Followers
												</span>
												<span class="pull-right badge badge-info">+11</span>
											</div>
										</a>
									</li>
	
									<li class="dropdown-footer">
										<a href="#">
											See all notifications
											<i class="ace-icon fa fa-arrow-right"></i>
										</a>
									</li>
								</ul>
							</li>
	  						-->
							<li class="green">
								<a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);">
									<i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
									<span class="badge badge-success"><?php echo count($last_msgs); ?></span>
								</a>
	
								<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
									<li class="dropdown-header">
										<i class="ace-icon fa fa-envelope-o"></i>
										<?php echo ($user_info["deport_name"]); ?>，信息<?php echo count($last_msgs); ?>
									</li>
	
									<li class="dropdown-content">
										<ul class="dropdown-menu dropdown-navbar">
											<?php if( count($last_msgs)>0 ){ ?>
												<?php foreach( $last_msgs as $v ){ ?>
													<li>
														<a href="javascript:void(0);">
															<?php if( !empty($v['head_pic']) ){ ?>
																<img src="/Public<?php echo ($v["head_pic"]); ?>" class="msg-photo" alt="<?php echo ($v["name"]); ?>" />
															<?php }else{ ?>
																<img src="/Public/avatars/avatar2.png" class="msg-photo" alt="<?php echo ($v["name"]); ?>" />
															<?php } ?>
															<span class="msg-body">
																<span class="msg-title">
																	<span class="blue"><?php echo ($v["username"]); ?>:</span>
																	<?php echo ($v["msg"]); ?>
																</span>
			
																<span class="msg-time">
																	<i class="ace-icon fa fa-clock-o"></i>
																	<span>
																		<?php echo D('ProductPic')->get_show_time($v['create_time']); ?>
																	</span>
																</span>
															</span>
														</a>
													</li>
												<?php } ?>
											<?php }else{ ?>
												<li style="text-align:center;">暂无相关记录</li>
											<?php } ?>
										</ul>
									</li>
								</ul>
							</li>
							
							<li class="light-blue">
								<a data-toggle="dropdown" href="<?php echo U('Home/AdminUser/show', array('id'=>$admin_user_id));?>" class="dropdown-toggle">
									<?php if( !empty($user_info['head_pic']) ){ ?>
										<img class="nav-user-photo" src="/Public<?php echo ($user_info["head_pic"]); ?>" alt="<?php echo ($user_info["name"]); ?>" />
									<?php }else{ ?>
										<img class="nav-user-photo" src="/Public/avatars/avatar2.png" alt="<?php echo ($user_info["name"]); ?>" />
									<?php } ?>
									<span class="user-info">
										<small>您好,</small>
										<?php if( $user_info ){ ?>
											<?php if( !empty($user_info['name']) ){ ?>
												<?php echo ($user_info["name"]); ?>
											<?php }else{ ?>
												<?php echo ($user_info["username"]); ?>
											<?php } ?>
										<?php } ?>
									</span>
									<i class="ace-icon fa fa-caret-down"></i>
								</a>
								<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
									<li>
										<a href="<?php echo U('AdminUser/edit_password', array('id'=>$user_info['id']));?>">
											<i class="ace-icon fa fa-cog"></i>
											修改密码
										</a>
									</li>
									<li>
										<a href="<?php echo U('AdminUser/edit', array('id'=>$user_info['id']));?>">
											<i class="ace-icon fa fa-user"></i>
											修改资料 
										</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="<?php echo U('Login/logout');?>">
											<i class="ace-icon fa fa-power-off"></i>
											退出
										</a>
									</li>
								</ul>
							</li>
						</ul>
		
		</div>
	
	</div>
</div>
		
		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar responsive">
				
				<script type="text/javascript">
	try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
</script>

<ul class="nav nav-list">
		<?php if(is_array($menus)): foreach($menus as $k=>$a): ?><li class="<?php echo ($a["first_code"]); ?>">
						<a href="<?php if($a['url']=='javascript:void(0);'){echo $a['url'];}else{echo U($a['url']);} ?>" <?php if( count($a['sub_menus'])>0 ){ echo 'class="dropdown-toggle"'; } ?> >
							<i class="menu-icon fa fa-<?php echo ($a["class_code"]); ?>"></i>
							<span class="menu-text"><?php echo ($a["name"]); ?></span>
							<?php if( count($a['sub_menus'])>0 ){ echo '<b class="arrow fa fa-angle-down"></b>'; } ?>
						</a>
						<b class="arrow"></b>
						<?php if( ($a['sub_menus'])>0 ){ ?>
						     <ul class="<?php echo ($a["second_code"]); ?>">
								<?php if(is_array($a["sub_menus"])): foreach($a["sub_menus"] as $key=>$b): ?><li class="<?php echo ($b["first_code"]); ?>">
										<a href="<?php if($b['url']=='javascript:void(0);'){echo $b['url'];}else{echo U($b['url']);} ?>" <?php if( count($b['sub_menus'])>0 ){ echo 'class="dropdown-toggle"'; } ?> >
											<i class="menu-icon fa fa-caret-right"></i>
											<span class="menu-text"><?php echo ($b["name"]); ?></span>
											<?php if( count($b['sub_menus'])>0 ){ echo '<b class="arrow fa fa-angle-down"></b>'; } ?>
										</a>
										<b class="arrow"></b>
										<?php if( count($b['sub_menus'])>0 ){ ?>
											<ul class="<?php echo ($b["second_code"]); ?>">
												<?php if(is_array($b["sub_menus"])): foreach($b["sub_menus"] as $key=>$c): ?><li class="<?php echo ($c["first_code"]); ?>">
														<a href="<?php if($c['url']=='javascript:void(0);'){echo $c['url'];}else{echo U($c['url']);} ?>" <?php if( count($c['sub_menus'])>0 ){ echo 'class="dropdown-toggle"'; } ?> >
															<i class="menu-icon fa fa-caret-right"></i>
															<?php echo ($c["name"]); ?>
															<?php if( count($c['sub_menus'])>0 ){ echo '<b class="arrow fa fa-angle-down"></b>'; } ?>
														</a>
														<b class="arrow"></b>
														<?php if( isset($c['sub_menus']) && count($c['sub_menus'])>0 ){ ?>
															<ul class="<?php echo ($c["second_code"]); ?>">
																<?php foreach($c['sub_menus'] as $d){ ?>
																	<li class="<?php echo ($d["first_code"]); ?>">
																		<a href="<?php if($d['url']=='javascript:void(0);'){echo $d['url'];}else{echo U($d['url']);} ?>" >
																			<i class="menu-icon fa fa-caret-right"></i>
																			<?php echo ($d["name"]); ?>
																		</a>
																		<b class="arrow"></b>
																	</li>
																<?php } ?>
															</ul>
														<?php } ?>
													</li><?php endforeach; endif; ?>
											</ul>
										<?php } ?>
								        </li><?php endforeach; endif; ?>
							</ul>
					  <?php } ?>
				 </li><?php endforeach; endif; ?>	
</ul>

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>

			<div class="main-content">
				<div class="breadcrumbs" id="breadcrumbs">
		<script type="text/javascript">
			try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
		</script>
		<ul class="breadcrumb">
			<li>
				<i class="ace-icon fa fa-home home-icon"></i>
				<a href="<?php echo U('Index/index');?>">首页</a>
			</li>
			<?php foreach($locations as $value){ $str = "<li "; if( $value['is_checked'] ){ $str .= " class='active' "; } $str .= ">"; if( !empty($value['url']) ){ $str .= "<a href='".$value['url']."'>".$value['name']."</a>"; }else{ $str .= $value['name']; } $str .= "</li>"; echo $str; } ?>
		</ul>
		<div class="nav-search" id="nav-search">
			<form class="form-search" action="<?php echo U('Product/index');?>" method="post">
				<span class="input-icon">
					<input type="text" name="key" placeholder="关键字" class="nav-search-input" id="nav-search-input" autocomplete="off" />
					<i class="ace-icon fa fa-search nav-search-icon"></i>
				</span>
			</form>
		</div>
</div>
				<div class="page-content">
					<div class="ace-settings-container" id="ace-settings-container">
		<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn" title="当前页设置">
			<i class="ace-icon fa fa-cog bigger-150"></i>
		</div>
		<div class="ace-settings-box clearfix" id="ace-settings-box">
				<div class="pull-left width-50">
						<div class="ace-settings-item">
							<div class="pull-left">
								<select id="skin-colorpicker" class="hide">
									<option data-skin="no-skin" value="#438EB9">#438EB9</option>
									<option data-skin="skin-1" value="#222A2D">#222A2D</option>
									<option data-skin="skin-2" value="#C6487E">#C6487E</option>
									<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
								</select>
							</div>
							<span>&nbsp;菜单颜色</span>
						</div>

						<div class="ace-settings-item">
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar">
							<label class="lbl" for="ace-settings-navbar">头部固定</label>
						</div>
						<div class="ace-settings-item">
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar">
							<label class="lbl" for="ace-settings-sidebar">菜单栏固定</label>
						</div>
						<div class="ace-settings-item">
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs">
							<label class="lbl" for="ace-settings-breadcrumbs">当前位置固定</label>
						</div>
						<!-- 
						<div class="ace-settings-item">
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl">
							<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
						</div>
						 -->
						<div class="ace-settings-item">
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container">
							<label class="lbl" for="ace-settings-add-container">
								显示窄屏
							</label>
						</div>
				</div>
				<div class="pull-left width-50">
						<!-- #section:basics/sidebar.options -->
						<div class="ace-settings-item">
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover">
							<label class="lbl" for="ace-settings-hover">菜单栏</label>
						</div>

						<div class="ace-settings-item">
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact">
							<label class="lbl" for="ace-settings-compact">菜单变窄</label>
						</div>

						<div class="ace-settings-item">
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight">
							<label class="lbl" for="ace-settings-highlight">菜单选中</label>
						</div>
				</div>
	  </div>
</div>
					<style>
.fl{float:left;width:60px;line-height:20px;}
.bgt{z-index:999; filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5; display:none;background:#000;width:100%;height:100%;position:absolute;left:0;top:0;}
.info_form{z-index:9999;position:absolute;top:10%;left:30%;background:#fff;display:none;padding:0px 0px 20px;
 -moz-border-radius: 5px;      /* Gecko browsers */
    -webkit-border-radius: 5px;   /* Webkit browsers */
    border-radius:5px;            /* W3C syntax */
}
.title{color:#000;width:100%;padding:5px 10px;border-bottom:1px solid #c2c2c2;float:left;margin-bottom: 20px;font-size:14px;}
.title .tit{float:left;}
.title .closed{float:right;}
.info_form .mtl20{padding-left:20px;}
.info_form .mtl120{    padding: 10px 60px 0px;font-size: 14px;}
.info_form .btn_i{background:green;border:none;padding:4px 8px;color:#fff;margin-left:10px;}
.info_form .btn_c{background:#c2c2c2;border:none;padding:4px 8px;color:#000;margin-left:10px;}
.ad_in{border:none;background:#33CCFF;color:#fff;}

.checked_list{width:100%;font-size:12px;font-weight:normal}
.checked_list th{text-align:center;line-height:25px;}
.checked_list td{text-align:center;line-height:25px;}
.table-hover>tbody>tr:hover>td, .table-hover>tbody>tr:hover>th{background:#7cc5e5}
.table-hover .current td{background:#7cc5e5}
</style>
<div id="back" class="bgt"></div>
<div class="info_form" id="add_checked">
	<div class="title">                                                        
		<span class="tit">提交审核</span>
	    <span class="closed">[关闭]</span>
	</div>
	<!--这里面U方法必须用双引号-->
	<?php $controller = CONTROLLER_NAME; ?>
	<form action='<?php echo U("$controller/check");?>' id="check_form" enctype="multipart/form-data" method="post" >
		 <input type="hidden" name="type" id="type" value="checked" />
		 <p class="mtl20">
		      <input type="hidden" name="check_id" id="check_id" value="0" />
		      <textarea name="content" id="content" placeholder="审核内容" style="width:100%;height:100px;"></textarea><br />
			  <input type="text" name="attach_name" placeholder="附件说明" value="" />
		      <span style="position:relative;">
		             <input type="button" value="附件" class="ad-btn" id="add_attach"/>
		   			 <input type="file" class="fp" name="file" id="file" value=""/>&nbsp;
		      </span>
		 </p>
		 <p class="mtl120">
		       <input type="button" id="checked" class="btn_i" value="审核通过"/>
		       <input type="button" id="unchecked" class="btn_c" value="审核不通过" />
		 </p>
	</form>
</div>
<div class="info_form" id="checked_list" style="left:10%;"></div>
<div class="page-content-area">
		<div class="page-header">
	<h1>
		<?php echo ($loc_name_1); ?>
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			<?php echo ($loc_name_2); ?>
		</small>
	</h1>
</div>
		<div class="row">
				<div class="col-xs-12">
							<div id="sample-table-2_wrapper" class="dataTables_wrapper form-inline no-footer" style="overflow-x:auto;">
												<input type="hidden" id="add_url" value="<?php echo U('Business/add_info');?>" />
												<input type="hidden" id="edit_url" value="<?php echo U('Business/edit');?>" />
												<input type="hidden" id="show_url" value="<?php echo U('Business/detail');?>" />
												<div class="row">
													<form action="" id="search_info" method="post">
	<div class="col-xs-6" style="width:30%">
		<div class="dataTables_length" id="sample-table-2_length">
			<label>每页显示
				<select name="num" id="num" aria-controls="sample-table-2" class="form-control input-sm">
					<option value="10" <?php if($search_info['num']==10){echo "selected='selected'";} ?> >10</option>
					<option value="25" <?php if($search_info['num']==25){echo "selected='selected'";} ?> >25</option>
					<option value="50" <?php if($search_info['num']==50){echo "selected='selected'";} ?> >50</option>
					<option value="100" <?php if($search_info['num']==100){echo "selected='selected'";} ?> >100</option>
				</select>条,共<?php echo ($total_count); ?>条记录
			</label>
		</div>
	</div>
	<div class="col-xs-6" style="width:70%">
		<div id="sample-table-2_filter" class="dataTables_filter">
			<label>
				关键字：<input type="text" name="key" placeholder="关键字" id="search_txt" class="form-control input-sm" aria-controls="sample-table-2" value="<?php echo $search_info['key']; ?>" />
				&nbsp;&nbsp;
				<?php if( is_array($s_deports) && is_array($s_deports)>0 ){ ?>
					部门:<select name="deport_id" id="deport_id">
						<?php foreach($s_deports as $value){ if( $value['id']==$search_info['deport_id'] ){ echo "<option value='".$value['id']."' selected='selected'>".$value['name']."</option>"; }else{ echo "<option value='".$value['id']."'>".$value['name']."</option>"; } } ?>
					</select>
					&nbsp;&nbsp;
				<?php } ?>
				<?php if( is_array($s_status) && count($s_status)>0 ){ ?>
					状态:<select name="status" id="status">
						<?php foreach($s_status as $value){ if( intval($value['val'])==intval($search_info['status']) ){ echo "<option value='".$value['val']."' selected='selected'>".$value['name']."</option>"; }else{ echo "<option value='".$value['val']."'>".$value['name']."</option>"; } } ?>
					</select>
					&nbsp;&nbsp;
				<?php } ?>
				<?php if( is_array($s_categories) && count($s_categories)>0 ){ ?>
					大类：<select name="category_id" id="category_id" vel="<?php echo U('ProductBase/get_sub_categories');?>">
						<?php foreach($s_categories as $value){ if( $value['id']==$search_info['category_id'] ){ echo "<option value='".$value['id']."' selected='selected'>".$value['name']."</option>"; }else{ echo "<option value='".$value['id']."'>".$value['name']."</option>"; } } ?>
					</select>
					&nbsp;&nbsp;
				<?php } ?>
				<?php if( is_array($s_sub_categories) && count($s_sub_categories)>0 ){ ?>
					系列：<select name="sub_category_id" id="sub_category_id" vel="<?php echo U('ProductBase/get_classifications');?>">
						<?php foreach($s_sub_categories as $value){ if( $value['id']==$search_info['sub_category_id'] ){ echo "<option value='".$value['id']."' selected='selected'>".$value['name']."</option>"; }else{ echo "<option value='".$value['id']."'>".$value['name']."</option>"; } } ?>
					</select>
					&nbsp;&nbsp;
				<?php } ?>
				<?php if( is_array($s_classifications) && count($s_classifications)>0 ){ ?>
					类别：<select name="classification_id" id="classification_id">
						<?php foreach($s_classifications as $value){ if( $value['id']==$search_info['classification_id'] ){ echo "<option value='".$value['id']."' selected='selected'>".$value['name']."</option>"; }else{ echo "<option value='".$value['id']."'>".$value['name']."</option>"; } } ?>
					</select>
					&nbsp;&nbsp;
				<?php } ?>
				<?php if( is_array($s_shops) && count($s_shops)>0 ){ ?>
					店铺：<select name="s_shop_id" id="s_shop_id">
						<?php foreach($s_shops as $value){ if( $value['id']==$search_info['s_shop_id'] ){ echo "<option value='".$value['id']."' selected='selected'>".$value['name']."</option>"; }else{ echo "<option value='".$value['id']."'>".$value['name']."</option>"; } } ?>
					</select>
					&nbsp;&nbsp;
				<?php } ?>
                                
				<input type="submit" value="搜索" />&nbsp;
				<?php if( $is_add ){ ?>
					<input type="button" id="" value="" data-url="<?php echo U('Temporary/add_info');?>" />
				<?php } ?>
				<?php if($is_export){ ?>
					<input type="button" id="search_btn" value="导出数据" data-url="<?php echo U('ProductBase/download_csv');?>" />
				<?php } ?>
                                
                                <?php if($is_more_search || $application){ ?>
                                <input type="button" id="more_search" value="更多" />
                                <?php } ?>
			</label>
		</div>
	</div>
</form>
												</div>
												<div class="col"  id="col">
													<form action="" id="condition_info" method="post" />
	<input type='text' style="display:none;" id="show"  name="show"  value="<?php echo ($search_info['show']); ?>"/>
    <?php if($application){ ?>
	        部门：<input type='text' name='deport'  value="<?php echo ($search_info['deport']); ?>" />
	        人员：<input type='text' name='admin_user' value="<?php echo ($search_info['admin_user']); ?>" />
	        日期：<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" name="time1" value="<?php if( !empty($search_info['time1']) ){ echo $search_info['time1'];} ?>" />-
                 <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" name="time2"  value="<?php if( !empty($search_info['time2']) ){ echo $search_info['time2'];} ?>" />
    <?php } ?>
    <?php if($doleaves_search){ ?>
        请假日期：<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" name="time3" value="<?php if( !empty($search_info['time3']) ){ echo $search_info['time3'];} ?>" />-
                 <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" name="time4"  value="<?php if( !empty($search_info['time4']) ){ echo $search_info['time4'];} ?>" />
                 <input style="width: 42px;height: 25px;" id="daochu" type="button" data-url="<?php echo U('DoLeave/expUser');?>" value="导出" />
    <?php } ?>
    <?php if($leaves_search){ ?>
        请假日期：<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" name="time3" value="<?php if( !empty($search_info['time3']) ){ echo $search_info['time3'];} ?>" />-
                 <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" name="time4" value="<?php if( !empty($search_info['time4']) ){ echo $search_info['time4'];} ?>" />
                 <input style="width: 42px;height: 25px;" id="daochu" type="button" data-url="<?php echo U('Leave/expUser');?>"  value="导出" />
    <?php } ?>
        <?php if($dopromotion_search || $business_search){if($dopromotion_search)echo "活动日期：";else if($business_search)echo "出差日期："; ?>
            <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" name="time3" value="<?php if( !empty($search_info['time3']) ){ echo $search_info['time3'];} ?>" />-
            <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" name="time4" value="<?php if( !empty($search_info['time4']) ){ echo $search_info['time4'];} ?>" />
        <?php } ?>
<!--            <?php if($business_search){ ?>
        出差日期：<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" name="time3" value="<?php if( !empty($search_info['time3']) ){ echo $search_info['time3'];} ?>" />-
                 <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" name="time4" value="<?php if( !empty($search_info['time4']) ){ echo $search_info['time4'];} ?>" />
    <?php } ?>-->
    <input id="search" type="submit" value="搜索" />
</form>
    
												</div>
												<table id="sample-table-2" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="sample-table-2_info">
													<thead>
														   <tr>
																<th width="50">序号</th>
																<th width="100">单据号</th>
																<th width="80">状态</th>
                                                                                                                                <th width="100">状态描述</th>
																<th width="100">制单部门</th>
																<th width="80">制单人</th>
																<th width="100">制单日期</th>
																<th width="100">出差地点</th>
																<th width="100">交通方式</th>
																<th width="100">开始日期</th>
																<th width="100">结束日期</th>
																<th width="90">最新审批人</th>
																<th width="100">操作</th>
															</tr>
													</thead>
	
													<tbody>
														<?php foreach($businesses as $k=>$value){ $s = D('Business')->get_local_status($value['id']); $t = D('Business')->get_status($value['id']); ?>
															<tr data-id="<?php echo ($value["id"]); ?>" class="<?php if($k%2==0){echo 'odd';}else{echo 'even';} ?>" name="item">
																<td><?php echo ($k+1); ?></td>
																<td><?php echo ($value["no"]); ?></td>
																<td>
																	<a href="javascript:void(0);" name="show_status" data-url="<?php echo U('Business/get_checked_list', array('id'=>$value['id']));?>">
																		<?php if( $value['is_over']!=1 ){ if( $s['status']==0 ){ echo "<span>待审核</span>"; }else{ echo "<span style='color:red;'>".$s['name']."</span>"; } }else{ echo "<span style='color:green;'>审核通过</span>"; } ?>
																	</a>
																</td>
                                                                                                                                <td><?php if( $value['is_over']==1 ){ echo '结束'; }else{ if( $s ){ if( $s['status']==1 ){ echo $s['username']."<span style='color:green;'>审核通过</span>，等待 ".$t['username']." 审核"; }else{ echo $s['username']." <span style='color:red;'>审核不通过</span>"; } }else{ echo "未审核"; } } ?></td>
																<td><?php echo D('AdminUser')->get_name_deport($value['admin_user_id']); ?></td>
																<td><?php echo D('AdminUser')->get_username($value['admin_user_id']); ?></td>
																<td><?php echo date("Y-m-d", $value['input_time']); ?></td>
																<td><?php echo ($value["address"]); ?></td>
																<td><?php echo ($value["transportation"]); ?></php></td>
																<td><?php echo date("Y-m-d", $value['start_time']); ?></td>
																<td><?php echo date("Y-m-d", $value['end_time']); ?></td>
																<td><?php echo $Business->get_last_checked_name($value['id']); ?></td>
																<td>
																	<a name="show_info" href="<?php echo U('Business/detail', array('id'=>$value['id']));?>" target="_blank" title="详情">
																		详情
																	</a>&nbsp;|
																	<?php if( $value['is_over']==0 ){ ?>
																		<a href="<?php echo U('Business/edit', array('id'=>$value['id']));?>" title="修改">
																			修改
																		</a>&nbsp;|
																		<?php if( D('Business')->is_checked_power($user_info['id'], $value['id']) ){ ?>
																			<a href="javascript:void(0);" name="add_checked" data-id="<?php echo ($value['id']); ?>" title="审核">
																				审核
																			</a>&nbsp;|
																		<?php } ?>
																	<?php } ?>
																	<?php if( $value['admin_user_id']==$user_info['id'] ){ ?>
																		<a href="<?php echo U('Business/del', array('id'=>$value['id']));?>" title="删除">
																			删除
																		</a>
																	<?php } ?>
																</td>
															</tr>
														<?php } if( count($businesses)==0 ){ echo "<tr><td align='center' colspan='12'>暂无相关记录</td></tr>"; } ?>
													</tbody>
												</table>
												<div class="row">
		<div class="dataTables_paginate paging_simple_numbers" id="sample-table-2_paginate">
			<?php echo ($show_page); ?>
		</div>
		<?php $controller = CONTROLLER_NAME; ?>
		<div class="rg">
			<input type="button" value="查看" name="show_info" data-url='<?php echo U("$controller/detail");?>'/>&nbsp;
			<input type="button" value="修改" name="edit_info" data-url='<?php echo U("$controller/edit");?>'/>&nbsp;
			<input type="button" value="添加" name="add_info" data-url='<?php echo U("$controller/add_info");?>' />
		</div>
</div>
										</div><!-- sample-table-2_wrapper -->
				 </div><!-- col-xs-12 -->
		</div>
		

</div>
				</div>
			 </div>

			 <div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder"></span>
							 &copy; 2016-2017
						</span>

						&nbsp; &nbsp;
						<!--
						<span class="action-buttons">
							<a href="#">
								<i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-rss-square orange bigger-150"></i>
							</a>
						</span>
						-->
					</div>
				</div>
</div>

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
	<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
</a>

		</div>

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='/Public/js/jquery.min.js'>"+"<"+"/script>");
		</script>
		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='/Public/js/jquery1x.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='/Public/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="/Public/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="/Public/assets/js/excanvas.min.js"></script>
		<![endif]-->
		<script src="/Public/js/jquery-ui.custom.min.js"></script>
		<script src="/Public/js/jquery.ui.touch-punch.min.js"></script>
		<script src="/Public/js/jquery.easypiechart.min.js"></script>
		<script src="/Public/js/jquery.sparkline.min.js"></script>
		<script src="/Public/js/flot/jquery.flot.min.js"></script>
		<script src="/Public/js/flot/jquery.flot.pie.min.js"></script>
		<script src="/Public/js/flot/jquery.flot.resize.min.js"></script>
		<script src="/Public/js/jquery.form.js"></script>
                <script  src="/Public/js/My97DatePicker/WdatePicker.js"></script>
		<script src="/Public/js/ace-elements.min.js"></script>
		<script src="/Public/js/ace.min.js"></script>
		
		
				
		<?php if( $is_kindeditor ){ ?>
			<script  charset="utf-8" src="/Public/kindeditor4.1/kindeditor-min.js"></script>
		<?php } ?>
                
        <script src="/Public/js/jquery.autocomplete.js"></script>        
		<script src="/Public/js/controller/common.js"></script>
		<script src="/Public/js/controller/<?php echo CONTROLLER_NAME; ?>.js"></script>
        
        <script type="text/javascript">
			jQuery(function($) {
				$('.easy-pie-chart.percentage').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
					var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
					var size = parseInt($(this).data('size')) || 50;
					$(this).easyPieChart({
						barColor: barColor,
						trackColor: trackColor,
						scaleColor: false,
						lineCap: 'butt',
						lineWidth: parseInt(size/10),
						animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
						size: size
					});
				})
			
				$('.sparkline').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
					$(this).sparkline('html',
									 {
										tagValuesAttribute:'data-values',
										type: 'bar',
										barColor: barColor ,
										chartRangeMin:$(this).data('min') || 0
									 });
				});
			
			
			  //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
			  //but sometimes it brings up errors with normal resize event handlers
			  
			
			
			
			
			
			
				var d1 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d1.push([i, Math.sin(i)]);
				}
			
				var d2 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d2.push([i, Math.cos(i)]);
				}
			
				var d3 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.2) {
					d3.push([i, Math.tan(i)]);
				}
				
			
				
			
			
				$('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('.tab-content')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			
			
				$('.dialogs,.comments').ace_scroll({
					size: 300
			    });
				
				var agent = navigator.userAgent.toLowerCase();
				if("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))
				  $('#tasks').on('touchstart', function(e){
					var li = $(e.target).closest('#tasks li');
					if(li.length == 0)return;
					var label = li.find('label.inline').get(0);
					if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
				});
			
				$('#tasks').sortable({
					opacity:0.8,
					revert:true,
					forceHelperSize:true,
					placeholder: 'draggable-placeholder',
					forcePlaceholderSize:true,
					tolerance:'pointer',
					stop: function( event, ui ) {
						$(ui.item).css('z-index', 'auto');
					}
					}
				);
				$('#tasks').disableSelection();
				$('#tasks input:checkbox').removeAttr('checked').on('click', function(){
					if(this.checked) $(this).closest('li').addClass('selected');
					else $(this).closest('li').removeClass('selected');
				});
			
				$('#task-tab .dropdown-hover').on('mouseenter', function(e) {
					var offset = $(this).offset();
			
					var $w = $(window)
					if (offset.top > $w.scrollTop() + $w.innerHeight() - 100) 
						$(this).addClass('dropup');
					else $(this).removeClass('dropup');
				});
				
				$("#ace-settings-navbar,#ace-settings-sidebar,#ace-settings-breadcrumbs,"+
				  "#ace-settings-add-container,#ace-settings-hover,#ace-settings-compact"+
				  "#ace-settings-highlight,a.colorpick-btn").click(function(){
					  var t, cl, code;
					  if( $(this).attr("checked") ){ t='d'; }else{ t='a'; }
					  if( typeof($(this).attr('data-color'))!='undefined' ){
						  cl = $(this).attr('data-color');
						  code = cl;
					  }else{
						  cl = '';
						  code = $(this).attr('id');
					  }
					  $.post("<?php echo U('Home/Index/selected_show');?>", { code:code, t:t, cl:cl }, function(data){ });
				});
				
				<?php foreach($admin_user_shows as $v){ ?>
					$("#<?php echo ($v["code"]); ?>").tigger('click');
				<?php } ?>
				
				$("div.dropdown-colorpicker").click(function(){
					$("a.colorpick-btn").removeClass('selected');
					$("a.colorpick-btn[data-color='<?php echo ($admin_color); ?>']").addClass('selected');
				});
				
				$("span.btn-colorpicker").css("background-color", "<?php echo ($admin_color); ?>");

				
			});
		</script>

		<!-- the following scripts are used in demo only for onpage help and you don't need them -->
		<link rel="stylesheet" href="/Public/css/ace.onpage-help.css" />
		<link rel="stylesheet" href="/Public/docs/assets/js/themes/sunburst.css" />

		<script type="text/javascript"> ace.vars['base'] = '..'; </script>
		<script src="/Public/js/ace/elements.onpage-help.js"></script>
		<script src="/Public/js/ace/ace.onpage-help.js"></script>
		<script src="/Public/docs/assets/js/rainbow.js"></script>
		<script src="/Public/docs/assets/js/language/generic.js"></script>
		<script src="/Public/docs/assets/js/language/html.js"></script>
		<script src="/Public/docs/assets/js/language/css.js"></script>
		<script src="/Public/docs/assets/js/language/javascript.js"></script>
		
	</body>
</html>
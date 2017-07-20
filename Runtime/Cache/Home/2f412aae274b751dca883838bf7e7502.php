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
					<div class="page-content-area">
	<div class="row">
			<div class="col-xs-12">
					<?php if( isset($_SESSION['notice']) && !empty($_SESSION['notice']) ){ ?>
	<?php if( $_SESSION['notice_code']=='login' ){ ?>
		<style>
			.notice{padding:0px;color:red;margin:-16px 0px 5px;text-align:center;}
		</style>
		<div class="notice"><?php echo $_SESSION['notice']; ?></div>
	<?php }else if( $_SESSION['notice_code']=='login_index' ){ ?>
		<div class="alert alert-block alert-success">
			<button type="button" class="close" data-dismiss="alert">
				<i class="ace-icon fa fa-times"></i>
			</button>
			<i class="ace-icon fa fa-check green"></i>
			<?php if( empty($_SESSION['notice']) ){ ?>
			欢迎您，
			<strong class="green">
				<?php if( !empty($user_info['name']) ){echo $user_info['name'];}else{echo $user_info['username'];} ?>
			</strong>,登录广博项目管理系统
			<?php }else{ echo $_SESSION['notice']; } ?>
			
		</div>
	<?php }else if( $_SESSION['notice_code']=='success' ){ ?>
		<div class="alert alert-block alert-success">
			<button type="button" class="close" data-dismiss="alert">
				<i class="ace-icon fa fa-times"></i>
			</button>
			<p>
				<strong>
					<i class="ace-icon fa fa-check"></i>
					执行成功!
				</strong>
				<?php echo $_SESSION['notice']; ?>
			</p>
		</div>
	<?php }else if( $_SESSION['notice_code']=='warning' ){ ?>
		<div class="alert alert-warning">
			<button type="button" class="close" data-dismiss="alert">
				<i class="ace-icon fa fa-times"></i>
			</button>
			<strong>提示！</strong>
			<?php echo $_SESSION['notice']; ?>
			<br>
		</div>
	<?php }else{ ?>
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert">
				<i class="ace-icon fa fa-times"></i>
			</button>
			<strong>
				<i class="ace-icon fa fa-times"></i>
				错误！
			</strong>
			<?php echo $_SESSION['notice']; ?>
			<br />
		</div>
	<?php } unset($_SESSION['notice']); ?>
<?php } ?>

                                                                       
									<div class="col-sm-12">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-star orange"></i>
													产品数量
												</h4>
												<div class="widget-toolbar">
													<a href="javascript:void(0);" data-action="collapse">
														<i class="ace-icon fa fa-chevron-up"></i>
													</a>
													<!--<a href="<?php echo U('Product/index');?>" style="margin-right:5px;font-size:14px;">更多</a>-->
												</div>
											</div>

											<div class="widget-body" style="overflow-x:auto;">
												<div class="widget-main no-padding">
													<table class="table table-bordered table-stripe">
														<thead class="thin-border-bottom">
															<tr>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>产品总数
																</th>
                                                                <th>
																	<i class="ace-icon fa fa-caret-right blue"></i>未完成数
																</th>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>已到货数
																</th>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>大货前样
																</th>

																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>交样
																</th>

																<th class="hidden-480">
																	<i class="ace-icon fa fa-caret-right blue"></i>首页
																</th>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>详情页
																</th>
                                                                                                                                <?php $mall = M('mall')->select(); foreach($mall as $value){ ?>
                                                                                                                                            <th>
                                                                                                                                                <i class="ace-icon fa fa-caret-right blue"></i><?php echo ($value["name"]); ?>
                                                                                                                                            </th>
                                                                                                                                        <?php } ?>
                                                                                                                                
															</tr>
														</thead>

														<tbody>
															<?php $products = M('products')->select(); $product_not_over = M('product_pic')->where("is_over=0 and is_del=0")->group("product_id")->select(); $product_dh = M('product_order')->where("dh_time!=0 and is_del=0")->select(); $product_deliver = M('product_order')->where("deliver_time!=0 and is_del=0")->select(); $product_jy = M('product_pic_status')->where("ptype_status_id=1")->group("product_pic_id")->select(); $product_st = M('product_pic_status')->where("ptype_status_id=8")->group("product_pic_id")->select(); $product_xqy = M('product_pic_status')->where("ptype_status_id=6")->group("product_pic_id")->select(); $product_jd = M('shop')->alias('a')->join("left join ".C('DB_PREFIX')."count_info b on a.id=b.shop_id ") ->where("b.mall_id=1")->select(); $product_jdpop = M('shop')->alias('a')->join("left join ".C('DB_PREFIX')."count_info b on a.id=b.shop_id ") ->where("b.mall_id=2")->select(); $product_tm = M('shop')->alias('a')->join("left join ".C('DB_PREFIX')."count_info b on a.id=b.shop_id ") ->where("b.mall_id=3")->select(); $product_tb = M('shop')->alias('a')->join("left join ".C('DB_PREFIX')."count_info b on a.id=b.shop_id ") ->where("b.mall_id=4")->select(); $product_ka = M('shop')->alias('a')->join("left join ".C('DB_PREFIX')."count_info b on a.id=b.shop_id ") ->where("b.mall_id=5")->select(); $product_sc = M('shop')->alias('a')->join("left join ".C('DB_PREFIX')."count_info b on a.id=b.shop_id ") ->where("b.mall_id=6")->select(); ?>
																<tr>
                                                                                                                                    <td><a href="<?php echo U('Product/index');?>"><?php echo count($products); ?></a></td>
                                                                                                                                    <td><a href="<?php echo U('Product/index');?>"><?php echo count($product_not_over); ?></a></td>
                                                                                                                                    <td><a href="<?php echo U('ProductOrder/list_items');?>"><?php echo count($product_dh); ?></a></td>
                                                                                                                                    <td><a href="<?php echo U('ProductOrder/list_items');?>"><?php echo count($product_deliver); ?></a></td>
                                                                                                                                    <td><a href="<?php echo U('ProductPic/index', array('status'=>1));?>"><?php echo count($product_jy); ?></a></td>
                                                                                                                                    <td><a href="<?php echo U('ProductPic/index', array('status'=>7));?>"><?php echo count($product_st); ?></a></td>
                                                                                                                                    <td><a href="<?php echo U('ProductPic/index', array('status'=>5));?>"><?php echo count($product_xqy); ?></a></td>
                                                                                                                                        <?php foreach($mall as $v){ unset($g); $g = M('shop')->alias('a')->join("left join ".C('DB_PREFIX')."count_info b on a.id=b.shop_id ". "left join ".C('DB_PREFIX')."products p on b.product_id=p.id") ->where("b.mall_id=%d and p.status=1",array($v['id']))->select(); ?>
                                                                                                                                <td><a href="<?php echo U('ShopCount/index', array('mall_id'=>$v['id']));?>"><?php echo count($g); ?></td></a><?php } ?>
																</tr>
                                                                                                                                
														</tbody>
													</table>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
									</div><!-- /.col -->
									<div class="hr hr32 hr-dotted" style="width:100%;float:left;"></div>

					<div class="row">
                                                        <div class="col-sm-6">
                                                                <div class="widget-body">
                                                                        <div class="col-sm-12">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-star orange"></i>
													产品开发
												</h4>
												<div class="widget-toolbar">
													<a href="javascript:void(0);" data-action="collapse">
														<i class="ace-icon fa fa-chevron-up"></i>
													</a>
													<a href="<?php echo U('Product/index');?>" style="margin-right:5px;font-size:14px;">更多</a>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main no-padding">
													<table class="table table-bordered table-striped">
														<thead class="thin-border-bottom">
															<tr>
																<th>产品大类</th>
																<th>产品系列</th>
																<th>产品类别</th>
																<th>产品名称</th>
																<th class="hidden-480">
																	<i class="ace-icon fa fa-caret-right blue"></i>状态
																</th>
																<th>创建时间</th>
															</tr>
														</thead>

														<tbody>
															<?php foreach($aproducts as $k=>$v){ ?>
																<tr>
																	<td><?php echo $Product->get_category_name($v['category_id']); ?></td>
																	<td><?php echo $Product->get_sub_category_name($v['category_id']); ?></td>
																	<td><?php echo $Product->get_classification_name($v['classification_id']); ?></td>
																	<td><?php echo ($v["name"]); ?></td>
																	<td class="hidden-480">
																		<?php if($v['status']==1){ echo "<span class='label label-sm label-success'>审核通过</span>"; }elseif( $v['status']==2 ){ echo "<span class='label label-sm label-inverse arrowed-in'>审核不通过</span>"; }else{ echo "<span class='label label-sm label-warning'>未审核</span>"; } ?>
																	</td>
																	<td><?php echo date("Y-m-d H:i:s", $v['create_time']); ?></td>
																</tr>
															<?php } if( count($products)==0 ){ ?>
																<tr>
																	<td colspan="6" style="text-align:center;">暂无相关记录</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
										
</div><!-- /.col -->
<div class="hr hr32 hr-dotted" style="width:100%;float:left;"></div>
                                                                        <div class="col-sm-12">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-star orange"></i>
													产品进度
												</h4>
												<div class="widget-toolbar">
													<a href="javascript:void(0);" data-action="collapse">
														<i class="ace-icon fa fa-chevron-up"></i>
													</a>
													<a href="<?php echo U('ProductOrder/index');?>" style="margin-right:5px;font-size:14px;">更多</a>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main no-padding">
													<table class="table table-bordered table-striped">
														<thead class="thin-border-bottom">
															<tr>
																<th>物料代码</th>
																<th>辅代码</th>
																<th>产品名称</th>
																<th>创建时间</th>
																<th class="hidden-480">
																	<i class="ace-icon fa fa-caret-right blue"></i>状态
																</th>
																<th>所用时间</th>
															</tr>
														</thead>

														<tbody>
															<?php foreach($product_orders as $k=>$v){ ?>
																<tr>
																	<td><?php echo ($v["code"]); ?></td>
																	<td><?php echo ($v["number"]); ?></td>
																	<td><?php echo ($v["name"]); ?></td>
																	<td><?php echo date("Y-m-d H:i:s", $v['create_time']); ?></td>
																	<td class="hidden-480">
																		<?php echo D('ProductOrder')->get_show_status($v['id']); ?>
																	</td>
																	<td><?php if( $v['dh_num']<=0){echo D('ProductOrder')->get_show_time($v['update_time']);} ?></td>
																</tr>
															<?php } if( count($product_orders)==0 ){ ?>
																<tr>
																	<td colspan="6" style="text-align:center;">暂无相关记录</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
										
</div><!-- /.col -->
<div class="hr hr32 hr-dotted" style="width:100%;float:left;"></div>
                                                                        <?php foreach($ptypes as $value){ ?>
                                                                                                               
									<div class="col-sm-12">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-star orange"></i>
													<?php echo ($value["name"]); ?>
												</h4>
												<div class="widget-toolbar">
													<a href="javascript:void(0);" data-action="collapse">
														<i class="ace-icon fa fa-chevron-up"></i>
													</a>
													<a href="<?php echo U('ProductPic/index');?>" style="margin-right:5px;font-size:14px;">更多</a>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main no-padding">
													<table class="table table-bordered table-striped">
														<thead class="thin-border-bottom">
															<tr>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>物料代码
																</th>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>辅代码
																</th>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>产品名称
																</th>

																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>创建时间
																</th>

																<th class="hidden-480">
																	<i class="ace-icon fa fa-caret-right blue"></i>状态
																</th>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>所用时间
																</th>
															</tr>
														</thead>

														<tbody>
															<?php foreach($value['item_infos'] as $k=>$v){ $status_info = D('ProductPic')->get_status_info($v['id']); ?>
																<tr>
																	<td><?php echo ($v["code"]); ?></td>
																	<td><?php echo ($v["number"]); ?></td>
																	<td><a href="<?php echo U('ProductPic/index', array('id'=>$v['id']));?>"><?php echo ($v["name"]); ?></a></td>
																	<td>
																		<?php echo date("Y-m-d H:i:s", $v['create_time']); ?>
																	</td>
																	<td class="hidden-480">
																		<?php $d = D('ProductPic')->get_day($v['create_time']); ?>
																		<?php if( $status_info['is_over']==0 && $d>5 ){ ?>
																			<span class='label label-sm label-warning'>
																		<?php }else if($status_info['is_over']==1){ ?>
																			<span class='label label-sm label-success'>
																		<?php }else{ ?>
																			<span class="label label-info arrowed-right arrowed-in">
																		<?php } ?>
																			<?php echo ($status_info["name"]); ?>
																		</span>
																	</td>
																	<td>
																		 <?php if($v['is_over']==0){ $status_info['create_time'] = isset($status_info['create_time'])?$status_info['create_time']:$v['create_time']; echo D('ProductOrder')->get_show_time($status_info['create_time']); } ?>
																	</td>
																</tr>
															<?php } if( count($value['item_infos'])==0 ){ ?>
																<tr>
																	<td colspan="6" style="text-align:center;">暂无相关记录</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
									</div><!-- /.col -->
									<div class="hr hr32 hr-dotted" style="width:100%;float:left;"></div>

                                                                        <?php } ?>
                                                                        
                                                                </div>
                                                        </div><!-- /.col -->
                                                        <div class="col-sm-6" id="msg_list">
                                                                
	<div class="widget-box">
		<div class="widget-header">
			<h4 class="widget-title lighter smaller">
				<i class="ace-icon fa fa-comment blue"></i>
				<?php if($user_info['is_admin']){echo "所有消息列表"; }else{echo $user_info['deport_name']."部门消息";} ?>
			</h4>
			<span id="all_msg" data-url="<?php echo U('Index/get_all_msg');?>" style="float:right;padding:10px;">查看所有</span>
		</div>

		<div class="widget-body">
			<div class="widget-main no-padding">
				<div class="dialogs" style="height:350px;overflow-y:auto;" id="msg_list">
					<?php foreach($msgs as $value){ ?>
						<div class="itemdiv dialogdiv">
	<div class="user">
	    <?php if( !empty($value['head_pic']) ){ ?>
			<img alt="<?php echo ($value["name"]); ?>" src="/Public<?php echo ($value["head_pic"]); ?>" />
		<?php }else{ ?>
			<img alt="<?php echo ($value["name"]); ?>" src="/Public/avatars/avatar2.png" />
		<?php } ?>
	</div>
	<div class="body">
		<div class="time">
			<i class="ace-icon fa fa-clock-o"></i>
			<span class="green">
				<?php $t = time()-$value['create_time']; $d = intval($t/24/3600); $h = intval($t/3600%24); $m = intval($t%3600/60); $s = intval($t%3600%60); $str = ""; if( $d>0 ){ $str .= $d."天前"; }elseif( $h>0 ){ $str .= $h."小时前"; }elseif( $m>0 ){ $str .= $m."分前"; }elseif( $s>0 ){ $str .= $s."秒前"; }else{ $str .= "1秒前"; } echo $str; ?>
			</span>
		</div>
		<div class="name">
			<a href="javascript:void(0);"><?php echo ($value["username"]); ?></a>
		</div>
		<div class="text"><?php echo ($value["msg"]); ?></div>
		<div class="tools">
			<?php if( intval($value['admin_user_id'])==intval($_SESSION['admin_user_id']) ){ ?>
				<a href="javascript:void(0);" class="btn btn-minier btn-info" name="del_item" vel="<?php echo ($value["id"]); ?>" >
					<i class="icon-only ace-icon fa fa-share"></i>
				</a>
			<?php } ?>
		</div>
	</div>
</div>
					<?php } ?>
				</div>

				<form action="<?php echo U('Home/Index/send_msg');?>" id="msg_form" method="post">
					<div class="form-actions">
						<div class="input-group">
							<input placeholder="请输入发布内容" type="text" class="form-control" name="message" />
							<span class="input-group-btn">
								<button class="btn btn-sm btn-info no-radius" id="send_msg_btn" type="button">
									<i class="ace-icon fa fa-share"></i>
									发送
								</button>
							</span>
						</div>
					</div>
				</form>
			</div>
		</div><!-- /.widget-body -->
	</div>

                                                        </div>
					   </div><!-- /.row -->

				</div><!-- /.col -->
	  </div><!-- /.row -->
</div>
<script>
//var arr_a = [];
//	arr_a.push( { label: "social networks",  data: 38.7, color: "#68BC31" } );

//arr_a.push( { label: "search engines",  data: 24.5, color: "#2091CF" });
//arr_a.push( { label: "ad campaigns",  data: 8.2, color: "#AF4E96" } );
//arr_a.push( { label: "direct traffic",  data: 18.6, color: "#DA5430" });
//arr_a.push( { label: "other",  data: 10, color: "#FEE074" });

</script>
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
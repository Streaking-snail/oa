<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>广博项目管理系统--登录</title>

<link href="/Public/login/css/bootstrap.min.css" rel="stylesheet">
<link href="/Public/login/css/signin.css" rel="stylesheet">

</head>

<body>

<div class="signin">
	<div class="signin-head"><img src="/Public/images/logo.jpg" width="120" alt="" class="img-circle"></div>
	<form class="form-signin" action="<?php echo U('Home/Login/login');?>" method="post" role="form">
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

		<input type="text" class="form-control" placeholder="用户名" autocomplete="off" name="username" required autofocus />
		<input type="password" class="form-control" placeholder="密码" name="password" required />
		<button class="btn btn-lg btn-warning btn-block" type="submit">登录</button>
		<label class="checkbox">
			<input type="checkbox" value="remember-me">记住我
		</label>
	</form>
</div>
<!--
<div style="text-align:center;">
	<p>来源:</p>
</div>-->
</body>
</html>
<?php if (!defined('THINK_PATH')) exit();?>
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
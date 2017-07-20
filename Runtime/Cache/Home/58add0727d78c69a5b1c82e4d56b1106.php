<?php if (!defined('THINK_PATH')) exit(); foreach($sub_categories as $value){ ?>
	<?php if( $value['id']==$product['sub_category_id'] ){ ?>
		<option value='<?php echo ($value["id"]); ?>' selected="selected"><?php echo ($value["name"]); ?></option>
	<?php }else{ ?>
		<option value='<?php echo ($value["id"]); ?>'><?php echo ($value["name"]); ?></option>
	<?php } ?>
<?php } ?>
<?php if (!defined('THINK_PATH')) exit(); foreach($classifications as $value){ ?>
	<?php if( $value['id']==$product['classification_id'] ){ ?>
		<option value='<?php echo ($value["id"]); ?>' selected="selected"><?php echo ($value["name"]); ?></option>
	<?php }else{ ?>
		<option value='<?php echo ($value["id"]); ?>'><?php echo ($value["name"]); ?></option>
	<?php } ?>
<?php } ?>
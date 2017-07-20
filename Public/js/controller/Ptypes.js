$(document).ready(function(){
	
	$('#num').change(function(){
		$("#search_info").submit();
	});
	$('#add_status').click(function(){
		var obj = $(".status-list li[name='item']:last").clone().insertBefore($(this).parent());
		var i = parseInt(obj.attr('vel'));
		obj.attr('vel', i+1);
		obj.find('#ptype_status_'+i+'_name').attr('name', 'ptype_status['+(i+1)+'][name]').attr('id', 'ptype_status_'+(i+1)+'_name').val('');
		obj.find('#ptype_status_'+i+'_rank').attr('name', 'ptype_status['+(i+1)+'][rank]').attr('id', 'ptype_status_'+(i+1)+'_rank').val('0');
		obj.find('#ptype_status_'+i+'_id').attr('name', 'ptype_status['+(i+1)+'][id]').attr('id', 'ptype_status_'+(i+1)+'_id').val('0');
	});
	$(document).on('click', "a[name='del']", function(data){
		var count = $("a[name='del']").length;
		if( count==1 ){
			alter("不能删除最后一条");
		}else{
			$(this).parent().remove();
		}
		return false;
	});
});

KindEditor.ready(function(K) {
	var editor1 = K.create("#ptype_content", {
		//cssPath : '../plugins/code/prettify.css',
		uploadJson : '/public/kindeditor4.1/php/upload_json.php',
		fileManagerJson : '/public/kindeditor4.1/php/file_manager_json.php',
		width: 680,
		height: 380,
		allowFileManager : true,
		afterCreate : function() {
			var self = this;
			K.ctrl(document, 13, function() {
				self.sync();
				K('form[name=example]')[0].submit();
			});
			K.ctrl(self.edit.doc, 13, function() {
				self.sync();
				K('form[name=example]')[0].submit();
			});
		}
	});
});
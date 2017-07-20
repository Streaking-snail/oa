$(document).ready(function(){
    
	$('#btn').click(function(){
            $.post('',{id:$('#id')}, function(data){
                
            });
        });
	$('#num').change(function(){
		$("#search_info").submit();
	});
	$('#add').click(function(){
		var obj = $(".status-list li[name='item']:last").clone().insertBefore($(this).parent());
		var i = parseInt(obj.attr('vel'));
		obj.attr('vel', i+1);
		obj.find('#mall_detail_'+i+'_cid').attr('name', 'mall_detail['+(i+1)+'][cid]').attr('id', 'mall_detail_'+(i+1)+'_cid').val('0');
		obj.find('#mall_detail_'+i+'_name').attr('name', 'mall_detail['+(i+1)+'][name]').attr('id', 'mall_detail_'+(i+1)+'_name').val('');
		obj.find('#mall_detail_'+i+'_id').attr('name', 'mall_detail['+(i+1)+'][id]').attr('id', 'mall_detail_'+(i+1)+'_id').val('0');
		obj.find('#mall_detail_'+i+'_rank').attr('name', 'mall_detail['+(i+1)+'][rank]').attr('id', 'mall_detail_'+(i+1)+'_rank').val('0');
		obj.find('#mall_detail_'+i+'_is_text').attr('name', 'mall_detail['+(i+1)+'][is_text]').attr('id', 'mall_detail_'+(i+1)+'_is_text').val('0');
		obj.find('#mall_detail_'+i+'_is_attach').attr('name', 'mall_detail['+(i+1)+'][is_attach]').attr('id', 'mall_detail_'+(i+1)+'_is_attach').val('0');
	});
        
        $(document).on("change", ".column_type", function(){
            if( parseInt($(this).val())==0 ){
                $(this).parent().find('span[name="zdy"]').show();
            }else{
                $(this).parent().find('span[name="zdy"]').hide();
            }
        }).on("click", "a[name='del']", function(){
            $(this).parent().remove();
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
	prettyPrint();
});
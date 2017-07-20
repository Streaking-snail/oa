$(document).ready(function(){
	
	$('#num').change(function(){
		$("#search_info").submit();
	});
	
	$('#add_status').click(function(){
		var obj = $(".status-list li[name='item']:last").clone().insertBefore($(this).parent());
		var i = parseInt(obj.attr('vel'));
		obj.attr('vel', i+1);
		obj.find('#process_type_status_'+i+'_user_id').attr('name', 'process_type_status['+(i+1)+'][user_id]').attr('id', 'process_type_status_'+(i+1)+'_user_id').val('0');
		obj.find('#process_type_status_'+i+'_name').attr('name', 'process_type_status['+(i+1)+'][name]').attr('id', 'process_type_status_'+(i+1)+'_name').val('');
		obj.find('#process_type_status_'+i+'_rank').attr('name', 'process_type_status['+(i+1)+'][rank]').attr('id', 'process_type_status_'+(i+1)+'_rank').val('0');
		obj.find('#process_type_status_'+i+'_id').attr('name', 'process_type_status['+(i+1)+'][id]').attr('id', 'process_type_status_'+(i+1)+'_id').val('0');
		obj.find('#process_type_status_'+i+'_username').attr('name', 'process_type_status['+(i+1)+'][username]').attr('id', 'process_type_status_'+(i+1)+'_username').val('');
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
	
	$("#btn").click(function(){
		if( valid() ){
			return true;
		}else{
			return false;
		}
	});
	
	$(document).on("focus",".search_name",function(){
		var obj = $(this);
		var j = parseInt($(this).parent().attr("vel"));
		$(this).autocomplete($("#data-url").val(), {
			minChars:1,
			max: 10,
			//autoFill: false,
			matchContains: true,
			scrollHeight: 250,
			minlength: 1,
			mustMatch: true,
			width: parseInt(obj.width())+50,
			formatItem: function(item, i, max) {
				var res = eval("("+item+")");
				return $.trim(res.username)+"/"+$.trim(res.name);
		    },
		    formatResult: function(event, item) {
		    	var res = eval("("+item+")");
		    	return $.trim(res.username);
		    }
		}).result(function(event, item){
					var res = eval("("+item+")");
					$("#process_type_status_"+j+"_username").val( $.trim(res.username) );
					$("#process_type_status_"+j+"_checked_user_id']").val(res.id);
		});
	});
	
});

function valid(){
	var f=judge_form($("#process_type_name"), "empty");
	var t=true;
	$("li[name='item']").each(function(){
		var i=parseInt($(this).attr("vel"));
		if( is_empty($(this).find("#process_type_status_"+i+"_name").val()) ){
			alert("请补充完整状态名称");
			t= false;
			return false;
		}
		if( is_empty($(this).find("#process_type_status_"+i+"_username").val()) ){
			alert("请补充完整审核人");
			t= false;
			return false;
		}
	});
	return f&&t;
}
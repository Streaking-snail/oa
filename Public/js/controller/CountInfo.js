$(document).ready(function(){
    
	$("#product_name").autocomplete($("#product_name").attr("data-url"), {
		minChars: 1,
		max: 10,
		autoFill: false,
		matchContains: true,
		scrollHeight: 250,
		minlength: 1,
		mustMatch: false,
		width: $('#product_name').width(),
		formatItem: function(rows, i, max, item) {
			if( item!='undefined' ){
				var res = eval("("+item+")");
				$("#count_info_product_id").val(res.id);
				return $.trim(res.name); 
			}else{
				return '暂无记录';
			}
	    },
	    formatResult: function(data, item) {
	    	var res = eval("("+item+")");
	    	$("#count_info_product_id").val(res.id);
	    	return $.trim(res.name);
	    }
	//}).result(function(event, item, formatted){
	//	if( parseInt($('#product_name').val())!=0 ){
	//		$('#product_name').val( pname );
	//	}
	});

	$('#num').change(function(){
		$("#search_info").submit();
	});
        
	$("#count_info_mall_id").change(function(){
		$.post($(this).attr("data-url"), {mall_id:$(this).val()}, function(data){
			$("#shop_list").html(data);
		});
	});
	
	$("#btn").click(function(){
		return valid();
	});
	
});

function valid(){
	if( is_empty($("#count_info_product_id").val()) ){
		$("#product_name").parent().find("span.lbl").text("输入的产品有误");
		$("#product_name").parent().find("span.lbl").show().addClass("err");
		return false;
	}else{
		$("#product_name").parent().find("span.lbl").text("请输入产品");
		$("#product_name").parent().find("span.lbl").hide().removeClass("err");
	}
	var f2 = judge($("#count_info_mall_id"), "empty");
	var f3 = false;
	$("input[name='shop_ids[]']").each(function(){
		if( $(this).attr("checked")=="checked" ){
			f3 = true;
			return true;
		}
	});
	if( f2 ){
		if( !f3 ){
			alert("请选择店铺id");
			return false;
		}else{
			return true;
		}
	}else{
		return false;
	}
}
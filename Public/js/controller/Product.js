$(document).ready(function(){
	$('#num').change(function(){
		$('#search_info').submit();
	});
        
    if(  typeof($('#show').val())!='undefined' && parseInt($('#show').val())==1 ){
		 $("#col").show();    //如果搜索,则将它显现
	}
    
        $("#more_search").click(function(){
           if($("#col").is(":hidden")){
                $("#col").show();    //如果元素为隐藏,则将它显现
                $("#show").attr("value",1); 
            }else{
                $("#col").hide();     //如果元素为显现,则将其隐藏
                $("#show").attr("value",0); 
            }
        });
    
	$("tr[name='item']").click(function(){
		var i = $(this).attr("vel");
		if( $("#item_"+i).attr("data-s")=='1' ){
			$("#item_"+i).attr("data-s", '0');
			$("#item_"+i).hide();
		}else{
			$("#item_"+i).attr("data-s", '1');
			$("#item_"+i).show();
		}
	});
	

	$("#product_name").autocomplete($("#data_url").attr("data-url"), {
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
				$("#product_name").val(res.name);
				$("#product_code").val(res.code);
				$("#product_number").val(res.number);
				$("#product_now_price").val(res.now_price);
				$("#product_sold_price").val(res.sold_price);
				return $.trim(res.name); 
			}else{
				return '暂无记录';
			}
	    },
	    formatResult: function(data, item) {
	    	//if( item!='undefined' ){
	    		var res = eval("("+item+")");
    	    //	$("#product_name").val(res.name);
			//	$("#product_code").val(res.code);
			//	$("#product_number").val(res.number);
			//	$("#product_now_price").val(res.now_price);
			//	$("#product_sold_price").val(res.sold_price);
				return $.trim(res.name);
	    	//}else{
	    	//	return '';
	    	//}
	    }
	});

	
	
	$("#product_category_id").change(function(){
		$.post($(this).attr("vel"), {category_id:$(this).val()}, function(data){
			$("#product_sub_category_id").html(data);
		});
	});
        
    $(document).on("change", "#product_sub_category_id",function(){
		$.post($(this).attr("vel"), {sid:$(this).val()}, function(data){
			$("#product_classification_id").html(data);
		});
	});
	
    $("#btn").click(function(){
        return valid($(this).attr('vel'));
    });
    
//    $("#product_category_id,#product_sub_category_id, #product_code,"+
//      "#product_number,#product_name,#product_now_price,#product_min_price,"+
//      "#product_days,#product_ptime").focus(function(){
//        $(this).parent().find("span.lbl").hide().removeClass("err");
//    });        
        
});

function valid(type){
    var f1 = judge($("#product_category_id"), "empty");
    var f2 = judge($("#product_sub_category_id"), "empty");
    var f3 = judge($("#product_code"), "empty");
    var f4 = judge($("#product_number"), "empty");
    var f5 = judge($("#product_name"), "empty");
    var f6 = judge($("#product_now_price"), "price");
    var f7 = judge($("#product_sold_price"), "price");
    var f8 = judge($("#product_min_price"), "price");
    var f9 = judge($("#product_days"), "number");
    var f10 = judge($("#product_ptime"), "empty");
    if( type=='edit' ){
        var f11 = true;
    }else{
        var f11 = judge($("#product_file"), "empty");
    }
    var f12 = judge($("#product_classification_id"), "empty");
    return (f1&&f2&&f3&&f4&&f5&&f6&&f7&&f8&&f9&&f10&&f11&&f12);
}
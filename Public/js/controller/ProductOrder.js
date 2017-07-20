$(document).ready(function(){
	$('#num').change(function(){
		$('#search_info').submit();
	});
        
	$("#product_category_id").change(function(){
		$.post($(this).attr("vel"), {category_id:$(this).val()}, function(data){
			$("#product_sub_category_id").html(data);
		});
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
        
	if(  typeof($('#show').val())!='undefined' && parseInt($('#show').val())==1 ){
		 $("#col").show();    //如果搜索,则将它显现
	};
        $("#more_search").click(function(){
           if($("#col").is(":hidden")){
                $("#col").show();    //如果元素为隐藏,则将它显现
                $("#show").attr("value",1); 
            }else{
                $("#col").hide();     //如果元素为显现,则将其隐藏
                $("#show").attr("value",0); 
            }
        });
	
	$("#btn").click(function(){
		if( valid() ){
			return true;
		}else{
			return false;
		}
	});
	
});

function valid(){
	var f1 = judge($("#product_order_deliver_deliver_time"), "empty");
	var f2 = judge($("#product_order_deliver_num"), "empty");
	
	return (f1&&f2);
}
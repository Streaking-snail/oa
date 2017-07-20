$(document).ready(function(){
	$('#num').change(function(){
		$('#search_info').submit();
	});
	
	$("#product_base_category_id").change(function(){
		$.post($(this).attr("vel"), {category_id:$(this).val()}, function(data){
			$("#product_base_sub_category_id").html(data);
		});
	});
	
	$(document).on("change", "#product_base_sub_category_id", function(){
		$.post($(this).attr("vel"), {sid:$(this).val()}, function(data){
			$("#product_base_classification_id").html(data);
		});
	});
	
	 $("#btn").click(function(){
         return valid($(this).attr('vel'));
     });
	
	 $("#search_btn").click(function(){
		 $("#search_info").attr("action", $(this).attr("data-url"));
		 $("#search_info").submit();
	 });
	 
	 $("#category_id").change(function(){
		$.post($(this).attr("vel"), {category_id:$(this).val()}, function(data){
			$("#sub_category_id").html(data);
		});
	});
	
	$(document).on("change", "#sub_category_id", function(){
		$.post($(this).attr("vel"), {sid:$(this).val()}, function(data){
			$("#classification_id").html(data);
		});
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
	 
	 
});

function valid(ptype){
	var f1 = judge($("#product_base_category_id"), "empty");
    var f2 = judge($("#product_base_sub_category_id"), "empty");
    var f3 = judge($("#product_base_code"), "empty");
    var f4 = judge($("#product_base_number"), "empty");
    var f5 = judge($("#product_base_name"), "empty");
    var f6 = judge($("#product_base_now_price"), "empty");
    if( !f6 ){
    	var f7 = judge($("#product_base_now_price"), "price");
    }else{
    	var f7 = false;
    }
    var f8 = judge($("#product_base_sold_price"), "empty");
    if( !f8 ){
    	var f9 = judge($("#product_base_sold_price"), "price");
	}else{
		var f9 = false;
	}
    var f10 = judge($("#product_base_min_price"), "empty");
    if( !f10 ){
    	var f11 = judge($("#product_base_min_price"), "price");
    }else{
    	var f11 = false;
    }
    
    if( type=='edit' ){
        var f12 = true;
    }else{
        var f12 = judge($("#product_base_file"), "empty");
    }
    
    var f13 = judge($("#product_base_classification_id"), "empty");

    return (f1&&f2&&f3&&f4&&f5&&f6&&f7&&f8&&f9&&f10&&f11&&f12&&f13);
}
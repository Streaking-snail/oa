$(document).ready(function(){
	
	$('#num').change(function(){
		$('#search_info').submit();
	});
	
	$("#btn").click(function(){
		return valid();
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
 $("#daochu").click(function(){
	 $("#condition_info").attr("action", $(this).attr("data-url"));
	 $("#condition_info").submit();
 });

function valid(){
	if( is_empty($("#deport_name").val()) ){
		$("#deport_name").css({"border":"1px solid red"});
		alert("请输入部门");
		return false;
	}
	if( is_empty($("#user_name").val()) ){
		$("#user_name").css({"border":"1px solid red"});
		alert("报告递交人员");
		return false;
	}
	return true;
}
$(document).ready(function(){
	$('#num').change(function(){
		$('#search_info').submit();
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
    $("#btn").click(function(){
        return valid_form();
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

function valid(type){
	return true;
    var f1 = judge($("#overdue_no"), "empty");
	var f2 = judge($("#overdue_apply_type"),"empty");
    return (f1 && f2);
}
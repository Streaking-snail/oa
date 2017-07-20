$(document).ready(function(){
	
        $("a[name='add_info']").click(function(){
            $("#back").show();
            $(this).parent().find("div.info_form").show();
        });
        $(".closed").click(function(){
            $(this).parent().parent().hide();
            $("#back").hide();
        });
        $("input[name='close']").click(function(){
            $(this).parent().parent().parent().hide();
            $("#back").hide();
        });
        
	$('#num').change(function(){
		$("#search_info").submit();
	});
	
	$("#submit").click(function(){
		if(is_empty($("#content").val()) && is_empty($("#file").val())){
			alert("请填写描述或上传附件");
			return false;
		}
	});
	
	$("tr[name='item'] td[name='td-item']").click(function(){
		var i = $(this).parent().attr("vel");
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
	
});

function refuse(sid,t,id){
	do{
		var refuse = prompt("请输入拒绝理由", ""); //将输入的内容赋给变量 refuse ，  
		if(refuse==="")
			alert('请输入拒绝理由！');
		else 
			break;
	}while(!refuse)
	
	if(refuse !== null){
		$.ajax({
                type: "GET",
                url: "update_status",
                dataType: "text",
                data: "sid="+ sid +"&t="+ t +"&id="+ id +"&content=" + refuse,
                success: function(msg) {
                    if (msg) {
                        alert("操作成功！");
                        location.reload();
                    } else {
                        alert("操作失败！");
                    }
                }
            }); 
	}

	
}
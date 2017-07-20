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
	
	$("input[name='btn']").click(function(){
		return valid($(this).parent());
	});
        
        $("#submit").click(function(){
		if(is_empty($("#content").val()) && is_empty($("#file").val())){
			alert("请填写描述或上传附件");
			return false;
		}
	});
	
});

function valid(obj){
	if( typeof(obj.find("input[name='content']").val())!='undefined' && typeof(obj.find("input[name='file']").val())!='undefined' ){
		if( is_empty(obj.find("input[name='content']").val()) && is_empty(obj.find("input[name='content']").val()) ){
			alert("请填写内容或上传文件");
			return false;
		}
	}
	
	if( typeof(obj.find("input[name='content']").val())!='undefined' ){
		if( is_empty(obj.find("input[name='content']").val()) ){
			alert("请填写内容之后再提交");
			return false;
		}
	}
	if( typeof(obj.find("input[name='file']").val())!='undefined' ){
		if( is_empty(obj.find("input[name='content']").val()) ){
			alert("请上传文件之后再提交");
			return false;
		}
	}
	
	return true;
}
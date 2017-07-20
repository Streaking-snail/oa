$(document).ready(function(){
	//打印
	$("button[name='print_info']").click(function(){
		$("#show_info").jqprint();
		return false;
	});
	
	//添加
	$("input[name='add_info']").click(function(){
        if($('#add_url').length != 0){
            window.location.href=$("#add_url").val();
        }else if(typeof($(this).attr('data-url')) != 'undefined'){
            window.location.href = $(this).attr('data-url');
        }else{
            return false;
        }
	});
	
	//修改
	$("input[name='edit_info']").click(function(){
		var item = $("tr.current");
		if( typeof(item.attr('data-id'))!='undefined' ){
            var url;
            if($('#edit_url').length != 0 ){
                url = $('#edit_url').val();
            }else if(typeof($(this).attr('data-url'))!='undefined'){
                url = $(this).attr('data-url');
            }else{
                return false;
            }
			window.location.href=url+"?id="+item.attr('data-id');
		}else{
			alert("请选择");
		}
	});
	
	//查看
	$("input[name='show_info']").click(function(){
		var item = $("tr.current");
		if( typeof(item.attr('data-id'))!='undefined' ){
            var url ;
            if($('#show_url').length != 0){
                url = $('#show_url').val();
            }else if(typeof($(this).attr('data-url'))!='undefined'){
                url = $(this).attr('data-url');
            }else{
                return false;
            }
			window.open(url+"?id="+item.attr('data-id'));
			//window.location.href=$("#show_url").val()+"?id="+id;
		}else{
			alert("请选择");
		}
	});
	
	//查看状态
	$("a[name='show_status']").click(function(){
		$("#back").show();
		$.post($(this).attr("data-url"), function(data){
			$("#checked_list").show().html(data);
		});
	});
	
	$("a[name='add_checked']").click(function(){
		$("#back").show();
		$("#add_checked").show();
		$("#check_id").val($(this).attr("data-id"));
	});
	
	$("#checked").click(function(){
		$("#type").val("checked");
		$("#check_form").submit();
	});
	$("#unchecked").click(function(){
		$("#type").val("unchecked");
		$("#check_form").submit();
	});
	
	$(document).on("click", ".closed", function(){
		$(this).parent().parent().hide();
		$("#back").hide();
	});
	
	//选中
	$("tr[name='item']").click(function(){
		$("tr[name='item']").removeClass("current");
		$(this).addClass("current");
	}).dblclick(function(){
        var url ;
        if($('#show_url').length != 0){
            url = $('#show_url').val();
        }else if(typeof($('input[name="show_info"]').attr('data-url'))!='undefined'){
            url = $('input[name="show_info"]').attr('data-url');
        }else{
            return false;
        }
		window.open(url+"?id="+$(this).attr('data-id'));
	});
	
	//返回上页
	$("button[name='back_btn']").click(function(){
		history.go(-1);
	});
	
	//查询用户
	if( typeof($("input[name='user_name']").length)!='undefined' ){
		$("input[name='user_name']").click(function(){
			$(this).autocomplete($("input[name='user_name']").attr("data-url"), {
				minChars:1,
				max: 10,
				autoFocus: true,
				autoFill: false,
				matchContains: true,
				scrollHeight: 250,
				minlength: 1,
				mustMatch: true,
				width: parseInt($("input[name='user_name']").width())+50,
				formatItem: function(rows, i, max, item) {
					var res = eval("("+item+")");
					return $.trim(res.name);
			    },
			    formatResult: function(data, item) {
			    	var res = eval("("+item+")");
			    	return $.trim(res.name);
			    }
			}).result(function(event, item, formatted){
					var res = eval("("+item+")");
					if( parseInt(res.deport_id)>0 ){
						$("input[data='deport_id']").val(res.deport_id);
						$("input[name='deport_name']").val(res.deport_name);
					}
					$("input[name='deport_name']").val(res.name);
					$("input[data='user_id']").val(res.id);
			});
		});
	}
	if( typeof($("input[name='deport_name']").length)!='undefined' ){
		$("input[name='deport_name']").autocomplete($("input[name='deport_name']").attr("data-url"), {
			minChars:1,
			max: 10,
			autoFocus: true,
			autoFill: false,
			matchContains: true,
			scrollHeight: 250,
			minlength: 1,
			mustMatch: true,
			width: parseInt($("input[name='deport_name']").width())+50,
			formatItem: function(rows, i, max, item) {
				var res = eval("("+item+")");
				return $.trim(res.name);
		    },
		    formatResult: function(data, item) {
		    	var res = eval("("+item+")");
		    	return $.trim(res.name);
		    }
		}).result(function(event, item, formatted){
				var res = eval("("+item+")");
				$("input[name='deport_name']").val(res.name);
				$("input[data='deport_id']").val(res.id);
		});
	}
	
});
function is_empty(str){
    return typeof(str)=='undefined' || str==null || str=='' || str.length==0 || str==0;
}

function is_not_number(str){  
    var reg = new RegExp("^[0-9]*$");   
    if( reg.test(str) ){  
        return false;
    }else{
        return true;
    }
}

function is_not_email(str){
    var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    if( reg.test(str) ){
       return false;
    }else{
       return true;
    }
}

function isPriceNumber(_keyword){  
    if(_keyword == "0" || _keyword == "0." || _keyword == "0.0" || _keyword == "0.00"){  
        _keyword = "0"; return true;  
    }else{  
        var index = _keyword.indexOf("0");  
        var length = _keyword.length;  
        if(index == 0 && length>1){/*0开头的数字串*/  
            var reg = /^[0]{1}[.]{1}[0-9]{1,2}$/;  
            if(!reg.test(_keyword)){  
                return false;  
            }else{  
                return true;  
            }  
        }else{/*非0开头的数字*/  
            var reg = /^[1-9]{1}[0-9]{0,10}[.]{0,1}[0-9]{0,2}$/;  
            if(!reg.test(_keyword)){  
                return false;  
            }else{  
                return true;  
            }  
        }             
        return false;  
    }  
}  

//
function is_not_date(str){
    return true;
}

function judge(obj, type){
    var f = true;
    switch(type){
        case "email":
            f = is_not_email(obj.val());
            break;
        case "date":
            f = is_not_date(obj.val());
            break;
        case "number":
            f = is_not_number(obj.val());
            break;
        case "price":
            f = !isPriceNumber(obj.val());
            break;
        default :
             f = is_empty(obj.val());
    }
    if( !f ){
        obj.parent().find("span.lbl").hide().removeClass("err");
        return true;
    }else{
        obj.parent().find("span.lbl").show().addClass("err");
        return false;
    }
}

/**
 * 若要验证表单元素 增加class属性 valid , valid_type属性 默认值为empty , error_msg属性若不填写输出 : 错误信息属性未填写
 * 验证表单元素值 class valid , valid_type 验证类型 'empty' 'email' 'date'... error_msg 为出错标签after提示的错误信息
 */
function valid_form(){
    var len = $('.valid').length;
    var f = true;
    var type ;//验证类型 , 默认验空
    var tagArr = ['INPUT','SELECT','TEXTAREA','BUTTON','SUBMIT']; //验证的标签类型,防止不是表单元素添加了vaild属性使验证返回为false
    if( len >0 ){
        $('.valid').each(function () {
            type = $(this).attr('valid_type');
            var tagName = $(this)[0].tagName;
            if($.inArray(tagName,tagArr)>=0){
                var ff = judge_form($(this),type);
                if(f == true){
                    f = ff;
                }
            }else{
                return;//相当于continue
            }
        });
    }
    return f;
}
function judge_form(obj, type){
    var f = true;
    var error_len = obj.siblings('.error_msg').length;//查看存放错误信息标签是否生成
    var error_msg = obj.attr('error_msg');//错误信息
    if(!error_msg){
        error_msg = '错误信息属性未填写';
    }
    if(error_len == 0){
        var error_html = ' <span class="help-inline error_msg col-xs-12 col-sm-7"><label class="middle"><span class="lbl">' +
            error_msg+'</span></label></span>';
        obj.after(error_html);
    }
    switch(type){
        case "email":
            f = is_not_email(obj.val());
            break;
        case "date":
            f = is_not_date(obj.val());
            break;
        case "number":
            f = is_not_number(obj.val());
            break;
        case "price":
            f = !isPriceNumber(obj.val());
            break;
        default :
            f = is_empty(obj.val());
    }
    if( !f ){
        obj.parent().find("span.lbl").hide().removeClass("err");
        return true;
    }else{
        obj.parent().find("span.lbl").show().addClass("err");
        return false;
    }
}
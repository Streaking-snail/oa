$(document).ready(function(){
	
	$('#num').change(function(){
		$('#search_info').submit();
	});
	
	$('#admin_user_deport_id').change(function(){
		 $.get($(this).attr('vel'), {id:$(this).val()}, function(data){
			 $('#admin_user_role_id').html(data);
		 });
	});
	
//         $("#btn").click(function(){
//             return valid($(this).attr("vel"));
//        });
        

});

function valid(ptype){
    var f1 = judge($("#admin_user_deport_id"), "empty");
    var f2 = judge($("#admin_user_role_id"), "empty");
    var f3 = judge($("#admin_user_username"), "empty");
    if( ptype!='edit' ){
	    var f4 = judge($("#admin_user_password"), "empty");
	    var f5 = judge($("#admin_user_confirm_password"), "empty");
	    if( $("#admin_user_password").val()!=$("#admin_user_confirm_password").val() ){
	    	f5 = false;
	    	$("#admin_user_confirm_password").parent().find("span.lbl").show().addClass("err");
	    }
	}else{
		var f4 = true;
		var f5 = true;
	}
    var f6 = judge($("#admin_user_mobile"), "empty");

    return (f1&&f2&&f3&&f4&&f5&&f6);
}
$(document).ready(function(){
	$("#btn").click(function(){
		return valid();
	});
});

if(document.getElementById('show').value==1){
        console.log(document.getElementById('show'));
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

function valid(){
    if( is_empty($("#start_time").val()) ){
		$("#start_time").css({"border":"1px solid red"});
		alert("请输入出差开始时间");
		return false;
	}
    if( is_empty($("#end_time").val()) ){
            $("#end_time").css({"border":"1px solid red"});
            alert("请输入出差结束时间");
            return false;
    }
    return true;
}
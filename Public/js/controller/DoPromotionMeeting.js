$(document).ready(function(){
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
    
    function valid(){
        if( is_empty($("#address").val()) ){
                    $("#address").css({"border":"1px solid red"});
                    alert("请输入会议地点");
                    return false;
            }
        if( is_empty($("#meeting_time").val()) ){
                $("#meeting_time").css({"border":"1px solid red"});
                alert("请输入会议时间");
                return false;
        }
        return true;
    }
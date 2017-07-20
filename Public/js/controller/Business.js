$(document).ready(function(){
	
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
});

    $("input[name='del_b']").on('click',function(){   //删除阶梯价格
        if( $("tr[name='item']").length>1 ){
            var sub_add = $("a[name='sub_add']").clone(true);
            $(this).parent().parent().remove();
            $("a[name='sub_add']").remove();
            $("tr[name='item']:last").find("td:last").append(sub_add);
        }else{
            alert("已经删除到最后一行了");
        }
        return false;
    });
    $("a[name='sub_add']").on('click',function(){
        var obj = $('tr[name="item"]:last').clone(true).insertAfter('tr[name="item"]:last');
        var i = parseInt(obj.attr('vel'));
        obj.attr('vel', i+1).attr('id','sub_cat_'+(i+1));
        obj.find('#product_name_'+i).attr('id','product_name_'+(i+1)).attr('name', 'entry['+(i+1)+'][product_name]').val('');
        obj.find('#num_'+i).attr('id','num_'+(i+1)).attr('name', 'entry['+(i+1)+'][num]').val('');
        obj.find('#unit_'+i).attr('id','unit_'+(i+1)).attr('name', 'entry['+(i+1)+'][nuit]').val('');
        obj.find('#content_'+i).attr('id','content_'+(i+1)).attr('name', 'entry['+(i+1)+'][content]').val('');
        obj.find('#back_num_'+i).attr('id','back_num_'+(i+1)).attr('name', 'entry['+(i+1)+'][back_num]').val('');
        obj.find('#back_time_'+i).attr('id','back_time_'+(i+1)).attr('name', 'entry['+(i+1)+'][back_time]').val('');
        $(this).remove();
        return false;
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
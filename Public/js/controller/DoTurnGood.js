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
    
    function del_sub(obj){
        if( $("tr[name='item']").length>1 ){
            var tr=obj.parentNode.parentNode;
            var tbody=tr.parentNode;
            tbody.removeChild(tr);
        }else{
            alert("已经删除到最后一行了");
        }
        return false;
    }
    function add_sub(){
        var obj = $('tr[name="item"]:last').clone(true).insertAfter('tr[name="item"]:last');
        var i = parseInt(obj.attr('vel'));
        obj.attr('vel', i+1).attr('id','sub_cat_'+(i+1));
        obj.find('#number_'+i).attr('id','number_'+(i+1)).attr('name', 'do_turn_good_items['+(i+1)+'][number]').val('');
        obj.find('#name_'+i).attr('id','name_'+(i+1)).attr('name', 'do_turn_good_items['+(i+1)+'][name]').val('');
        obj.find('#num_'+i).attr('id','num_'+(i+1)).attr('name', 'do_turn_good_items['+(i+1)+'][num]').val('');
        obj.find('#office_id_'+(i)).attr('id','office_id_'+(i+1)).attr('name', 'do_turn_good_items['+(i+1)+'][office_id]').val('');
        obj.find('#content_'+(i)).attr('id','content_'+(i+1)).attr('name', 'do_turn_good_items['+(i+1)+'][content]').val('');
        return false;
    }
    
    function valid(){
        if( is_empty($("#consignee").val()) ){
                    $("#consignee").css({"border":"1px solid red"});
                    alert("请输入收货人");
                    return false;
            }
        if( is_empty($("#tg_time").val()) ){
                $("#tg_time").css({"border":"1px solid red"});
                alert("请输入调货时间");
                return false;
        }
        return true;
    }
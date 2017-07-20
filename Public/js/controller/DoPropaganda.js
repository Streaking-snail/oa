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
        obj.find('#order_time_'+i).attr('id','order_time_'+(i+2)).attr('name', 'do_propaganda_items['+(i+2)+'][order_time]').val('');
        obj.find('#price_'+i).attr('id','price_'+(i+2)).attr('name', 'do_propaganda_items['+(i+2)+'][price]').val('');
        obj.find('#num_'+i).attr('id','num_'+(i+2)).attr('name', 'do_propaganda_items['+(i+2)+'][num]').val('');
        obj.find('#order_time_'+(i+1)).attr('id','order_time_'+(i+3)).attr('name', 'do_propaganda_items['+(i+3)+'][order_time]').val('');
        obj.find('#price_'+(i+1)).attr('id','price_'+(i+3)).attr('name', 'do_propaganda_items['+(i+3)+'][price]').val('');
        obj.find('#num_'+(i+1)).attr('id','num_'+(i+3)).attr('name', 'do_propaganda_items['+(i+3)+'][num]').val('');
        return false;
    }
    
    function valid(){
        if( is_empty($("#samlesman").val()) ){
                    $("#samlesman").css({"border":"1px solid red"});
                    alert("请输入业务员姓名");
                    return false;
            }
        if( is_empty($("#apply_time").val()) ){
                $("#apply_time").css({"border":"1px solid red"});
                alert("请输入申请时间");
                return false;
        }
        return true;
    }
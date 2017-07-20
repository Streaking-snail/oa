$(document).ready(function(){
    $("#btn").click(function(){
        return valid();
    })
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
        obj.find('#product_id_'+i).attr('id','product_id_'+(i+1)).attr('name', 'do_post_code_items['+(i+1)+'][product_id]').val('');
        obj.find('#change_id_'+i).attr('id','change_id_'+(i+1)).attr('name', 'do_post_code_items['+(i+1)+'][change_id]').val('');
        obj.find('#barcode_'+i).attr('id','barcode_'+(i+1)).attr('name', 'do_post_code_items['+(i+1)+'][barcode]').val('');
        obj.find('#plan_order_price_'+(i)).attr('id','plan_order_price_'+(i+1)).attr('name', 'do_post_code_items['+(i+1)+'][plan_order_price]').val('');
        obj.find('#plan_change_price_'+(i)).attr('id','plan_change_price_'+(i+1)).attr('name', 'do_post_code_items['+(i+1)+'][plan_change_price]').val('');
        obj.find('#unit_'+(i)).attr('id','unite_'+(i+1)).attr('name', 'do_post_code_items['+(i+1)+'][unit]').val('');
        obj.find('#num_'+(i)).attr('id','num_'+(i+1)).attr('name', 'do_post_code_items['+(i+1)+'][num]').val('');
        return false;
    }
    
    function valid(){
        if( is_empty($("#apply_time").val()) ){
                    $("#apply_time").css({"border":"1px solid red"});
                    alert("请输入申请日期");
                    return false;
            }
//        if( is_empty($("#tg_time").val()) ){
//                $("#tg_time").css({"border":"1px solid red"});
//                alert("请输入调货时间");
//                return false;
//        }
        return true;
    }
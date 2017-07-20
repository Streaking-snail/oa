$(document).ready(function () {
    $('#num').change(function () {
        $('#search_info').submit();
    });
    $("tr[name='item']").click(function () {
        var i = $(this).attr("vel");
        if ($("#item_" + i).attr("data-s") == '1') {
            $("#item_" + i).attr("data-s", '0');
            $("#item_" + i).hide();
        } else {
            $("#item_" + i).attr("data-s", '1');
            $("#item_" + i).show();
        }
    });
    var item_url = $('#item_url').attr('href');
    //选择产品时,获取大类与货号
    $(document).delegate('.product_item', 'change', function () {
        var vel = $(this).val();
        var obj = $(this);
        if (vel != 0) {
            $.post(item_url, {id: vel}, function (data) {
                var data_obj = eval('(' + data + ')');
                obj.parents('tr').find('.dalei').val(data_obj.name);
                obj.parents('tr').find('.huohao').val(data_obj.number)
            });
        } else {//传入值为空,对应值也清空
            obj.parents('tr').find('.dalei').val("");
            obj.parents('tr').find('.huohao').val("")
        }
    });
    $("#btn").click(function () {
        var f = valid_form();
        if(f){
            //提交表单时候把辅助克隆的元素移除
            $('#clone_item').remove();
        }
        return f;
    });
    $('#add_item').click(function () {
        var clone_obj = $('#clone_item').clone();
        clone_obj.show();
        clone_obj.removeAttr('id');
        $(this).parents('tr').before(clone_obj);
    });
    $(document).delegate('.remove_item', 'click', function () {
        $(this).parents('tr').remove();
    });
    $(document).delegate('.item_num', 'blur', function () {
        CountPrice($(this));
    });
    $(document).delegate('.item_price','blur', function () {
       CountPrice($(this));
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
    
    function CountPrice(obj){
        var vel = parseInt(obj.parents('tr').find('.item_num').val());
        var price = parseFloat(obj.parents('tr').find('.item_price').val());
        if(!isNaN(vel) && !isNaN(price)){
            var t_price = vel * price;
            obj.parents('tr').find('.item_total_price').val(t_price);
        }else {
            return false;
        }
    }
});
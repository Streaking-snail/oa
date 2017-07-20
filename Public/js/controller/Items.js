$(document).ready(function(){
	
	$('#num').change(function(){
		$("#search_info").submit();
	});
	
	$("input[name='add_attach']").change(function(){
		$(this).parent().ajaxSubmit(function(data){
			console.log(data);
		});
	});
	
	$("tr[name='item']").click(function(){
		if( $("#item_"+$(this).attr("vel")).attr("data-s")=='1' ){
			$("#item_"+$(this).attr("vel")).attr("data-s", '0');
			$("#item_"+$(this).attr("vel")).hide();
		}else{
			$("#item_"+$(this).attr("vel")).attr("data-s", '1');
			$("#item_"+$(this).attr("vel")).show();
		}
	});
	
});
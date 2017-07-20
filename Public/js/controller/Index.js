$(document).ready(function(){
	
	$(document).on("click",'#send_msg_btn',function(){
		$.post("send_msg", {message:$("input[name='message']").val()}, function(data){
			if( data=='no' ){
				alert("发送失败");
			}else if(data=='params'){
				alert("参数错误");
			}else{
				$('#msg_list').html(data);
			}
		});
	}).on("click", "a[name='del_item']", function(){
		var obj = $(this);
		$.post("delete_msg", {id:$(this).attr("vel")}, function(data){
			if( data=='yes' ){
				obj.parent().parent().parent().remove();
			}else{
				alert("撤销失败");
			}
		});
	});
	
	$('#all_msg').click(function(){
		if( $(this).attr("vel")=='all' ){
			$(this).attr("vel", 'last');
			$.post($(this).attr("data-url"), {t:'all'}, function(data){
				 $('#msg_list').css("height", '500px');
				 $('#msg_list').html(data);
			});
		}else{
			$(this).attr("vel", 'all');
			$.post($(this).attr("data-url"), {t:'last'}, function(data){
				 $('#msg_list').css("height", '500px');
				 $('#msg_list').html(data);
			});
		}
	});
	
	$.resize.throttleWindow = false;
	
	  var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
	  var data = [
		{ label: "social networks",  data: 38.7, color: "#68BC31"},
		{ label: "search engines",  data: 24.5, color: "#2091CF"},
		{ label: "ad campaigns",  data: 8.2, color: "#AF4E96"},
		{ label: "direct traffic",  data: 18.6, color: "#DA5430"},
		{ label: "other",  data: 10, color: "#FEE074"}
	  ]
	  function drawPieChart(placeholder, data, position) {
	 	  $.plot(placeholder, data, {
			series: {
				pie: {
					show: true,
					tilt:0.8,
					highlight: {
						opacity: 0.25
					},
					stroke: {
						color: '#fff',
						width: 2
					},
					startAngle: 2
				}
			},
			legend: {
				show: true,
				position: position || "ne", 
				labelBoxBorderColor: null,
				margin:[-30,15]
			}
			,
			grid: {
				hoverable: true,
				clickable: true
			}
		 })
	 }
	 drawPieChart(placeholder, data);
	
	 /**
	 we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
	 so that's not needed actually.
	 */
	 placeholder.data('chart', data);
	 placeholder.data('draw', drawPieChart);
	
	
	  //pie chart tooltip example
	  var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
	  var previousPoint = null;
	
	  placeholder.on('plothover', function (event, pos, item) {
		if(item) {
			if (previousPoint != item.seriesIndex) {
				previousPoint = item.seriesIndex;
				var tip = item.series['label'] + " : " + item.series['percent']+'%';
				$tooltip.show().children(0).text(tip);
			}
			$tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
		} else {
			$tooltip.hide();
			previousPoint = null;
		}
		
	 });
	
});
<html>
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="./jquery-3.1.0.min.js"></script>
	<style>
		tr{
			height:40px;
		}
		td{
			text-align:center;
			width:40px;
		}
		input{
			width:40px;
			height:40px;
		}
	</style>
</head>
<body>
	<table border="1px solid #000" cellpadding="0" cellspacing="0">
	<?php
	for($i=1;$i<=9;$i++){
		echo "<tr>";
		for($j=1;$j<=9;$j++){
			$id="id_".$i."_".$j;
			echo "<td><input id='".$id."'  x-data='".$i."' y-data='".$j."' data='' type='button'></td>";
		}
		echo "</tr>";
	}?>
	</table>
	<script>
	var i=0;
	var json;
	$('input').click(function(){
		var x=$(this).attr("x-data");
		var y=$(this).attr("y-data");
		if(i==0){
			$.ajax({
				url:"ajax.php",
				type:'post',
				data:'x='+x+'&y='+y,
				success:function(data){
					json=$.parseJSON(data);
					$.each(json,function(i,item){
						$("#id_"+item.row+"_"+item.column).attr('data',item.value);
						if(x==item.row&&y==item.column){
							if($("#id_"+item.row+"_"+item.column).attr('data')!=''){
								$("#id_"+item.row+"_"+item.column).attr('value',item.value);
								$("#id_"+item.row+"_"+item.column).css('background-color','green');
							}else{
								$("#id_"+item.row+"_"+item.column).css('background-color','#fff');
								//翻开相邻的空白
							}
						}
					});
				}
			});

		}
		if(i>0){
			var xy="#id_"+x+"_"+y;
			if($(xy).attr('data')){
				$(xy).attr('value',$(xy).attr('data'));
				if($(xy).attr('data')=='雷区'){
					$(xy).css('background-color','red');
				}else{
					$(xy).css('background-color','green');
				}
			}else{
				$(xy).css('background-color','#fff');
			}
		}
		i++;
	});

	</script>
</body>
</html>

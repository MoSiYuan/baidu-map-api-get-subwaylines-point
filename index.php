<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<style type="text/css">
		body, html{width: 100%;height: 100%;margin:0;font-family:"微软雅黑";}
		.left{width: 50%;float: left}
		.right{width: 50%;float: right}
		#l-map{height:50%;}
		#r-result{max-height: 100%;}
		.div_path{word-wrap:break-word;font-size:8px;float: left;width: 100%;}
	</style>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
	<title>公交/地铁线路查询</title>
</head>
<body>
<div id="div_debug"></div>
<div class="left">
	<div id="l-map"></div>
	<div id="infoInput">
		<input type="text" name="city" value="北京" placeholder="输入城市名">
		<input type="button" onclick="changeCity();" value="切换城市">
		<input type="text" name="lineName" value="1号线" placeholder="输入地铁线全名"/>
		<input type="button" onclick="lineSearch();" value="搜索地铁线">
	</div>
	<div class="div_path"></div>
</div>
<div class="right">
	<div id="r-result"></div>
</div>
</body>
</html>
<script type="text/javascript">
	// 百度地图API功能
	var lineLocations = '';
	var city="北京";
	var map = new BMap.Map("l-map");            // 创建Map实例
	map.centerAndZoom(city, 12);

	var busline = new BMap.BusLineSearch(map,{
		renderOptions:{map:map,panel:"r-result"},
		onGetBusListComplete: function(result){
			if(result) {
				var fstLine = result.getBusListItem(0);//获取第一个公交列表显示到map上
				busline.getBusLine(fstLine);
			}
		},
		onGetBusLineComplete: function(result){
			if(result) {
				var lineArr = result.getPath();
				var string='';
				lineArr.forEach(function(e,index,arr){
					string+=e.lng+","+e.lat+";";
					lineLocations=string;
					printLineLocations();
				});
			}
		}
	});

	function lineSearch(){
		var lineName=document.getElementsByName("lineName").item(0).value;
		busline.getBusList(lineName);
	}

	function changeCity(){
		city=document.getElementsByName("city").item(0).value;
		map.centerAndZoom(city, 12);
	}
	function printLineLocations(){
		document.getElementsByClassName("div_path").item(0).innerHTML=lineLocations;
	}

	function print_object(object)
	{
		var obj =object;
		var str="";
		for(each in obj)
		{
			str += each +":" +obj[each]+"<br/>";
		}
		document.getElementById("div_debug").innerHTML=str;
	}
</script>

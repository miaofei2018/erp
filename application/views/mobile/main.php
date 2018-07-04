<!DOCTYPE html>
<html>
<head>
<title>登陆页面</title>
<meta charset="utf-8">
<meta name="format-detection" content="telephone=no">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta http-equiv="Access-Control-Allow-Origin" content="*">
<style type="text/css">
.nav {
    background: #009c39;//#0499fe;//#38393f;//#009c39;
    padding: 10px 0 6px 0;
    width: 100%;
    position: fixed;
    left: 0;
    bottom: 0;
}
.nav ul {
    height: 0px;
}
.nav ul li {
    float: left;
    width: 20%;
    text-align: center;
    list-style-type: none;
    margin: 0px;
    padding: 0px;
}
.nav ul li span {
    display: block;
    color: #fff;
    font-size: 14px;
    font-family: "微软雅黑";
    line-height: 22px;
}
a {
    color: #000;
    text-decoration: none;
}
* {
    padding: 0;
    margin: 0;
    list-style: none;
    font-weight: normal;
}

</style>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/ichart.1.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/auto-alert.js"></script>
</head>
<body>
    <!-- 头部导航 -->
	<header style="background: #009c39;position:absolute;height:60px;line-height:60px;color:#fff;z-index:49;width:100%">
    	<!-- <span style="display:inline-block; width:40px;float:left;text-align:center"><</span> -->
    	<span id="maintitle" style="display:block;float:left;text-align:center;width:calc(100%)">日单量</span><!--  - 80px -->
    	<!--<span style="display:inline-block;float:right;width:40px;text-align:center">></span> -->
	</header>
	<!-- 内容 -->
	<div id="canvasDiv" style="position:absolute;top:60px;height:calc(100% - 123px);"></div>
	<!-- 底部导航 -->
	<footer class="nav">
		<ul>
			<li id="shouye" onclick="loadChart()"><a href="javascript:void(0)"><span><img src="<?php echo base_url()?>statics/mobile/images/f1.png" height="20"></span><span>首页</span></a>
			</li>
			<li id="xiadan" style="position: relative;">
			     <a href="javascript:void(0)"><span><img src="<?php echo base_url()?>statics/mobile/images/f2.png" height="20"></span><span>下单</span></a>
			</li>
			<li id="kucun" ><a href="javascript:void(0)"><span><img src="<?php echo base_url()?>statics/mobile/images/f5.png" height="20"></span><span>库存</span></a>
			</li>
			<li id="baobiao"><a href="javascript:void(0)"><span><img src="<?php echo base_url()?>statics/mobile/images/f3.png" height="20"></span><span>报表</span></a>
			</li>
			<li id="wode"><a href="javascript:void(0)"><span><img src="<?php echo base_url()?>statics/mobile/images/f4.png" height="20"></span><span>个人中心</span></a>
			</li>
		</ul>
	</footer>
</body>
</html>
<script type="text/javascript">
var soOrSa = "sa";
var boss = "<?php echo $boss?>";
var chart = null;
//定义数据
 $(function(){	
	 if(boss != '1'){
		 location.href="<?php echo base_url()?>index.php/mobile/v"+soOrSa;
		 return;
		 $("#maintitle").text("米辰科技进销存");
		 $("#shouye").hide();
		 $("#kucun").hide();
		 $("#baobiao").hide();
		 $("#canvasDiv").hide();
		 $("#xiadan").css("width","50%");
		 $("#shouye").css("width","50%");
	 }
	chart = new iChart.Column2D({
		render : 'canvasDiv',//渲染的Dom目标,canvasDiv为Dom的ID
		data: null,//绑定数据
		//title : '单量',//设置标题
		width : document.body.clientWidth+40,//设置宽度，默认单位为px
		height : window.screen.height-250,//设置高度，默认单位为px
		shadow:true,//激活阴影
		shadow_color:'#c7c7c7',//设置阴影颜色
		coordinate:{//配置自定义坐标轴
			scale:[{//配置自定义值轴
				 position:'left',//配置左值轴	
				 start_scale:0,//设置开始刻度为0
				 end_scale:10,//设置结束刻度为26
				 scale_space:10,//设置刻度间距
				 listeners:{//配置事件
					parseText:function(t,x,y){//设置解析值轴文本
						return {text:t+"单"}
					}
				}
			}]
		}
	});
	//调用绘图方法开始绘图
	//chart.draw();
	loadChart();
	$("#xiadan").click(function(){
		$.fn.alert({
	        'tip': '选择单据类型',
	        'btnLbl': [
		       	        ['购货单', '退货单','客户订单'],
		       	        ['销货单', '销退单','客户退单']
		       	      ],
	        callback:[
		      	        [
                	        function() {
                	        	location.href = "<?php echo base_url()?>index.php/mobile/vpa";
                	        }, 
                	        function() {
                	        	location.href = "<?php echo base_url()?>index.php/mobile/vpr";
                	        },
                	        function() {
                	        	location.href = "<?php echo base_url()?>index.php/mobile/vso";
                	        }
                	    ],
                	    [
                  	        function() {
                  	        	location.href = "<?php echo base_url()?>index.php/mobile/vsa";
                  	        }, 
                  	        function() {
                  	        	location.href = "<?php echo base_url()?>index.php/mobile/vsr";
                  	        },
                    	    function() {
                  	        	location.href = "<?php echo base_url()?>index.php/mobile/vsor";
                  	        }
                  	    ],
                  	    [null,null, null]
                  	 ]
	    });
	});
	$("#kucun").click(function(){
		location.href = "<?php echo base_url()?>index.php/mobile/vstock";
	});
	$("#baobiao").click(function(){
		location.href = "<?php echo base_url()?>index.php/mobile/vreport";
	});
	$("#wode").click(function(){
		location.href = "<?php echo base_url()?>index.php/mobile/center";
	});
	
});
 function loadChart(){
	 if(!chart) return;
	 $.ajax({
	        type: "post",
	        url: "<?php echo base_url()?>index.php/mobile/getDayBillNum",
	        data: {},
	        dataType: "json",
	        success: function (rtn) {
	            if(rtn.status==200){
	                var dt = rtn.data;
	                var data = [
	                        	{name : '客户订单',value : dt.orderNum,color:'#c12c44'},
	                           	{name : '销售出库',value : dt.saleNum,color:'#a56f8f'},
	                           	{name : '销退入库',value : dt.saleRtnNum,color:'#76a871'},
	                           	{name : '购货入库',value : dt.purNum,color:'#76a871'},
	                           	{name : '退货出库',value : dt.purRtnNum,color:'#a56f8f'}
	                         ];
	                chart.load(data);
	            }else{
	            }
	        },
	        error: function () {
	            console.log("查询日单失败！")
	        }
	    });
 }
</script>
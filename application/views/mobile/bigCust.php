<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>台州镇杰科技有限公司订单系统</title>
<meta name="description" content="台州镇杰科技有限公司订单系统" />
</head>

<body>
<audio id="broadcast" style="display: none" controls="controls" ><!-- autoplay="autoplay" -->
  <source src="<?php echo base_url()?>statics/mobile/images/7758.mp3" type="audio/ogg" />
</audio>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
(function($){

	$.fn.myScroll = function(options){
	//默认配置
	var defaults = {
		speed:60,  //滚动速度,值越大速度越慢
		rowHeight:54 //每行的高度
	};
	
	var opts = $.extend({}, defaults, options),intId = [];
	
	function marquee(obj, step){
	
		obj.find("ul").animate({
			marginTop: '-=1'
		},0,function(){
				var s = Math.abs(parseInt($(this).css("margin-top")));
				if(s >= step){
					$(this).find("li").slice(0, 1).appendTo($(this));
					$(this).css("margin-top", 0);
				}
			});
		}
		
		this.each(function(i){
			var sh = opts["rowHeight"],speed = opts["speed"],_this = $(this);
			intId[i] = setInterval(function(){
				if(_this.find("ul").height()<=_this.height()){
					clearInterval(intId[i]);
				}else{
					marquee(_this, sh);
				}
			}, speed);

			_this.hover(function(){
				clearInterval(intId[i]);
			},function(){
				intId[i] = setInterval(function(){
					if(_this.find("ul").height()<=_this.height()){
						clearInterval(intId[i]);
					}else{
						marquee(_this, sh);
					}
				}, speed);
			});
		
		});

	}

})(jQuery);

function getOrderInfo(){
	$.ajax({
        type: "post",
        url: "<?php echo base_url()?>index.php/mobile/getBigOrder",
        data: {},
        dataType: "json",
        success: function (rtn) {
            if(rtn.status==200){
                $("#ordList").empty();
                $("#ordListVip").empty();
                var data = rtn.data;
                var ordinfo,ordinfovip = '';
                var j=1,k=1;
                for(var i in data){
                    var ord = data[i];
                    var level = parseInt(ord.contactLevel);console.info(level);
                    var m = level >= 2 ? k : j;
                    var serino = ('00'+ m);
                    var one = '<li '+ (m < 6 ? 'class="top"':'')+'>'+
        							'<em>'+serino.substring(serino.length-2)+'</em>'+
        							'<p>'+
        								'<a href="javascript:void(0)">'+
        									'<span style="float:left;display:inline-block;width:15%;overflow:hidden;text-align:center;">' + ord.billDate + '</span>'+
        									'<span style="float:left;display:inline-block;width:25%;overflow:hidden;text-align:center;">' + ord.contactName + '</span>'+
        									<!--'<span style="float:left;display:inline-block;width:10%;overflow:hidden;">' + '¥&nbsp;'+ord.amount + '</span>'+-->
        									'<span style="float:left;display:inline-block;width:25%;overflow:hidden;text-align:center;">' + ord.goodName + '</span>'+
											'<span style="float:left;display:inline-block;width:5%;overflow:hidden;text-align:center;">' + ord.totalQty + '</span>'+
        									'<span style="float:left;display:inline-block;width:30%;overflow:hidden;text-align:center;">' + ord.description + '</span>'+
        								'</a>'+
        							'</p>'+
        							<!--'<span class="num">'+ord.totalQty+'</span>'+-->
        						'</li>';
					if(ord.contactLevel>=2){
						ordinfovip += one;
						k++;
					}else{
						ordinfo += one;
						j++;
					}
                }
                $("#ordList").append($(ordinfo));
                $("#ordListVip").append($(ordinfovip));
                if(curCount>0 && data.length>curCount){
					var audio = $("#broadcast")[0];
					audio.play();
				}
				curCount = data.length;
            }else{
            }
			if(firstscroll){
				$("div.ranklist").myScroll({
					speed:60,
					rowHeight:54
				});
				firstscroll = false;
			}
        },
        error: function () {
            console.log("获取订单失败！")
        }
    });
}

$(function(){
	window.setInterval(getOrderInfo,30000); 
	
	/*$("#ranklist2").myScroll({
		speed:50,
		rowHeight:52
	});*/
	getOrderInfo();
	/*$("div.ranklist").myScroll({
		speed:60,
		rowHeight:54
	});*/
});
var curCount=0;
var firstscroll = true;
</script>	

<style type="text/css">
html,body{height:95%;}
*{margin:0;padding:0;list-style-type:none;}
a,img{border:0;}
a,a:visited{color:#5e5e5e; text-decoration:none;}
a:hover{color:#b52725;text-decoration:underline;}
.clear{display:block;overflow:hidden;clear:both;height:0;line-height:0;font-size:0;}
/*body{font:20px/180% Arial, Helvetica, sans-serif;}*/
body{font-size:25px;}
.demo{width:95%;margin:20px auto;border:solid 1px #ddd;padding:0 10px;}
.demo h2{font-size:30px;color:#333;height:30px;line-height:30px;padding:15px 0;color:#791039;}/*#3366cc*/
/* ranklist */
.ranklist{height:400px;overflow:hidden;}
.ranklist li{height:32px;line-height:32px;overflow:hidden;position:relative;padding:0 0 0 80px;margin:0 0 20px 0;}
.ranklist li em{width:40px;height:32px;overflow:hidden;display:block;position:absolute;left:0;top:0;text-align:center;font-style:normal;color:#fff;}
.ranklist li em{background-color:#3385ff;}
.ranklist li a{font-family: "Microsoft YaHei" ! important;}
.ranklist li.top em{background-color:#DE206E;color:#fff;}
.ranklist li .num{position:absolute;right:0;top:0;color:#999;font-family: "Microsoft YaHei" ! important;}
</style>

<center><h1 style="font-size:35px;color:#ce105e;margin-top:10px;">台州镇杰科技有限公司订单系统</h1></center>
<div class="demo">
<center><h2>大客户专区</h2></center>
    <div class="ranklist" style="height:40px;font-family:'宋体' ! important;">
		<ul>
			<li>
					<em style="background-color:#fff;color:#000;font-size:18px;font-weight:bold;"></em>
					<p>
							<a href="javascript:void(0)">
							<span style="float:left;display:inline-block;width:15%;overflow:hidden;font-size:22px;color:#000;text-align:center;">日期</span>
        					<span style="float:left;display:inline-block;width:25%;overflow:hidden;font-size:22px;color:#000;text-align:center;">客户名称</span>
        					<span style="float:left;display:inline-block;width:25%;overflow:hidden;font-size:22px;color:#000;text-align:center;">商品名称</span>
							<span style="float:left;display:inline-block;width:5%;overflow:hidden;font-size:22px;color:#000;text-align:center;">数量</span>
        					<span style="float:left;display:inline-block;width:30%;overflow:hidden;font-size:22px;color:#000;text-align:center;">备注</span>
        					</a>
					</p>
					<!--<span class="num" style="font-size:22px;color:#000;">数量</span>-->
			</li>			
		</ul>
	</div>
	<div class="ranklist" style="height: 200px;" id="ranklist1">
		<ul id="ordListVip">
			<li class="top">
				<em>01</em><p><a href="http://www.17sucai.com/" target="_blank">js图片左右无缝滚动用鼠标控制图片滚动</a></p><span class="num">32万下载</span>
			</li>
			
		</ul>
	</div>
	<center><h2 style="color:#3366cc">贵宾客户专区</h2></center>
	<div class="ranklist" style="height:40px;font-family:'宋体' ! important;">
		<ul>
			<li>
					<em style="background-color:#fff;color:#000;font-size:18px;font-weight:bold;"></em>
					<p>
							<a href="javascript:void(0)">
								<span style="float:left;display:inline-block;width:15%;overflow:hidden;font-size:22px;color:#000;text-align:center;">日期</span>
								<span style="float:left;display:inline-block;width:25%;overflow:hidden;font-size:22px;color:#000;text-align:center;">客户名称</span>
								<span style="float:left;display:inline-block;width:25%;overflow:hidden;font-size:22px;color:#000;text-align:center;">商品名称</span>
								<span style="float:left;display:inline-block;width:5%;overflow:hidden;font-size:22px;color:#000;text-align:center;">数量</span>
								<span style="float:left;display:inline-block;width:30%;overflow:hidden;font-size:22px;color:#000;text-align:center;">备注</span>
        					</a>
					</p>
					<!--<span class="num" style="font-size:22px;color:#000;">数量</span>-->
			</li>			
		</ul>
	</div>
	<div class="ranklist" id="ranklist2">
		<ul id="ordList">
			<li class="top">
				<em>01</em><p><a href="http://www.17sucai.com/" target="_blank">js图片左右无缝滚动用鼠标控制图片滚动</a></p><span class="num">32万下载</span>
			</li>
			<li class="top">
				<em>02</em><p><a href="http://www.17sucai.com/" target="_blank"><font style="color:#c00">js无缝滚动制作js文字无缝滚动和js图片无缝滚动</font></a></p><span class="num">32万下载</span>
			</li>
			<li class="top">
				<em>03</em><p><a href="http://www.17sucai.com/" target="_blank">jquery 滚动 kxbdSuperMarquee插件支持图片与文字无缝滚动 图片翻滚 焦点图左右切换 banner广告制作</a></p><span class="num">32万下载</span>
			</li>
			
		</ul>
	</div>
	
	
</div>

</body>
</html>

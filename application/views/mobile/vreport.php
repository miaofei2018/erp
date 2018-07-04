<?php if(!defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1.0" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>ERP进销存V8标准版系统</title>
<link href="<?php echo base_url()?>statics/mobile/iconfont/iconfont.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>statics/mobile/css/swiper.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>statics/mobile/css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>statics/mobile/css/index.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>statics/mobile/css/mobiscroll.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>statics/mobile/css/mobiscroll_date.css">
</head>

<body>

<header class="mui-bar-nav" id="header">
    <div style="float:left;width:60px;color:#fff;text-align:center;font-size:16px;line-height:63.97px;vertical-align:middle" onclick="history.go(-1);">&lt;返回</div>
    <div style="float:left;width:calc(100% - 120px);color:#fff;text-align:center;font-size:16px;line-height:63.97px;vertical-align:middle;" id="inoutid">出入库明细</div>
    <div style="float:right;width:60px;color:#fff;text-align:center;font-size:18px;line-height:63.97px;vertical-align:middle" onclick="showSel();">
        <i style="font-size:16px;" class="iconfont icon-filter"></i>
    </div>
</header>
<footer style="position: fixed; background: #FC605A;z-index: 10;height: 50px;font-size:14px;line-height:50px;">
    <span style="display:inline-block;width:30%;text-align: center;color:#fff">总入库：<span id="intotal"></span></span>
    <span style="display:inline-block;width:30%;text-align: center;color:#fff">总出库：<span id="outtotal"></span></span>
    <span style="display:inline-block;width:30%;text-align: center;color:#fff">总结存：<span id="alltotal"></span></span>
</footer>

<div id="container" class="container" style="height:calc(100% - 113.97px)">

  <div class="section" id="soList">
  </div>
  <div class="s_empty" id="noMoreTip">已无更多信息，您可以换一个关键字搜一下哦~</div>
</div>
<section id="pushbutton"></section>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/Adaptive.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/swiper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/jquery.nav.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/mobiscroll_date.js" charset="gb2312"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/mobiscroll.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/date-alert.js"></script>
<script type="text/javascript">

var swiper = new Swiper('.swiper-container', {
	pagination: '.swiper-pagination',
	paginationClickable: true,
	spaceBetween: 30,
});



$(function(){
	$('#nav').onePageNav();
});

</script>
<script> 
Date.prototype.Format = function (fmt) { //author: meizz   
    var o = {  
        "M+": this.getMonth() + 1, //月份   
        "d+": this.getDate(), //日   
        "H+": this.getHours(), //小时   
        "m+": this.getMinutes(), //分   
        "s+": this.getSeconds(), //秒   
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度   
        "S": this.getMilliseconds() //毫秒   
    };  
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));  
    for (var k in o)  
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));  
    return fmt;  
}
var beginDate=new Date().Format("yyyy-MM-dd");
var currentPage=1;
var skey="";
var entrys=[];
$("#inoutid").text("出入库明细-"+beginDate.replace(/-/g,''));
function showSel(){
	$.fn.alert({
        'tip': '选择时间',
        'cancelBtnLbl': '确定',
        'confirmBtnLbl': '取消',
        'otherBtnLbl':'',
        cancelCallback: function() {
            beginDate = $("#selDate").val();
            $("#inoutid").text("出入库明细-"+beginDate.replace(/-/g,''));
        	loadGoods();
        },
        confirmCallback: function() {
        	
        }
    });
}
$(function(){ 
    $("#submitOrder").on('click', function(event){
    	submitOrder();
    });
    loadGoods();
    //滚动条在Y轴上的滚动距离
    /*$(".ft-rt").click(function(){
        alert(1);
    });*/
    $("#container").scroll(function(){
    	var divHeight = $(this).height();
        var nScrollHeight = $(this)[0].scrollHeight;
        var nScrollTop = $(this)[0].scrollTop;
    	//console.info('a:'+divHeight+'b:'+nScrollHeight+'c:'+nScrollTop);
    	
    	if(nScrollTop + divHeight >= nScrollHeight-1) {
  	      //请求数据
  	      debugger;
    		if(currentPage<=1) 
	    		return;
	    	else
	    		loadGoods(currentPage);
  	    }
    	
    	});
        
});
function loadGoods(page){
	var first = !page || (page==1);
	if(first){
		page = 1;
		//skey = $("#searchText").val();
		$("#soList").empty();
		$("#noMoreTip").css('display','none');
	}
	debugger;
	var data = {page:page,rows:5,beginDate:beginDate};
	console.info(data);
	$.ajax({
        type: "post",
        url: "<?php echo base_url()?>index.php/mobile/vreportDetail?a="+Math.random(),
        data: data,
        dataType: "json",
        success: function (result) {
        	if(result.status==200){
            	var data = result.data;
            	var page = data.page;
            	var total = data.total;
            	currentPage = page < total ? (page+1) : 1;
            	(page >= total) &&$("#noMoreTip").css('display','block');
            	var records = data.records;
            	var rows = data.rows;
            	var udata = data.userdata;
            	$("#intotal").text(udata.inqty);
            	$("#outtotal").text(udata.outqty);
            	$("#alltotal").text(udata.totalqty);
            	for(var i in rows){
                	var so = rows[i];
                	$good = $(
                        	'<div style="'+(so.inout==0?';border-top:1px solid rgba(255,0,0,0.3);':'')+'position:relative;width:95%;font-size:14px;padding-left:5px;padding-top:15px;padding-right:5px;height:80px;border-bottom: 1px solid #e5e5e5;">'+
                	        	'<div style="width:100%;height:45px;">'+
                    	        	'<span style="display:inline-block;width:65%;vertical-align: bottom;overflow:hidden;white-space:nowrap;text-overflow: ellipsis;"><i style="font-size:10px;">'+(((page-1)*5)+Number(i)+1)+'</i>.&nbsp;<strong>'+so.invName+'</strong></span>'+
                    	        	'<span style="display:inline-block;width:35%;text-align:right;"><strong>'+so.invNo+'</strong></span>'+
                    	        '</div>'+
                    	        '<div style="width:100%">'+
                    	            '<span style="display:inline-block;width:34%;margin-left:1%;">'+so.transType+'</span>'+
                    	            '<span style="display:inline-block;width:35%;color:#FF5151;">'+'<strong>'+(so.inout == 1 ? '+'+so.inqty : (so.inout == -1 ? '-'+so.outqty : '^'+so.totalqty)) +'（'+(so.inout == 0?'期初':'')+so.location+'）</strong></span>'+//+so.unit
                    	            '<span style="display:inline-block;width:30%;text-align:right;font-family: "microsoft yahei";">'+
                            	            '<strong style="font-size:15px;color:#1B96A9;">结存：'+so.totalqty+'</strong>'+
                        	        '</span>'+
                        	    '</div>'+
                	    	'</div>');
                	$("#soList").append($good);
            	}
        	}else{
        		alert(result.msg);
            }
        },
        error: function () {
            alert("订单加载失败！")
        }
    });
}
function submitOrder(){
	var postData = {};
	postData.id= -1;
}
</script> 

<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/waypoints.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/navbar2.js"></script>
</body>
</html>

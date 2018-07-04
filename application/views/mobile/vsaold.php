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

</head>

<body>

<header class="mui-bar-nav" id="header">
    <div style="float:left;width:80px;color:#fff;text-align:center;font-size:20px;line-height:63.97px;vertical-align:middle" onclick="history.go(-1);">&lt;返回</div>
    <div style="float:left;width:calc(100% - 160px);color:#fff;text-align:center;font-size:21px;line-height:63.97px;vertical-align:middle">历史订单</div>
    <div style="float:right;width:80px;color:#fff;text-align:center;font-size:20px;line-height:63.97px;vertical-align:middle" onclick="showSel();">
        <i style="font-size:23px;" class="iconfont icon-filter"></i>
    </div>
</header>

<div id="container" class="container" style="height:calc(100% - 63.97px)">

  <div class="section" id="soList">
  </div>
  <div class="s_empty" id="noMoreTip">已无更多订单，您可以换一个关键字搜一下哦~</div>
</div>
<section id="pushbutton"></section>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/Adaptive.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/swiper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/jquery.nav.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/lanren-alert.js"></script>
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
var curStatus="";
var currentPage=1;
var skey="";
var entrys=[];
function showSel(){
	$.fn.alert({
        'tip': '选择订单状态',
        'cancelBtnLbl': '待发货',
        'confirmBtnLbl': '已发货',
        'otherBtnLbl':'已回单',
        cancelCallback: function() {
            //取消后的操作
        	curStatus = 1;
        	loadGoods();
        },
        confirmCallback: function() {
			//确认后的操
        	curStatus = 2;
        	loadGoods();
        },
        otherCallback: function() {
			//确认后的操
        	curStatus = 3;
        	loadGoods();
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
		skey = $("#searchText").val();
		$("#soList").empty();
		$("#noMoreTip").css('display','none');
	}
	var data = {page:page,rows:10,skey:skey,curStatus:curStatus,transType:150601};
	$.ajax({
        type: "post",
        url: "<?php echo base_url()?>index.php/mobile/vsaList?a="+Math.random(),
        data: data,
        dataType: "json",
        success: function (result) {
        	if(result.status==200){
            	var data = result.data;
            	var page = data.page;
            	var total = data.total;
            	currentPage = page < total ? (page+1) : 1;
            	(page >= total) && $("#noMoreTip").css('display','block');
            	var records = data.records;
            	var rows = data.rows;
            	for(var i in rows){
                	var so = rows[i];
                	$good = $(
                        	'<div style="position:relative;width:95%;font-size:14px;padding-left:5px;padding-top:15px;padding-right:5px;height:80px;border-bottom: 1px solid #e5e5e5;">'+
                	        	'<div style="width:100%;height:45px;">'+
                    	        	'<span style="display:inline-block;width:70%;"><i style="font-size:10px;">'+(((page-1)*10)+Number(i)+1)+'</i>.&nbsp;订单号：<strong>'+so.billNo+'</strong></span>'+
                    	        	'<span style="display:inline-block;width:30%;text-align:right"><strong>'+so.billDate+'</strong></span>'+
                    	        '</div>'+
                    	        '<div style="width:100%">'+
                    	            '<span style="display:inline-block;width:35%;color:#FF5151;font-family: "microsoft yahei";">¥：<strong style="font-size:15px;">'+so.amount+'</strong>元</span>'+
                    	            '<span style="display:inline-block;width:30%;font-family: "microsoft yahei";">数量：<strong style="font-size:16px;">'+so.totalQty+'</strong></span>'+
                    	            '<span style="display:inline-block;width:35%;text-align:right;font-family: "microsoft yahei";">'+
                    	            	(so.checked==0 ? 
                            	        '<strong style="font-size:15px;color:#449d44">待发货':
                        	            (so.checked == 2 ? '<strong style="font-size:15px;color:#FF5151;">已回单' :
                            	            '<strong style="font-size:15px;color:#1B96A9;">已发货'))+'</strong>'+
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

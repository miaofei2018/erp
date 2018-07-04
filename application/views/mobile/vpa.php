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
<!-- 订单列表 -->
<header class="mui-bar-nav" id="header">
    <?php if($_COOKIE['boss'] == 1){?>
    <div style="float:left;width:80px;color:#fff;text-align:center;font-size:18px;line-height:63.97px;vertical-align:middle" onclick="history.go(-1);">&lt;返回</div>
    <?php }else {?>
    <div onclick="location.href='<?php echo base_url()?>index.php/mobile/center';" style="float:left;width:80px;color:#fff;text-align:center;font-size:18px;line-height:63.97px;vertical-align:middle" onclick="history.go(-1);">
        <i style="display: block;font-size:40px;color: #fafafa;" class="iconfont icon-sort"></i>
    </div>
    <?php }?>
    <div style="float:left;width:calc(100% - 160px);color:#fff;text-align:center;font-size:19px;line-height:63.97px;vertical-align:middle">购货单</div>
    <div id="addOrder" style="float:right;width:40px;color:#fff;text-align:center;font-size:18px;line-height:63.97px;vertical-align:middle">
        <i style="font-size:20px;" class="iconfont icon-add"></i>
    </div>
    <div style="float:right;width:40px;color:#fff;text-align:center;font-size:20px;line-height:63.97px;vertical-align:middle" onclick="showSel();">
        <i style="font-size:20px;" class="iconfont icon-filter"></i>
    </div>
</header>

<div id="container" class="container" style="height:calc(100% - 63.97px)">

  <div class="section" id="soList">
  </div>
  <div class="s_empty" id="noMoreTip">已无更多订单，您可以换一个关键字搜一下哦~</div>
</div>

<!-- 订单详情 -->
<div id="detailView" style="display:none;position: fixed;z-index:100;width:100%;height:100%;background:#fff;font-size: 18px;">
    <div style="background: #FC605A;top: 0;right: 0;left: 0;height: 63.98px;">
        <div style="float:left;width:80px;color:#fff;text-align:center;font-size:18px;line-height:63.97px;vertical-align:middle" onclick="$('#detailView').hide();">&lt;返回</div>
        <div id="detailText" style="float:left;width:calc(100% - 160px);color:#fff;text-align:center;font-size:19px;line-height:63.97px;vertical-align:middle">购货单录入</div>
        <div id="submitOrder" style="float:right;width:80px;color:#fff;text-align:center;font-size:18px;line-height:63.97px;vertical-align:middle">
            <i style="font-size:20px;" class="iconfont icon-xuanze"></i>
        </div>
    </div>
    <div id="soDetail" style="height: calc(100% - 113.98px);overflow:auto;width:100%">
        <div style="border-bottom: 1px solid #e5e5e5;height:60px;width:98%;padding-left:2%;">
            <span style= "display:inline-block;width:20%;color:#868b92;font-size:16px;text-align:left;line-height:60px;vertical-align:middle">
                                                供应商
            </span>
            <span style= "display:inline-block;width:70%;">
                <input readonly="readonly" style="height:60px;width:100%;font-size:16px;border:none;outline: none;" type="text" name="customer" id="customer" value="" />
            </span>
            <span style="display:inline-block;width:5%;color:#868b92;text-align:right">&gt;</span>
        </div>
		<div style="display:none;border-bottom: 1px solid #e5e5e5;height:60px;width:98%;padding-left:2%;">
            <span style= "display:inline-block;width:20%;color:#868b92;font-size:16px;text-align:left;line-height:60px;vertical-align:middle">
                                                销售人员
            </span>
            <span style= "display:inline-block;width:65%;">
                <input readonly="readonly" style="height:60px;width:100%;font-size:16px;border:none;outline: none;" type="text" name="sales" id="sales" value="" />
            </span>
            <span onclick="clearSales();" style="display:inline-block;font-size:15px;width:5%;color:#868b92;text-align:right;">X</span>
            <span onclick="clearSales();" style="display:inline-block;width:5%;color:#868b92;text-align:right;">&gt;</span>
        </div>
        <div style="border-bottom: 1px solid #e5e5e5;height:60px;width:98%;padding-left:2%;">
            <span style= "display:inline-block;width:20%;color:#868b92;font-size:16px;text-align:left;line-height:60px;vertical-align:middle">
                                                商品
            </span>
            <span style= "display:inline-block;width:70%;">
                <input id="good" readonly="readonly" style="height:60px;width:100%;font-size:16px;border:none;outline: none;text-align:right;" type="text" name="good" value="" />
            </span>
            <span style="display:inline-block;width:5%;color:#868b92;text-align:right">&gt;</span>
        </div>
        <div id="soGoods" style="width:98%;padding-left:2%;font-size:13px;">
            <div style="padding-left: 20px;height:30px;line-height:30px;border-bottom: 1px solid #e5e5e5;overflow:hidden;white-space:nowrap;text-overflow: ellipsis;">
                XX001_黄山_金装
            </div>
            <div style="padding-left: 20px;font-size:12px;border-bottom: 1px solid #e5e5e5;">
                <div style="width:100%;">
                  <span style="color:#868b92;display:inline-block;width:45%;">
                                                                      数量:1块
                  </span>
                  <span style="color:#868b92;display:inline-block;width:45%;">
                                                                     仓库：南京仓
                  </span>
                </div>
                <div>
                  <span style="color:#868b92;display:inline-block;width:45%;">
                                                                      折扣率%:50
                  </span>
                  <span style="color:#868b92;display:inline-block;width:45%;">
                                                                     折扣额：￥540
                  </span>
                </div>
                <div>
                  <span style="color:#868b92;display:inline-block;width:45%;">
                                                                      单价:￥540
                  </span>
                  <span style="color:#868b92;display:inline-block;width:45%;">
                                                                     金额：￥540
                  </span>
                </div>
            </div>
        </div>
        <div style="border-bottom: 1px solid #e5e5e5;height:60px;width:98%;padding-left:2%;">
            <span style= "display:inline-block;width:20%;color:#868b92;font-size:16px;text-align:left;line-height:60px;vertical-align:middle">
                                                合计金额
            </span>
            <span style= "display:inline-block;width:75%;">
                <input id="sumAmount" readOnly="readOnly" style="width:100%;font-size:16px;border:none;outline: none;text-align:right;" type="text" name="sumAmount" value="" />
            </span>
        </div>
        <div style="border-bottom: 1px solid #e5e5e5;height:60px;width:98%;padding-left:2%;">
            <span style= "display:inline-block;width:20%;color:#868b92;font-size:16px;text-align:left;line-height:60px;vertical-align:middle">
                                                优惠率%
            </span>
            <span style= "display:inline-block;width:75%;">
                <input id="disCount" style="height:60px;width:100%;font-size:16px;border:none;outline: none;text-align:right;" type="text" name="disCount" value="" />
            </span>
        </div>
        <div style="border-bottom: 1px solid #e5e5e5;height:60px;width:98%;padding-left:2%;">
            <span style= "display:inline-block;width:20%;color:#868b92;font-size:16px;text-align:left;line-height:60px;vertical-align:middle">
                                                优惠金额
            </span>
            <span style= "display:inline-block;width:75%;">
                <input id="disAmount" style="height:60px;width:100%;font-size:16px;border:none;outline: none;text-align:right;" type="text" name="disAmount" value="" />
            </span>
        </div>
        <div style="border-bottom: 1px solid #e5e5e5;height:60px;width:98%;padding-left:2%;">
            <span style= "display:inline-block;width:20%;color:#868b92;font-size:16px;text-align:left;line-height:60px;vertical-align:middle">
                                                备注
            </span>
            <span style= "display:inline-block;width:75%;">
                <input id="description" style="height:60px;width:100%;font-size:16px;border:none;outline: none;text-align:right;" type="text" name="description" value="" />
            </span>
        </div>
    </div>
    <footer style="background: #FC605A;line-height:50px;height: 50px;font-size:14px;">
        <span style="display:inline-block;width:30%;text-align: center;color:#fff">总数量：<span id="totalnum"></span></span>
        <span style="display:inline-block;width:30%;text-align: center;color:#fff">优惠额：<span id="totaldel"></span></span>
        <span style="display:inline-block;width:30%;text-align: center;color:#fff">优后额：<span id="totalamount"></span></span>
    </footer>
</div>
<!-- 选择客户 -->
<div id="cstView" style="display:none;position: fixed;z-index:200;width:100%;height:100%;background:#fff;font-size: 18px;">
    <div style="background: #FC605A;top: 0;right: 0;left: 0;height: 63.98px;">
        <!-- 返回 -->
        <div style="float:left;width:80px;color:#fff;text-align:center;font-size:18px;line-height:63.97px;vertical-align:middle" onclick="$('#cstView').hide();">&lt;返回</div>
        <!-- 搜索框 -->
        <div style="float:left;width:calc(100% - 160px);color:#fff;text-align:center;font-size:19px;line-height:63.97px;vertical-align:middle">
            <input id="cst" style="width:100%;border:none;outline: none;border-radius:1000px;line-height:40px;height:40px;padding-left:15px;font-size: 14px;font-family: 'microsoft yahei'" type="text" value="" placeholder="输入客户查询" />
        </div>
        <!-- 搜索 -->
        <div onclick="loadCstList();" style="float:right;width:80px;color:#fff;text-align:center;font-size:18px;line-height:63.97px;vertical-align:middle">
            <i style="font-size:20px;" class="iconfont icon-search"></i>
        </div>
    </div>
    <div id="cstList" style="height: calc(100% - 63.98px);overflow:auto;width:100%">
    </div>
</div>
<!-- 选择销售人员 -->
<div id="salesView" style="display:none;position: fixed;z-index:200;width:100%;height:100%;background:#fff;font-size: 18px;">
    <div style="background: #FC605A;top: 0;right: 0;left: 0;height: 63.98px;">
        <!-- 返回 -->
        <div style="float:left;width:80px;color:#fff;text-align:center;font-size:18px;line-height:63.97px;vertical-align:middle" onclick="$('#salesView').hide();">&lt;返回</div>
        <!-- 搜索框 -->
        <div style="float:left;width:calc(100% - 160px);color:#fff;text-align:center;font-size:19px;line-height:63.97px;vertical-align:middle">
            <input id="sal" style="width:100%;border:none;outline: none;border-radius:1000px;line-height:40px;height:40px;padding-left:15px;font-size: 14px;font-family: 'microsoft yahei'" type="text" value="" placeholder="输入销售人员查询" />
        </div>
        <!-- 搜索 -->
        <div onclick="loadSalesList();" style="float:right;width:80px;color:#fff;text-align:center;font-size:18px;line-height:63.97px;vertical-align:middle">
            <i style="font-size:20px;" class="iconfont icon-search"></i>
        </div>
    </div>
    <div id="salesList" style="height: calc(100% - 63.98px);overflow:auto;width:100%">
    </div>
</div>

<!-- 选择商品 -->
<div id="goodView" style="display:none;position: fixed;z-index:300;width:100%;height:100%;background:#fff;font-size: 18px;">
    <div style="background: #FC605A;top: 0;right: 0;left: 0;height: 63.98px;">
        <!-- 返回 -->
        <div style="float:left;width:80px;color:#fff;text-align:center;font-size:18px;line-height:63.97px;vertical-align:middle" onclick="$('#goodView').hide();">&lt;返回</div>
        <!-- 搜索框 -->
        <div style="float:left;width:calc(100% - 160px);color:#fff;text-align:center;font-size:19px;line-height:63.97px;vertical-align:middle">
            <input id="goodKey" style="width:100%;border:none;outline: none;border-radius:1000px;line-height:40px;height:40px;padding-left:15px;font-size: 14px;font-family: 'microsoft yahei'" type="text" value="" placeholder="输入商品信息查询" />
        </div>
        <!-- 搜索 -->
        <div onclick="loadGoodList();" style="float:right;width:80px;color:#fff;text-align:center;font-size:18px;line-height:63.97px;vertical-align:middle">
            <i style="font-size:20px;" class="iconfont icon-search"></i>
        </div>
    </div>
    <div id="goodList" style="height: calc(100% - 113.98px);overflow:auto;width:100%">
    </div>
    <footer style="line-height:50px;background-color: #ECECEC;font-family:'microsoft yahei';height: 50px;font-size:18px;">
        <span style="float:left;display:inline-block;width:68%;line-height:50px;height: 50px;background-color: #ECECEC;text-align: left;padding-left:2%;">合计：
            <span style="color: #FF5151;" id="totalOrderAmount">
            0.00
            </span>
            <span style="color: #868B92;">
            (
            <span  id="totalOrderQty">0</span>
                                                    个)
            </span>
        </span>
        <span id="addGood" style="float:left;display:inline-block;width:30%;font-size: 20px;background-color: #39B867;text-align: center;color:#fff">选好了</span>
    </footer><!-- float:left;加上就可以按比例等分了 -->
</div>
<!-- 商品详情 -->
<div id="goodDetailView" style="display:none;position: fixed;z-index:301;width:100%;height:100%;background:#fff;font-size: 18px;">
    <div style="background: #FC605A;top: 0;right: 0;left: 0;height: 63.98px;">
        <div style="float:left;width:80px;color:#fff;text-align:center;font-size:20px;line-height:63.97px;vertical-align:middle" onclick="$('#goodDetailView').hide();">&lt;返回</div>
        <div style="float:left;width:calc(100% - 160px);color:#fff;text-align:center;font-size:21px;line-height:63.97px;vertical-align:middle">商品详情</div>
    </div>
    <div id="goodDetail" style="height: calc(100% - 63.98px);overflow:auto;">
    </div>
</div>
<!-- 选择商品数量 -->
<div id="selGoodView" style="display:none;background-color: rgba(0,0,0,0.5);position:fixed;z-index:999;left:0px;top:0px;width:100%;height:100%;font-size:16px;">
    <div style="background: #fff;width:90%;height:320px;left:5%;top:calc((100% - 360px)/2);position: absolute;border-radius: 5px;">
        <div id="selGood" style="background:#FC605A;height:40px;line-height:40px;color:#fff;text-align:center;border-top-left-radius: 5px;border-top-right-radius: 5px; ">
                                    商品名称
        </div>
        <div style="height:40px;line-height:40px;margin:5px;width:90%;">
            <span style="float:left;display: inline-block;width:30%;text-align:center;">
                                      数量：
            </span>
            <span style="float:left;display: inline-block;width:70%;line-height:40px;height:40px;vertical-align:middle;">
                <input id="selMin" style="float:left;width: 40px;height: 40px;font-size: 0.1rem; border: 1px solid #e5e5e5;text-align: center;color: #A1A09C;background-color: #fff;" type="button" class="minus" value="-">
                <input id="selQty" class="selInput" style="float:left;margin-left:5px;margin-right:5px;width: calc(100% - 92px);height:38px;font-size: 0.1rem; border: 1px solid #e5e5e5;text-align: center;color: #A1A09C;background-color: #fff;" type="text" value="1">
                <input id="selAdd" style="float:right;width: 40px;height: 40px;font-size: 0.1rem; border: 1px solid #e5e5e5;text-align: center;color: #A1A09C;background-color: #fff;" type="button" class="add" value="+">
            </span>
        </div>
        <div style="height:40px;line-height:40px;margin:5px;width:90%;">
            <span style="float:left;display: inline-block;width:30%;text-align:center;">
                                      单价：
            </span>
            <span style="float:left;display: inline-block;width:70%;line-height:40px;height:40px;vertical-align:middle;">
                <input id="selPrice" class="selInput" style="position:relavive;float:left;width: calc(100% - 2px);height: 40px;font-size: 0.1rem; border: 1px solid #e5e5e5;text-align: center;color: #A1A09C;background-color: #fff;" type="text" value="">
            </span>
        </div>
        <div style="height:40px;line-height:40px;margin:5px;width:90%;">
            <span style="float:left;display: inline-block;width:30%;text-align:center;">
                                      金额：
            </span>
            <span style="float:left;display: inline-block;width:70%;line-height:40px;height:40px;vertical-align:middle;">
                <input id="selAmount" class="selInput" style="position:relavive;float:left;width: calc(100% - 2px);height: 40px;font-size: 0.1rem; border: 1px solid #e5e5e5;text-align: center;color: #A1A09C;background-color: #fff;" type="text" value="">
            </span>
        </div>
        <div style="height:40px;line-height:40px;margin:5px;width:90%;">
            <span style="float:left;display: inline-block;width:30%;text-align:center;">
                                      折扣率%：
            </span>
            <span style="float:left;display: inline-block;width:70%;line-height:40px;height:40px;vertical-align:middle;">
                <input id="selDiscount" class="selInput" style="position:relavive;float:left;width: calc(100% - 2px);height: 40px;font-size: 0.1rem; border: 1px solid #e5e5e5;text-align: center;color: #A1A09C;background-color: #fff;" type="text" value="">
            </span>
        </div>
        <div style="height:40px;line-height:40px;margin:5px;width:90%;">
            <span style="float:left;display: inline-block;width:30%;text-align:center;">
                                      折扣额：
            </span>
            <span style="float:left;display: inline-block;width:70%;line-height:40px;height:40px;vertical-align:middle;">
                <input id="selDisAmount" class="selInput" style="position:relavive;float:left;width: calc(100% - 2px);height: 40px;font-size: 0.1rem; border: 1px solid #e5e5e5;text-align: center;color: #A1A09C;background-color: #fff;" type="text" value="">
            </span>
        </div>
        <div style="position:absolute;bottom:0;width:100%;height:40px;line-height:40px;color:#FC605A;text-align:center;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px; ">
            <div id="selOk" style="position: absolute;left:0;width:50%;font-weight:bold;">
                                                 确定
            </div>
            <div style="position: absolute;right:0;width:50%;" onclick="$('#selGoodView').hide();">
                                                取消
            </div>
        </div>
    </div>
</div>

<!-- 信息提示 -->
<div id="msg" style="display:none;border-radius:2px;background-color: rgba(0,0,0,0.9);position:fixed;z-index:999;left:40%;top:40%;width:100px;line-height:40px;height:40px;font-size:14px;color:#fff;text-align:center;">
    操作成功
</div>

<!-- 界面部分结束 -->
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/Adaptive.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/swiper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/jquery.nav.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/lanren-alert.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/jquery.fly.min.js"></script>
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
var curStatus="1";
var currentPage=1;
var currentPageCst=1;
var currentPageSales=1;
var currentPageGood=1;
var skey="";
var entrys=[];
var selGood={};
var canLoaded=true;
var flyObj=null;
var soMap = {};
var cstMap = {};
var salesMap = {};
var goodMap = {};
var order={};
order.entries=[];
function showSel(){
	$.fn.alert({
        'tip': '选择单据状态',
        'cancelBtnLbl': '',
        'confirmBtnLbl': '待审核',
        'otherBtnLbl':'已审核',
        cancelCallback: function() {
            //取消后的操作
        	curStatus = 3;
        	loadSoList();
        },
        confirmCallback: function() {
			//确认后的操
        	curStatus = 1;
        	loadSoList();
        },
        otherCallback: function() {
			//确认后的操
        	curStatus = 2;
        	loadSoList();
        }
    });
}
$(function(){ 
	$("input").on("click",function(){
		var that = this;
	    setTimeout(function(){that.scrollIntoView()},150);
	})
    loadSoList();
    //滚动条
    $("#container").scroll(function(){
    	var divHeight = $(this).height();
        var nScrollHeight = $(this)[0].scrollHeight;
        var nScrollTop = $(this)[0].scrollTop;
    	//console.info('a:'+divHeight+'b:'+nScrollHeight+'c:'+nScrollTop);
    	
    	if(nScrollTop + divHeight >= nScrollHeight-1) {
    		if(!canLoaded) return;
            canLoaded = false;
  	      //请求数据
    		if(currentPage<=1) 
	    		return;
	    	else
	    		loadSoList(currentPage);
  	    }
    });
    $("#cstList").scroll(function(){
    	var divHeight = $(this).height();
        var nScrollHeight = $(this)[0].scrollHeight;
        var nScrollTop = $(this)[0].scrollTop;
    	if(nScrollTop + divHeight >= nScrollHeight-1) {
    		if(!canLoaded) return;
            canLoaded = false;
  	      //请求数据
    		if(currentPageCst<=1) 
	    		return;
	    	else
	    		loadCstList(currentPageCst);
  	    }
    });
	$("#salesList").scroll(function(){
    	var divHeight = $(this).height();
        var nScrollHeight = $(this)[0].scrollHeight;
        var nScrollTop = $(this)[0].scrollTop;
    	if(nScrollTop + divHeight >= nScrollHeight-1) {
    		if(!canLoaded) return;
            canLoaded = false;
  	      //请求数据
    		if(currentPageSales<=1) 
	    		return;
	    	else
	    		loadSalesList(currentPageSales);
  	    }
    });
    $("#goodList").scroll(function(){
    	var divHeight = $(this).height();
        var nScrollHeight = $(this)[0].scrollHeight;
        var nScrollTop = $(this)[0].scrollTop;
    	if(nScrollTop + divHeight >= nScrollHeight-5) {
    		if(!canLoaded) return;
            canLoaded = false;
  	      //请求数据
    		if(currentPageGood<=1) 
	    		return;
	    	else
	    		loadGoodList(currentPageGood);
  	    }
    });
    //绑定事件
    $("#customer").bind('click',function(){
       if(order.checked == 1)return;//add by michen 20171212 for 审核不允许修改
       $('#cstView').show();
       loadCstList();
    });
	$("#sales").bind('click',function(){
	   if(order.checked == 1)return;//add by michen 20171212 for 审核不允许修改
       $('#salesView').show();
       loadSalesList();
    });
    $("#good").bind('click',function(){
    	if(order.checked == 1)return;//add by michen 20171212 for 审核不允许修改
    	order.entries=[];
        $('#goodView').show();
        loadGoodList();
     });
    //校验保证金输入金额是否合法
    $('#disCount').keyup(function(){
    	$(this).val($(this).val().replace(/[^0-9.]/g,''));
    	var msumAmount = Number($("#sumAmount").val());
    	var mdisCount = Number($("#disCount").val());
    	var mdisAmount = Number($("#disAmount").val());
    	mdisAmount = (msumAmount*mdisCount)/100;
    	$("#disAmount").val(mdisAmount.toFixed(2));
    	$("#totaldel").text(mdisAmount.toFixed(2));
    	$("#totalamount").text((msumAmount-mdisAmount).toFixed(2));
    }); 
    $('#disAmount').keyup(function(){
    	$(this).val($(this).val().replace(/[^0-9.]/g,''));
    	var msumAmount = Number($("#sumAmount").val());
    	var mdisCount = Number($("#disCount").val());
    	var mdisAmount = Number($("#disAmount").val());
    	mdisCount = (mdisAmount*100)/msumAmount;
    	$("#disCount").val(mdisCount.toFixed(2));
    	$("#totaldel").text(mdisAmount.toFixed(2));
    	$("#totalamount").text((msumAmount-mdisAmount).toFixed(2));
    }); 
    $('.selInput').keyup(function(){
        var $this = $(this);
        var val = $this.val();
        $this.val(val.replace(/[^0-9.]/g,''));
        var mQty = Number($("#selQty").val());
        var mPrice = Number($("#selPrice").val()); 
        var mAmount = Number($("#selAmount").val()); 
        var mDiscount = Number($("#selDiscount").val()); 
        var mDisAmount = Number($("#selDisAmount").val()); 
        if($(event.target).is("#selQty")||$(event.target).is("#selPrice")){
        	$("#selAmount").val((mQty*mPrice-mDisAmount).toFixed(2));
        }else if($(event.target).is("#selAmount")){
            mQty<=0 && (mQty = 1,$("#selQty").val('1'));
            mPrice = (mAmount+mDisAmount)/mQty;
            mDiscount = (mDisAmount*100)/(mAmount+mDisAmount);
        	$("#selPrice").val(mPrice.toFixed(2));
        	$("#selDiscount").val(mDiscount.toFixed(2));
        }else if($(event.target).is("#selDiscount")){
            mQty<=0 && (mQty = 1,$("#selQty").val('1'));
            mDisAmount = mQty*mPrice*mDiscount/100;
            mAmount = mQty*mPrice - mDisAmount;
        	$("#selDisAmount").val(mDisAmount.toFixed(2));
        	$("#selAmount").val(mAmount.toFixed(2));
        }else if($(event.target).is("#selDisAmount")){
            mQty<=0 && (mQty = 1,$("#selQty").val('1'));
            mDiscount = (mDisAmount*100)/(mQty*mPrice);
            mAmount = mQty*mPrice - mDisAmount;
        	$("#selDiscount").val(mDiscount.toFixed(2));
        	$("#selAmount").val(mAmount.toFixed(2));
        }
    }); 
    $("#selAdd").click(function(){
        $('#selQty').val((parseFloat($('#selQty').val())+1).toFixed(2));
        var mQty = Number($("#selQty").val());
        var mPrice = Number($("#selPrice").val()); 
        var mAmount = Number($("#selAmount").val()); 
        var mDiscount = Number($("#selDiscount").val()); 
        var mDisAmount = Number($("#selDisAmount").val());
        mDisAmount = mQty*mPrice*mDiscount/100;
        mAmount = mQty*mPrice - mDisAmount;
        $("#selAmount").val(mAmount.toFixed(2));
        $("#selDisAmount").val(mDisAmount.toFixed(2));
     });
    $("#selMin").click(function(){
        var val = parseFloat($('#selQty').val());
        if(val<=0) return;
        $('#selQty').val((val-1).toFixed(2));
        var mQty = Number($("#selQty").val());
        var mPrice = Number($("#selPrice").val()); 
        var mAmount = Number($("#selAmount").val()); 
        var mDiscount = Number($("#selDiscount").val()); 
        var mDisAmount = Number($("#selDisAmount").val());
        mDisAmount = mQty*mPrice*mDiscount/100;
        mAmount = mQty*mPrice - mDisAmount;
        $("#selAmount").val(mAmount.toFixed(2));
        $("#selDisAmount").val(mDisAmount.toFixed(2));
     });
    $("#selOk").click(function(){
    	$("#selGoodView").hide();
    	var mQty = Number($("#selQty").val());
        var mPrice = Number($("#selPrice").val()); 
        var mAmount = Number($("#selAmount").val()); 
        var mDiscount = Number($("#selDiscount").val()); 
        var mDisAmount = Number($("#selDisAmount").val()); 
        var good = selGood;
    	var entry={};
        	entry.invId = good.id;
        	entry.invNumber = good.number;
        	entry.invName = good.name;
        	entry.invSpec = good.spec;
        	entry.skuId = -1;
        	entry.skuName = "";
        	entry.unitId = good.unitId;
        	entry.mainUnit = good.unitName;
        	entry.qty = mQty.toFixed(2);
        	entry.price = mPrice.toFixed(2);
        	entry.discountRate = mDiscount.toFixed(2);
        	entry.deduction = mDisAmount.toFixed(2);
        	entry.amount = mAmount.toFixed(2);
        	entry.locationId = good.locationId;
        	entry.locationName = good.locationName;
        	entry.description = "";
        order.entries.push(entry);
    	var totalQty = 0;
        var totalAmount = 0;
    	for(var i in order.entries){
            var entry = order.entries[i];
        	totalQty += Number(entry.qty);
            totalAmount += Number(entry.amount);
    	}
    	//$("#totalOrderAmount").text(totalAmount);
        //$("#totalOrderQty").text(totalQty);
        $("#sumAmount").val(totalAmount);//录单界面合计金额
        $("#totalnum").text(totalQty);//录单界面总数量
        $("#disCount").val(0);//录单界面优惠率
        $("#disAmount").val(0);//录单界面优惠额
    	$("#totaldel").text(0);//录单界面优惠额
    	$("#totalamount").text(totalAmount.toFixed(2));//录单界面优惠后金额
    	addFly(flyObj,totalQty,totalAmount);
     });
    $("#addGood").click(function(){
    	$('#goodView').hide();
        $("#soGoods").empty();
        for(var i in order.entries){
            var entry = order.entries[i];
            $good = $(
                '<div style="padding-left: 20px;height:30px;line-height:30px;border-bottom: 1px solid #e5e5e5;overflow:hidden;white-space:nowrap;text-overflow: ellipsis;">'+
                	entry.invNumber+'_'+entry.invName+'_'+entry.invSpec+
                '</div>'+
                '<div style="padding-left: 20px;font-size:12px;border-bottom: 1px solid #e5e5e5;">'+
                    '<div style="width:100%;">'+
                      '<span style="color:#868b92;display:inline-block;width:45%;">'+
                          '数量:'+entry.qty+entry.mainUnit+
                      '</span>'+
                      '<span style="color:#868b92;display:inline-block;width:45%;">'+
                          '仓库：'+entry.locationName+
                      '</span>'+
                    '</div>'+
                    '<div>'+
                      '<span style="color:#868b92;display:inline-block;width:45%;">'+
                          '折扣率%:'+entry.discountRate+
                      '</span>'+
                      '<span style="color:#868b92;display:inline-block;width:45%;">'+
                          '折扣额：￥'+entry.deduction+
                      '</span>'+
                    '</div>'+
                    '<div>'+
                      '<span style="color:#868b92;display:inline-block;width:45%;">'+
                           '单价:￥'+entry.price+
                      '</span>'+
                      '<span style="color:#868b92;display:inline-block;width:45%;">'+
                           '金额：￥'+entry.amount+
                      '</span>'+
                    '</div>'+
                '</div>'
            );
            $("#soGoods").append($good);
        }
    });
    $("#addOrder").click(function(){
	       loadOrder();
	       $("#detailText").text("购货单录入");
	       $('#detailView').show();
	});
    $('#submitOrder').on('click', function(event){
    	//order.id = data.id;
    	//order.buId = data.buId;
    	//order.contactName = data.contactName;
    	//order.entries = data.entries;
    	order.totalQty = $("#totalnum").text();
    	//order.totalDiscount = data.totalDiscount;
    	order.totalAmount = $("#sumAmount").val();
    	order.description = $("#description").val();
    	order.disRate = $("#disCount").val();
    	order.disAmount = $("#disAmount").val();
    	order.amount = $("#totalamount").text();
    	order.arrears || (order.arrears = order.amount);
    	//order.salesId = data.salesId;
    	//order.salesName = data.salesName;
    	//order.transType = data.transType;
    	$.ajax({
            type: "post",
            url: "<?php echo base_url()?>index.php/mobile/vaddPu",
            data: {postData:order},
            dataType: "json",
            success: function (rtn) {
                if(rtn.status==200){
                	$('#detailView').hide();
                	$("#msg").text('保存成功');
                	$("#msg").show();
                	curStatus = 1;
                	loadSoList();
                	setTimeout(function(){$("#msg").fadeOut();},3000);
                }else{
                	$("#msg").text(rtn.msg);
                	$("#msg").show();
                	setTimeout(function(){$("#msg").fadeOut();},3000);
                }
            },
            error: function () {
                console.log("订单提交失败！")
            }
        });
    	
    	return false;
    });
});
/*初始化函数结束*/
/*自定义函数开始*/
function loadOrder(data){
	if(data){
		order.id = data.id;
    	order.buId = data.buId;
    	order.contactName = data.contactName;
    	order.entries = data.entries;
    	order.totalQty = data.totalQty;
    	order.totalDiscount = data.totalDiscount;
    	order.totalAmount = data.totalAmount;
    	order.description = data.description;
    	order.disRate = data.disRate;
    	order.disAmount = data.disAmount;
    	order.amount = data.amount;
    	order.salesId = data.salesId;
    	order.salesName = data.salesName;
    	order.transType = data.transType;
    	//购货单特有字段
    	order.rpAmount = data.rpAmount;
    	order.arrears = data.arrears;
    	order.accId = data.accId;
    	order.checked = data.checked;
	}else{
    	order.id = -1;
    	order.buId = -1;
    	order.contactName = '';
    	order.entries = [];
    	order.totalQty = '0';
    	order.totalDiscount = "0.00";
    	order.totalAmount = "0.00";
    	order.description = '';
    	order.disRate = "0";
    	order.disAmount = "0";
    	order.amount = "0.00";
    	order.salesId = 0;
    	order.salesName = "";
    	order.transType = "150501";
    	order.rpAmount = "0";
    	order.arrears = 0;
    	order.accId = "0";
    	order.checked = 0;
	}
	//初始化单据
	$("#customer").val(order.contactName);//录单界面客户
	$("#sales").val(order.salesName);//录单界面销售人员
	$("#sumAmount").val(order.totalAmount);//录单界面合计金额
    $("#totalnum").text(order.totalQty);//录单界面总数量
    $("#disCount").val(order.disRate);//录单界面优惠率
    $("#disAmount").val(order.disAmount);//录单界面优惠额
	$("#totaldel").text(order.disAmount);//录单界面优惠额
	$("#totalamount").text(order.amount);//录单界面优惠后金额
	//add by michen 20171212 for 审核不允许修改
	$('#disCount').attr("readonly",false);
	$('#disAmount').attr("readonly",false);
	$('#totaldel').attr("readonly",false);
	if(order.checked == 0){
		$('#disCount').attr("readonly",true);
		$('#disAmount').attr("readonly",true);
		$('#totaldel').attr("readonly",true);
	}
	//add by michen 20171212 for 审核不允许修改
	//初始化明细
	$("#soGoods").empty();
    for(var i in order.entries){
        var entry = order.entries[i];
        $good = $(
            '<div style="padding-left: 20px;height:30px;line-height:30px;border-bottom: 1px solid #e5e5e5;overflow:hidden;white-space:nowrap;text-overflow: ellipsis;">'+
            	entry.invNumber+'_'+entry.invName+'_'+entry.invSpec+
            '</div>'+
            '<div style="padding-left: 20px;font-size:12px;border-bottom: 1px solid #e5e5e5;">'+
                '<div style="width:100%;">'+
                  '<span style="color:#868b92;display:inline-block;width:45%;">'+
                      '数量:'+entry.qty+entry.mainUnit+
                  '</span>'+
                  '<span style="color:#868b92;display:inline-block;width:45%;">'+
                      '仓库：'+entry.locationName+
                  '</span>'+
                '</div>'+
                '<div>'+
                  '<span style="color:#868b92;display:inline-block;width:45%;">'+
                      '折扣率%:'+entry.discountRate+
                  '</span>'+
                  '<span style="color:#868b92;display:inline-block;width:45%;">'+
                      '折扣额：￥'+entry.deduction+
                  '</span>'+
                '</div>'+
                '<div>'+
                  '<span style="color:#868b92;display:inline-block;width:45%;">'+
                       '单价:￥'+entry.price+
                  '</span>'+
                  '<span style="color:#868b92;display:inline-block;width:45%;">'+
                       '金额：￥'+entry.amount+
                  '</span>'+
                '</div>'+
            '</div>'
        );
        $("#soGoods").append($good);
    }
	//自动匹配销售人员
	if(!data)
		$.ajax({
            type: "post",
            url: "<?php echo base_url()?>index.php/mobile/vgetAsales",
            data: {transType:150501},
            dataType: "json",
            success: function (rtn) {
                if(rtn.status==200){
					var sal = rtn.data;
                	$("#sales").val(sal.name);
          	       order.salesId = sal.id;
          	       order.salesName = sal.name;
                }else{
      
                }
            },
            error: function () {
                console.log("自动匹配销售人员失败！")
            }
        });
}
function loadSoList(page){
	var first = !page || (page==1);
	if(first){
		page = 1;
		$("#soList").empty();
		$("#noMoreTip").css('display','none');
	}
	var data = {page:page,rows:10,curStatus:curStatus,transType:150501};
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
                	soMap[so.id] = so;
                	$good = $(
                        	'<div class="soli" soid='+so.id+' style="position:relative;width:95%;font-size:14px;padding-left:5px;padding-top:15px;padding-right:5px;height:80px;border-bottom: 1px solid #e5e5e5;">'+
                	        	'<div style="width:100%;height:45px;">'+
                    	        	'<span style="display:inline-block;width:70%;"><i style="font-size:10px;">'+(((page-1)*10)+Number(i)+1)+'</i>.&nbsp;<strong>'+so.contactName+'</strong></span>'+
                    	        	'<span style="display:inline-block;width:30%;text-align:right"><strong>'+so.billDate+'</strong></span>'+
                    	        '</div>'+
                    	        '<div style="width:100%">'+
                    	            '<span style="display:inline-block;width:35%;">&nbsp;&nbsp;&nbsp;'+(so.userName||'')+'</span>'+//so.salesName
                    	            '<span style="display:inline-block;width:35%;"><strong ><font color=#868b92>共</font><font color=#FF5151>'+so.amount+'元</font><font color=#868b92>('+so.totalQty+'个)</font></strong></span>'+
                    	            '<span style="display:inline-block;width:30%;text-align:right;font-family: "microsoft yahei";">'+
                    	            	(so.checked==0 ? 
                            	        '<strong style="font-size:15px;color:#1B96A9">待审核':
                                	        '<strong style="font-size:15px;color:#FF5151;">已审核'
                                	    )+'</strong>'+
                        	        '</span>'+
                        	    '</div>'+
                	    	'</div>');
                	$("#soList").append($good);
            	}
            	$(".soli").unbind('click').bind('click',function(){
         	       var so = soMap[$(this).attr('soid')];
          	       loadOrder(so);
          	       $("#detailText").text("购货单修改");
          	       $('#detailView').show();
         	    });
        	}else{
        		alert(result.msg);
            }
        	canLoaded = true;
        },
        error: function () {
        	canLoaded = true;
            alert("订单加载失败！")
        }
    });
}

function loadCstList(page){
	var first = !page || (page==1);
	if(first){
		page = 1;
		skey = $("#cst").val();
		$("#cstList").empty();
	}
	var data = {page:page,rows:10,skey:skey,type:10};
	$.ajax({
        type: "post",
        url: "<?php echo base_url()?>index.php/mobile/vcstList?a="+Math.random(),
        data: data,
        dataType: "json",
        success: function (result) {
        	if(result.status==200){
            	var data = result.data;
            	var page = data.page;
            	var total = data.total;
            	currentPageCst = page < total ? (page+1) : 1;
            	var records = data.records;
            	var rows = data.rows;
            	for(var i in rows){
                	var cst = rows[i];
                	cstMap[cst.id] = cst;
                	$cst = $(
                        	'<div class="selCst" cstid='+cst.id+' style="position:relative;width:95%;font-size:16px;padding-left:5px;padding-top:15px;padding-right:5px;height:45px;border-bottom: 1px solid #e5e5e5;">'+
                	        	'<div style="width:100%;height:45px;">'+
                    	        	'<span style="display:inline-block;width:100%;text-align:center;"><i style="font-size:10px;">'+(((page-1)*10)+Number(i)+1)+'</i>.&nbsp;<strong>'+cst.customerType+'_'+cst.number+'_'+cst.name+'</strong></span>'+
                    	        '</div>'+
                	    	'</div>'
                    	    );
                	$("#cstList").append($cst);
            	}
            	(page >= total) && $("#cstList").append('<div class="s_empty" style="display:block">已无更多客户，您可以换一个关键字搜一下哦~</div>');
            	$(".selCst").unbind('click').bind('click',function(){
         	        var cst = cstMap[$(this).attr('cstid')];
         	        $("#customer").val(cst.name);
          	       order.buId = cst.id;
          	       order.contactName = cst.name;
          	       $('#cstView').hide();
         	    });
            }else{
        		alert(result.msg);
            }
        	canLoaded = true;
        },
        error: function () {
        	canLoaded = true;
            alert("客户加载失败！")
        }
    });
}

function loadSalesList(page){
	var first = !page || (page==1);
	if(first){
		page = 1;
		skey = $("#sal").val();
		$("#salesList").empty();
	}
	var data = {page:page,rows:10,skey:skey};
	$.ajax({
        type: "post",
        url: "<?php echo base_url()?>index.php/mobile/vsalesList?a="+Math.random(),
        data: data,
        dataType: "json",
        success: function (result) {
        	if(result.status==200){
            	var data = result.data;
            	var page = data.page;
            	var total = data.total;
            	currentPageSales = page < total ? (page+1) : 1;
            	var records = data.records;
            	var rows = data.rows;
            	for(var i in rows){
                	var sal = rows[i];
                	salesMap[sal.id] = sal;
                	$sal = $(
                        	'<div class="selSales" salid='+sal.id+' style="position:relative;width:95%;font-size:16px;padding-left:5px;padding-top:15px;padding-right:5px;height:45px;border-bottom: 1px solid #e5e5e5;">'+
                	        	'<div style="width:100%;height:45px;">'+
                    	        	'<span style="display:inline-block;width:100%;text-align:center;"><i style="font-size:10px;">'+(((page-1)*10)+Number(i)+1)+'</i>.&nbsp;<strong>'+sal.number+'_'+sal.name+'</strong></span>'+
                    	        '</div>'+
                	    	'</div>'
                    	    );
                	$("#salesList").append($sal);
            	}
            	(page >= total) && $("#salesList").append('<div class="s_empty" style="display:block">已无更多信息，您可以换一个关键字搜一下哦~</div>');
            	$(".selSales").unbind('click').bind('click',function(){
         	        var sal = salesMap[$(this).attr('salid')];
         	        $("#sales").val(sal.name);
          	       order.salesId = sal.id;
          	       order.salesName = sal.name;
          	       $('#salesView').hide();
         	    });
            }else{
        		alert(result.msg);
            }
        	canLoaded = true;
        },
        error: function () {
        	canLoaded = true;
            alert("销售人员加载失败！")
        }
    });
}

function loadGoodList(page){
	var first = !page || (page==1);
	if(first){
		page = 1;
		skey = $("#goodKey").val();
		$("#goodList").empty();
	}
	var data = {page:page,rows:10,skey:skey};
	$.ajax({
        type: "post",
        url: "<?php echo base_url()?>index.php/mobile/getGoods",
        data: data,
        dataType: "json",
        success: function (result) {
        	if(result.status==200){
            	var data = result.data;
            	var page = data.page;
            	var total = data.total;
            	currentPageGood = page < total ? (page+1) : 1;
            	(page == total) && $("#noMoreTip").css('display','block');
            	var records = data.records;
            	var rows = data.rows;
            	for(var i in rows){
                	var good = rows[i];
                	goodMap[good.id] = good;
                	var imgUrl = '<?php echo base_url()?>index.php/mobile/getImageById?id='+good.id;
                	$good = $(
                        	'<div class="prt-lt">'+
                	    		'<div class="lt-lt" goodid="'+good.id+'">'+
                	    			'<img src="'+imgUrl+'">'+
                	    		'</div>'+
                	        	'<div class="lt-ct" goodid="'+good.id+'">'+
                    	        	'<p>'+good.name+'</p>'+
                    	            '<p class="pr">¥<span class="price">'+good.salePrice+'</span></p>'+
                    	        '</div>'+
                    	        '<div class="lt-rt" goodid="'+good.id+'" style="border: none;color: #FF5151;float:left;width:1.2rem;bottom: 0.05rem;height:0.2rem;">'+
                    	        	'<input type="text" readonly="readonly" style="height:0.24rem;width:1.2rem;" class="result" value="'+good.currentQty+'（'+good.unitName+'）">'+
                    	        '</div>'+
                	    	'</div>');
                	$("#goodList").append($good);
            	}
            	(page >= total) && $("#goodList").append('<div class="s_empty" style="display:block">已无更多商品，您可以换一个关键字搜一下哦~</div>');

            	$(".lt-ct").unbind('click').bind('click',function(event){
             		var goodid = $(this).attr('goodid');
             		var good = goodMap[goodid];
             		flyObj = this;
             		selGood = good;
             		$("#selGoodView").show();
             		$("#selQty").val('1');
             		$("#selPrice").val(good.salePrice);
             		$("#selAmount").val(good.salePrice);
             		$("#selDiscount").val('0');
             		$("#selDisAmount").val('0');
             		$("#selGood").text(good.name);
            	});
            	
         		$(".lt-lt").unbind('click').bind('click',function(event){
             		//if($(event.target).is(".lt-ct"))return;
             		//var goodid = $(this).find('.lt-rt').attr('goodid');
         			var goodid = $(this).attr('goodid');
             		var good = goodMap[goodid];
             		$("#goodDetailView").show();
             		$("#goodDetail").empty();
             		var $good = $(
                     		'<div style="height:50px;line-height:60px;font-size:16px;font-family: tahoma,arial,宋体;vertical-align:middle;border-bottom: 1px solid #e5e5e5;color:#a5a5a5">'+
                     			'<span style="display:inline-block;width:80px;text-align:center">商品编号</span>'+
                     			'<span style="display:inline-block;color:#000;font-size:14px;width:calc(100% - 80px);text-align:center;">'+good.number+'</span>'+
                     		'</div>'+
                     		'<div style="height:50px;line-height:60px;font-size:16px;font-family: tahoma,arial,宋体;vertical-align:middle;border-bottom: 1px solid #e5e5e5;color:#a5a5a5">'+
                     			'<span style="display:inline-block;width:80px;text-align:center">名称</span>'+
                     			'<span style="display:inline-block;color:#000;font-size:14px;width:calc(100% - 80px);text-align:center;">'+good.name+'</span>'+
                     		'</div>'+
                     		'<div style="height:50px;line-height:60px;font-size:16px;font-family: tahoma,arial,宋体;;vertical-align:middle;border-bottom: 1px solid #e5e5e5;color:#a5a5a5">'+
                     			'<span style="display:inline-block;width:80px;;text-align:center">规格</span>'+
                     			'<span style="display:inline-block;color:#000;font-size:14px;width:calc(100% - 80px);text-align:center;">'+(good.spec||'')+'</span>'+
                     		'</div>'+
                     		'<div style="height:50px;line-height:60px;font-size:16px;font-family: tahoma,arial,宋体;vertical-align:middle;border-bottom: 1px solid #e5e5e5;color:#a5a5a5">'+
                     			'<span style="display:inline-block;width:80px;;text-align:center">售价</span>'+
                     			'<span style="display:inline-block;color:#000;font-size:14px;width:calc(100% - 80px);text-align:center;">'+(good.salePrice||'')+'</span>'+
                     		'</div>'+
                     		'<div style="height:50px;line-height:60px;font-size:16px;font-family: tahoma,arial,宋体;vertical-align:middle;border-bottom: 1px solid #e5e5e5;color:#a5a5a5">'+
                     			'<span style="display:inline-block;width:80px;;text-align:center">当前库存</span>'+
                     			'<span style="display:inline-block;color:#000;font-size:14px;width:calc(100% - 80px);text-align:center;">'+(good.currentQty||'')+'</span>'+
                     		'</div>'+
                     		'<div style="height:50px;line-height:60px;font-size:16px;font-family: tahoma,arial,宋体;vertical-align:middle;border-bottom: 1px solid #e5e5e5;color:#a5a5a5">'+
                     			'<span style="display:inline-block;width:80px;;text-align:center">单位</span>'+
                     			'<span style="display:inline-block;color:#000;font-size:14px;width:calc(100% - 80px);text-align:center;">'+(good.unitName||'')+'</span>'+
                     		'</div>'+
                     		'<div style="height:50px;line-height:60px;font-size:16px;font-family: tahoma,arial,宋体;vertical-align:middle;border-bottom: 1px solid #e5e5e5;color:#a5a5a5">'+
                     			'<span style="display:inline-block;width:80px;;text-align:center">备注</span>'+
                     			'<span style="display:inline-block;color:#000;font-size:14px;width:calc(100% - 80px);text-align:center;">'+(good.remark||'')+'</span>'+
                     		'</div>'
                     		);
             		$("#goodDetail").append($good);
             		$.ajax({
                        type: "post",
                        url: "<?php echo base_url()?>index.php/mobile/getImagesById",
                        data: {id:good.id},
                        dataType: "json",
                        success: function (rtn) {
                            if(rtn.status==200){
                            	var img= '';
                            	var files = rtn.files;
                            	var locs = rtn.locations;
                            	for(var i in locs){
                            		img += '<div style="height:50px;line-height:60px;font-size:16px;font-family: tahoma,arial,宋体;vertical-align:middle;border-bottom: 1px solid #e5e5e5;color:#a5a5a5">'+
                                     			'<span style="display:inline-block;width:80px;text-align:center">'+locs[i].locationName+'</span>'+
                                     			'<span style="display:inline-block;width:calc(100% - 80px);text-align:center;color:#000;font-size:14px;">'+(locs[i].qty||'0')+'</span>'+
                                     		'</div>'
                            	}
                            	for(var i in files){
                            		img += '<img style="width:100%;" src="'+files[i].url+'"/>'
                            	}
                            	img += '<div class="s_empty" style="display:block;">已无更多图片，您可以换一个商品查看哦~</div>';
                            	$("#goodDetail").append($(img));
                            }else{
                            }
                        },
                        error: function () {
                            console.log("获取图片失败！")
                        }
                    });
             	});
        	}else{
        		alert(result.msg);
            }
        	canLoaded = true;
        },
        error: function () {
        	canLoaded = true;
            alert("商品加载失败！")
        }
    });
}
function clearSales(){
	order.salesId = 0;
	order.salesName = "";
	$("#sales").val("");
}
function addFly(obj,totalQty,totalAmount) {
    var offset = $('#totalOrderAmount').offset();
	var img =$(obj).siblings('div').find('img').attr('src');//获取当前点击图片链接
	var flyer = $('<img style="z-index:300;display: block;width: 50px;height: 50px;" src="'+img+'"/>');//抛物体对象
    flyer.fly({
        start: {
            left: Math.ceil($(window).width()*2/3)-40,//抛物体起点横坐标
            top: Math.ceil($(window).height()*1/3)-20//抛物体起点纵坐标
        },
        end: {
            left: offset.left,//抛物体终点横坐标
            top: offset.top,//抛物体终点纵坐标
            width: 24,
            height: 24,
        },
        onEnd:function(){
            this.destory();
            $("#totalOrderAmount").text(totalAmount);
            $("#totalOrderQty").text(totalQty);
        }
    });
}
</script> 

<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/waypoints.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/navbar2.js"></script>
</body>
</html>

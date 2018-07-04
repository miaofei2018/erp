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
<!-- 购物车 -->
<header class="mui-bar-nav" id="header">
    <a style="float:left;display:inline-block;line-height:40px;height:40px;vertical-align:middle;margin-top: 12px;text-align:center;left:13px;width:57px;" href="javascript:history.go(-1);">
            <i style="display: block;font-size:23px;color: #fafafa;" class="iconfont icon-back"></i>
    </a>
    <div class="top-sch-box">
    
		<div style="float:left;display:inline-block;width:26px;">
            <i class="fdj iconfont icon-search"></i>
		</div>
		<div style="display:inline-block;width:70%;">
            <input class="sch-input mui-input-clear" type="text" name="" id="searchText" placeholder="输入商品编号或名称" />
		</div>
		
	</div>
	<a style="display:inline-block;line-height:40px;height:40px;right:13px;width:75px;text-align: center;vertical-align:middle;font-size:20px;cursor: pointer;color: #fff;background-color: #ff395c;-webkit-border-radius: 100px;border-radius: 100px;position: fixed;top: 13px;z-index: 20;" href="javascript:loadGoods();">搜索</a>
</header>

<div id="container" class="container" style="height: calc(100% - 63.98px);">

  <div class="section" id="goodList">
  	<!-- <div class="prt-lt">
    	<div class="lt-lt"><img src="<?php echo base_url()?>statics/mobile/images/index/prt_1.jpg"></div>
        <div class="lt-ct">
        	<p>商品1</p>
            <p class="pr">¥<span class="price">60.00</span></p>
        </div>
        <div class="lt-rt">
        	<input type="button" class="minus"  value="-">
        	<input type="text" class="result" value="0">
        	<input type="button" class="add" value="+">
        </div>
    </div> -->
  </div>
  <div class="s_empty" id="noMoreTip">已无更多商品，您可以换一个关键字搜一下哦~</div>
</div>
<footer style="display: none">
	<div class="ft-lt">
        <p>合计:<span id="total" class="total">163.00元</span><span class="nm">(<label class="share"></label>个)</span></p>
    </div>
    <div class="ft-rt">
    	<p>选好了</p>
    </div>
</footer>
<!-- 客户下单确认 -->
<div class="cd-user-modal"> 
	<div style="position: absolute;width: 90%;height:60%;min-height:210px;left:5%;top:20%;background: #FFF;cursor: auto;border-radius: 3px;">
    	<div style="height:20%;background: #d2d8d8;color: #809191;font-size:16px;text-align:center;">
        	<div style="padding-top:20px;">
        	       客户下单
        	</div>
    	</div>
    	
    	  <div id="cd-login" style="height:80%;"> <!-- 登录表单 -->
			<form class="cd-form" style="padding:10px" action="<?php echo base_url()?>index.php/mobile/good">
			     <p id="good_def1"  style="font-size:18px;text-align:center;margin:5px auto;">共 
    			     <span id="goodnum" style="color:red">12
    			     </span>件商品，
    			     <sapn id="goodmoney" style="color:red">234
    			     </sapn>元.
			     </p>
				<!--<p class="fieldset" style="margin:20px auto;">
					<label style="top: 20px;" class="image-replace cd-username" for="signin-username">用户名</label>
					<input class="full-width has-padding has-border" id="signin-username" type="text" placeholder="输入用户名">
				</p>

				<p class="fieldset" style="margin:20px auto;">
					<label style="top: 60px;" class="image-replace cd-password" for="signin-password">密码</label>
					<input class="full-width has-padding has-border" id="signin-password" type="text"  placeholder="输入密码">
				</p>

				 <p class="fieldset">
					<input type="checkbox" id="remember-me" checked>
					<label for="remember-me">记住登录状态</label>
				</p> -->
                <p id="good_def2" style="text-align:center;margin:10px auto;"">
					<input class="full-width has-padding has-border" type="text" id="desp"  placeholder="请输入备注">
				</p>
				<p id="good_def3" style="clear:both;font-size:18px;text-align:center;margin-top:10px;">确认下单吗？</p>
				<p id="good_def4" class="fieldset" style="position:static;margin-top:20px auto;">
					<input style="" class="full-width2" type="submit" id="submitOrder" value="确定">
					<input class="full-width3" type="submit" id="submitOrder2" value="取消">
				</p>
				<p id="good_suc1"  style="font-size:18px;text-align:center;margin:5px auto;">
    			     <span id="err_msg" style="color:red">恭喜您！下单成功！可于历史订单中查看！
    			     </span>
			     </p>
			     <p id="good_suc2" class="fieldset" style="position:static;margin-top:20px auto;">
					<input style="" class="full-width4" type="submit" id="submitOrder3" value="确定">
				</p>
			</form>
		</div>
	</div>
</div>

<!-- 订单详情 -->
<div id="detailView" style="position: fixed;z-index:100;width:100%;height:100%;background:#fff;font-size: 18px;">
    <div style="background: #FC605A;top: 0;right: 0;left: 0;height: 63.98px;">
        <div style="float:left;width:80px;color:#fff;text-align:center;font-size:20px;line-height:63.97px;vertical-align:middle" onclick="$('#detailView').hide();">&lt;返回</div>
        <div style="float:left;width:calc(100% - 160px);color:#fff;text-align:center;font-size:21px;line-height:63.97px;vertical-align:middle">商品详情</div>
    </div>
    <div id="goodDetail" style="height: calc(100% - 63.98px);overflow:auto;">
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/Adaptive.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/swiper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/jquery.nav.js"></script>
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
var currentPage=1;
var skey="";
var entrys=[];
var origood = {};
var canLoaded=true;
$(function(){ 
	var $form_modal = $('.cd-user-modal'),
	$form_login = $form_modal.find('#cd-login'),
	$form_modal_tab = $('.cd-switcher'),
	$tab_login = $form_modal_tab.children('li').eq(0).children('a'),
	$main_nav = $('.ft-rt');

    //弹出窗口
    $main_nav.on('click', function(event){
        $("#goodnum").text($(".share").html());
        console.info($(".share").html());
        $("#goodmoney").text($("#total").html());
        $("#good_def1").show();
        $("#good_def2").show();
        $("#good_def3").show();
        $("#good_def4").show();
        $("#good_suc1").hide();
        $("#good_suc2").hide();
    	$form_modal.addClass('is-visible');	
    });
    
    //关闭弹出窗口
    /*$('.cd-user-modal').on('click', function(event){
    	if( $(event.target).is($form_modal) || $(event.target).is('.cd-close-form') ) {
    		$form_modal.removeClass('is-visible');
    	}	
    });*/
    $('#submitOrder').on('click', function(event){
    	$.ajax({
            type: "post",
            url: "<?php echo base_url()?>index.php/mobile/addOrder",
            data: {postData:getPostData()},
            dataType: "json",
            success: function (rtn) {
            	$("#good_def1").hide();
                $("#good_def2").hide();
                $("#good_def3").hide();
                $("#good_def4").hide();
                $("#good_suc1").show();
                $("#good_suc2").show();
                if(rtn.status==200){
                	//$form_modal.removeClass('is-visible');
                	$("#err_msg").text('恭喜您！下单成功！');
                }else{
                    $("#err_msg").text(rtn.msg);
                }
            },
            error: function () {
                console.log("订单提交失败！")
            }
        });
    	
    	return false;
    });
    $('#submitOrder2').on('click', function(event){
    	$form_modal.removeClass('is-visible');
    	return false;
    });
    $('#submitOrder3').on('click', function(event){
    	$form_modal.removeClass('is-visible');
    	return true;
    });
    //使用Esc键关闭弹出窗口
    $(document).keyup(function(event){
    	if(event.which=='27'){
    		$form_modal.removeClass('is-visible');
        }
    });
    $("#detailView").hide();
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
    	
    	if(nScrollTop + divHeight >= nScrollHeight) {
    		if(!canLoaded) return;
            canLoaded = false;
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
		$("#goodList").empty();
		$("#noMoreTip").css('display','none');
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
            	currentPage = page < total ? (page+1) : 1;
            	(page >= total) && $("#noMoreTip").css('display','block');
            	var records = data.records;
            	var rows = data.rows;
            	for(var i in rows){
                	var good = rows[i];
                	origood[good.id] = good;
                	var imgUrl = '<?php echo base_url()?>index.php/mobile/getImageById?id='+good.id;
                	$good = $(
                        	'<div class="prt-lt">'+
                	    		'<div class="lt-lt">'+
                	    			'<img src="'+imgUrl+'">'+
                	    		'</div>'+
                	        	'<div class="lt-ct">'+
                    	        	'<p>'+good.name+'</p>'+
                    	            '<p class="pr">¥<span class="price">'+good.salePrice+'</span></p>'+
                    	        '</div>'+
                    	        '<div class="lt-rt" goodid="'+good.id+'" style="border: none;color: #FF5151;float:left;width:1.2rem;bottom: 0.05rem;height:0.2rem;">'+
                    	        	'<input type="text" style="height:0.24rem;width:1.2rem;" class="result" value="'+good.currentQty+'（'+good.unitName+'）">'+
                    	        '</div>'+
                	    	'</div>');
                	$("#goodList").append($good);
                	
            	}
               	/*$(".add").click(function(){
         	        var t=$(this).parent().find('input[class*=result]'); 
         	        t.val(parseInt(t.val())+1);
         	        setTotal(); 
         	    })
            	$(".minus").click(function(){ 
         	        var t=$(this).parent().find('input[class*=result]'); 
         	        t.val(parseInt(t.val())-1);
         	        if(parseInt(t.val())<0){ 
         	            t.val(0); 
         	        } 
         	   		setTotal(); 
         		})*/
            	$(".add").unbind('click').bind('click',function(){
         	        var t=$(this).parent().find('input[class*=result]'); 
         	        t.val(parseInt(t.val())+1);
         	        setTotal(); 
         	    });
         	     
         	    $(".minus").unbind('click').bind('click',function(){ 
         	        var t=$(this).parent().find('input[class*=result]'); 
         	        t.val(parseInt(t.val())-1);
         	        if(parseInt(t.val())<0){ 
         	            t.val(0); 
         	        } 
         	   		setTotal(); 
         		});

         		$(".prt-lt").unbind('click').bind('click',function(event){
             		if($(event.target).is(".add")||$(event.target).is(".minus"))return;
             		var goodid = $(this).find('.lt-rt').attr('goodid');
             		var good = origood[goodid];
             		$("#detailView").show();
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
         	    setTotal(); 
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
function setTotal(){ 
    var s=0;
    var v=0;
    var n=0;
    entrys = [];
    <!--计算总额--> 
    $(".lt-rt").each(function(){ 
    	var num = parseInt($(this).find('input[class*=result]').val());
    	var price = parseFloat($(this).siblings().find('span[class*=price]').text());
    	if(num>0){
        	var good=origood[$(this).attr('goodid')];
        	var entry={};
        	entry.invId = good.id;
        	entry.invNumber = good.number;
        	entry.invName = good.name;
        	entry.invSpec = good.spec;
        	entry.skuId = -1;
        	entry.skuName = "";
        	entry.unitId = good.unitId;
        	entry.mainUnit = good.unitName;
        	entry.qty = num;
        	entry.price = good.salePrice;
        	entry.discountRate = "0";
        	entry.deduction = "0.00";
        	entry.amount = num*price;
        	entry.locationId = good.locationId;
        	entry.locationName = good.locationName;
        	entry.description = "";
        	entrys.push(entry);
        	s+= num*price; 
        	v += num;
    	}
    });
    
    <!--计算总份数-->
    /*$("input[class*=result]").each(function(){
    	v += parseInt($(this).val());
    });*/
    $(".share").html(v);
    $("#total").html(s.toFixed(2)); 
} 
function getPostData(){
	var data = {};
	data.id= -1;
	data.entries = entrys;
	data.totalQty =  $(".share").html();
	data.totalDiscount = "0.00";
	data.totalAmount = $("#total").html();
	data.description = $("#desp").val();
	data.disRate = "0";
	data.disAmount = "0";
	data.amount = $("#total").html();
	data.salesId = 0;
	data.salesName = "";
	data.transType = "150601";
	return data;
}
</script> 
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/waypoints.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/navbar2.js"></script>
</body>
</html>

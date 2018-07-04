<?php if(!defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1.0" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>台州镇杰商品订购系统</title>
<link href="<?php echo base_url()?>statics/mobile/iconfont/iconfont.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>statics/mobile/css/swiper.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>statics/mobile/css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>statics/mobile/css/index.css">

</head>

<body>

<header class="mui-bar-nav" id="header">
    <a style="float:left;display:inline-block;line-height:40px;height:40px;vertical-align:middle;margin-top: 12px;text-align:center;left:13px;width:57px;" href="<?php echo base_url()?>index.php/mobile/selfs">
            <i style="display: block;font-size:40px;color: #fafafa;" class="iconfont icon-sort"></i>
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

<div id="container" class="container">

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
<footer>
	<div class="ft-lt">
        <p>合计:<span id="total" class="total">163.00元</span><span class="nm">(<label class="share"></label>个)</span></p>
    </div>
    <div class="ft-rt">
    	<p>选好了</p>
    </div>
</footer>

<div class="cd-user-modal"> 
	<div style="position: absolute;width: 90%;height:60%;min-height:220px;left:5%;top:20%;background: #FFF;cursor: auto;border-radius: 3px;">
    	<div style="height:20%;background: #d2d8d8;color: #809191;font-size:16px;text-align:center;">
        	<div style="padding-top:20px;">
        	       客户下单
        	</div>
    	</div>
    	
    	  <div id="cd-login" style="height:80%;"> <!-- 登录表单 -->
			<form class="cd-form" style="padding:10px">
				<p class="fieldset" style="margin:20px auto;">
					<label style="top: 20px;" class="image-replace cd-username" for="signin-username">用户名</label>
					<input class="full-width has-padding has-border" id="signin-username" type="text" placeholder="输入用户名">
				</p>

				<p class="fieldset" style="margin:20px auto;">
					<label style="top: 60px;" class="image-replace cd-password" for="signin-password">密码</label>
					<input class="full-width has-padding has-border" id="signin-password" type="text"  placeholder="输入密码">
				</p>

				<!-- <p class="fieldset">
					<input type="checkbox" id="remember-me" checked>
					<label for="remember-me">记住登录状态</label>
				</p> -->

				<p class="fieldset" style="margin-top:20px auto;">
					<input class="full-width2" type="submit" id="submitOrder" value="下单">
				</p>
			</form>
		</div>
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
$(function(){ 
	var $form_modal = $('.cd-user-modal'),
	$form_login = $form_modal.find('#cd-login'),
	$form_modal_tab = $('.cd-switcher'),
	$tab_login = $form_modal_tab.children('li').eq(0).children('a'),
	$main_nav = $('.ft-rt');

    //弹出窗口
    $main_nav.on('click', function(event){
    	$form_modal.addClass('is-visible');	
    });
    
    //关闭弹出窗口
    $('.cd-user-modal').on('click', function(event){
    	if( $(event.target).is($form_modal) || $(event.target).is('.cd-close-form') ) {
    		$form_modal.removeClass('is-visible');
    	}	
    });
    //使用Esc键关闭弹出窗口
    $(document).keyup(function(event){
    	if(event.which=='27'){
    		$form_modal.removeClass('is-visible');
        }
    });
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
    	console.info('a:'+divHeight+'b:'+nScrollHeight+'c:'+nScrollTop);
    	
    	if(nScrollTop + divHeight >= nScrollHeight-5) {
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
            	(page == total) && $("#noMoreTip").css('display','block');
            	var records = data.records;
            	var rows = data.rows;
            	for(var i in rows){
                	var good = rows[i];
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
                    	        '<div class="lt-rt">'+
                    	        	'<input type="button" class="minus"  value="-">'+
                    	        	'<input type="text" class="result" value="0">'+
                    	        	'<input type="button" class="add" value="+">'+
                    	        '</div>'+
                	    	'</div>');
                	$("#goodList").append($good);
            	}
               	 $(".add").click(function(){
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
         		})
         	    setTotal(); 
        	}else{
        		alert(result.msg);
            }
        },
        error: function () {
            alert("商品加载失败！")
        }
    });
}
function setTotal(){ 
    var s=0;
    var v=0;
    var n=0;
    <!--计算总额--> 
    $(".lt-rt").each(function(){ 
    	s+=parseInt($(this).find('input[class*=result]').val())*parseFloat($(this).siblings().find('span[class*=price]').text()); 
    });
    
    <!--计算总份数-->
    $("input[class*=result]").each(function(){
    	v += parseInt($(this).val());
    });
    $(".share").html(v);
    $("#total").html(s.toFixed(2)); 
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

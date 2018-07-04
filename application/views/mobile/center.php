<!DOCTYPE html>
<html>
    <head>
        <title>注册页面</title>
        <meta charset="utf-8">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta http-equiv="Access-Control-Allow-Origin" content="*">
        <link href="<?php echo base_url()?>statics/mobile/login/css/success.css" type="text/css" rel="stylesheet">
        <link href="<?php echo base_url()?>statics/mobile/login/css/global.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="<?php echo base_url()?>statics/mobile/js/jquery-1.7.1.min.js"></script>
    </head>
    <body onload="load()">
        <div class="success">
            <img style="width:50px;margin-left:calc(50% - 25px);" src="<?php echo base_url()?>statics/mobile/login/images/success.png" />
            <p style="margin:0"><font color=#deb3df><?php echo $_COOKIE['userName']?></font>,<font color=#92cf84>已登陆</font><!-- ,<font color=#ba3537><?php echo $_COOKIE['score']?></font><font color=#e5a785>积分</font> --></p>
            <div class="s_msg">
                <div class="s_title"><span class="s_red">历史订单</span></div>
                <div class="s_title">
                    <span class="s_redlink">
                        <a id="soCount" href="javascript:void(0)" target="_blank">0</a>
                    </span>
                </div>
            </div>
            <div class="login-btn">
                <button class="submit" type="submit" onclick="location.href='<?php echo base_url()?>index.php/mobile/vloginOut'">退出</button>
                <a href="javascript:history.go(-1);"><div class="login-reg"><p>返回</p></div></a>
            </div>
        </div>
        
    </body>
</html>
<script type="text/javascript">
function load()
{
	var soOrSa = "sa";
	$("#soCount").click(function(){
		location.href = "<?php echo base_url()?>index.php/mobile/v"+soOrSa+"old";
	});
	$.ajax({
        type: "post",
        url: "<?php echo base_url()?>index.php/mobile/v"+soOrSa+"Count?a="+Math.random(),
        data: "",
        dataType: "json",
        success: function (result) {
            if(result&&result.status==200){
                $("#soCount").text(result.msg);
            }
        },
        error: function () {
            alert("数量加载失败！")
        }
    });
}
</script>
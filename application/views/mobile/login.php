<!DOCTYPE html>
<html>
<head>
<title>登陆页面</title>
<meta charset="utf-8">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta http-equiv="Access-Control-Allow-Origin" content="*">
<link href="<?php echo base_url()?>statics/mobile/login/css/login.css" type="text/css" rel="stylesheet">
<link href="<?php echo base_url()?>statics/mobile/login/css/global.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url()?>statics/mobile/login/js/login.js"></script>
</head>
<body>
<div class="login">
<div class="login-title"><p>ERP进销存V8标准版</p>
<i></i>
</div>
<form method="post" action="<?php echo base_url()?>index.php/mobile/good">
<div class="login-bar">
<ul>
<li><img src="<?php echo base_url()?>statics/mobile/login/images/login_user.png"><input type="text" class="text" placeholder="请输入用户名" /></li>
<li><img src="<?php echo base_url()?>statics/mobile/login/images/login_pwd.png"><input type="password" class="psd" placeholder="请输入确认密码" /></li>
</ul>
</div>
<div class="login-btn">
<button class="submit" type="submit" id="submit">登陆</button>
</div>
</form>
</div>
</body>
</html>
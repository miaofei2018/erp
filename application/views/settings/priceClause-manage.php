<?php $this->load->view('header');?>

<script type="text/javascript">
var DOMAIN = document.domain;
var WDURL = "";
var SCHEME= "<?php echo sys_skin()?>";
try{
	document.domain = '<?php echo base_url()?>';
}catch(e){
}
//ctrl+F5 增加版本号来清空iframe的缓存的
$(document).keydown(function(event) {
	/* Act on the event */
	if(event.keyCode === 116 && event.ctrlKey){
		var defaultPage = Public.getDefaultPage();
		var href = defaultPage.location.href.split('?')[0] + '?';
		var params = Public.urlParam();
		params['version'] = Date.parse((new Date()));
		for(i in params){
			if(i && typeof i != 'function'){
				href += i + '=' + params[i] + '&';
			}
		}
		defaultPage.location.href = href;
		event.preventDefault();
	}
});
</script>

<style>
body{background: #fff;}
.manage-wrap{margin: 20px auto 10px;width: 300px;}
.manage-wrap .ui-input{width: 200px;font-size:14px;}
</style>
</head>
<body>
<div id="manage-wrap" class="manage-wrap">
	<form id="manage-form" action="#">
		<ul class="mod-form-rows">
			<li class="row-item">
				<div class="label-wrap"><label for="number">编号:</label></div>
				<div class="ctn-wrap"><input type="text" value="" class="ui-input" name="code" id="code"></div>
			</li>
			<li class="row-item">
				<div class="label-wrap"><label for="name">名称:</label></div>
				<div class="ctn-wrap"><input type="text" value="" class="ui-input" name="clauseName" id="clauseName"></div>
			</li>
			<li class="row-item">
				<div class="label-wrap"><label for="name">描述:</label></div>
				<div class="ctn-wrap"><textarea name="description" id="description" class="ui-input" rows="10" cols="50" wrap="off"></textarea>
			</li>
		</ul>
	</form>
</div>
<script src="<?php echo base_url()?>/statics/js/dist/priceClauseManage.js?ver=20140430"></script>
</body>
</html>

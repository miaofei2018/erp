(function() {
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
    $.extend($.fn, {

        //提示框组件
        alert: function(options) {

            var defaults = {
                tip: '',
                cancelBtnLbl: '取消',
                confirmBtnLbl: '确定',
                otherBtnLbl: '其他',
                maskColor: '#000',
                cancelCallback: null,
                confirmCallback: null
            };

            var settings = $.extend(defaults, options || {}),
                $this;

            function initialize() {
                var HTML = '<div style="background:#000;opacity:.5;position:fixed;z-index:999;left:0px;top:0px;width:100%;height:100%;">'+
                		   '</div>'+
                		   '<div style="background-color: #fff;width: 80%;margin: auto;position: fixed;left: 50%;top: 50%;-webkit-transform:translate(-50%,-50%);-moz-transform:translate(-50%,-50%);transform:translate(-50%,-50%);text-align: center;border-radius: 5px;z-index:1000;display:table;">'+
	                		   	'<div style="display:table;width:100%;border-bottom:2px solid #e73268;">'+
		                		   	'<span style="display:table-cell;height:50px;line-height:50px;vertical-align:middle;text-align:center;font-size:16px;color:#e73268;padding-left:10px;">' + 
		                		   		settings.tip + 
		                		   	'</span>'+
	                		   	'</div>'+
	                		   	'<div style="display:table;width:100%;border-bottom:2px solid #e73268;">'+
	                		   		'<span style="display:table-cell;height:50px;line-height:50px;vertical-align:middle;font-size:16px;">' + 
	                		   			'<input style="text-align:center;height: 40px;width: 90%;display: block;padding: 0 10px;line-height: 40px;font-size: 16px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;border: 0px #eee solid;margin: 5px auto;" type="text" name="selDate" id="selDate" readonly class="input" />'+
	                		   		'</span>'+
	                		   	'</div>'+
	                		   	'<div style="display:table;width:100%;">'+
		                		   	'<span style="display:table-cell;height:50px;line-height:50px;vertical-align:middle;font-size:16px;color:#e73268;" id="alertBtn">' + 
		                		   		settings.cancelBtnLbl + 
		                		   	'</span>'+
		                		   	'<span style="display:table-cell;height:50px;line-height:50px;vertical-align:middle;border-left:1px solid #EAEAEA;color:#1B96A9;font-size:16px">' + 
		                		   		settings.confirmBtnLbl + 
		                		   	'</span>'+
	                		   	'</div>'+
                		   	'</div>';
                $this = $(HTML).appendTo($('body'));
                var $btn = $this.children('div:eq(2)');
                $btn.children().eq(0).off('click', cancelBtnClickHandler).on('click', cancelBtnClickHandler);
                $btn.children().eq(1).off('click', confirmBtnClickHandler).on('click', confirmBtnClickHandler);
                var currYear = (new Date()).getFullYear();	
            	var opt={};
            	opt.date = {preset : 'date'};
            	opt.datetime = {preset : 'datetime'};
            	opt.time = {preset : 'time'};
            	opt.default = {
            		theme: 'android-ics light', //皮肤样式
            		display: 'modal', //显示方式 
            		mode: 'scroller', //日期选择模式
            		dateFormat: 'yyyy-mm-dd',
            		lang: 'zh',
            		showNow: true,
            		nowText: "今天",
            		startYear: currYear - 50, //开始年份
            		endYear: currYear + 10 //结束年份
            	};

            	$("#selDate").mobiscroll($.extend(opt['date'], opt['default']));
            	$("#selDate").val(new Date().Format("yyyy-MM-dd"));
            }

            //取消按钮事件
            function cancelBtnClickHandler() {
                if (settings.cancelCallback && typeof settings.cancelCallback == 'function') {
                    settings.cancelCallback();
                }
                $this.remove();
            }

            function confirmBtnClickHandler() {
                if (settings.confirmCallback && typeof settings.confirmCallback == 'function') {
                    settings.confirmCallback();
                }
                $this.remove();
            }
            

            initialize();

        },

    });

})(jQuery)
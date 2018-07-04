
(function() {

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
                confirmCallback: null,
                otherCallback:null
            };

            var settings = $.extend(defaults, options || {}),
                $this;

            function initialize() {
                var HTML = '<div style="background:#000;opacity:.5;position:fixed;z-index:99999;left:0px;top:0px;width:100%;height:100%;">'+
                		   '</div>'+
                		   '<div style="background-color: #fff;width: 80%;margin: auto;position: fixed;left: 50%;top: 50%;-webkit-transform:translate(-50%,-50%);-moz-transform:translate(-50%,-50%);transform:translate(-50%,-50%);text-align: center;border-radius: 5px;z-index:100000;display:table;">'+
	                		   	'<div style="display:table;width:100%;border-bottom:2px solid #e73268;">'+
		                		   	'<span style="display:table-cell;height:50px;line-height:50px;vertical-align:middle;text-align:center;font-size:16px;color:#e73268;padding-left:10px;">' + 
		                		   		settings.tip + 
		                		   	'</span>'+
	                		   	'</div>'+
	                		   	'<div style="display:table;width:100%;">'+
		                		   	'<span style="display:'+(settings.cancelBtnLbl?'table-cell':'none')+';height:50px;line-height:50px;vertical-align:middle;font-size:16px;color:#449d44;" id="alertBtn">' + 
		                		   		settings.cancelBtnLbl + 
		                		   	'</span>'+
		                		   	'<span style="display:'+(settings.confirmBtnLbl?'table-cell':'none')+';height:50px;line-height:50px;vertical-align:middle;border-left:1px solid #EAEAEA;color:#1B96A9;font-size:16px">' + 
		                		   		settings.confirmBtnLbl + 
		                		   	'</span>'+
		                		   	'<span style="display:'+(settings.otherBtnLbl?'table-cell':'none')+';height:50px;line-height:50px;vertical-align:middle;border-left:1px solid #EAEAEA;color:#e73268;font-size:16px">' + 
		                		   		settings.otherBtnLbl + 
		                		   	'</span>'+
	                		   	'</div>'+
                		   	'</div>';
                $this = $(HTML).appendTo($('body'));
                var $btn = $this.children('div:eq(1)');
                $btn.children().eq(0).off('click', cancelBtnClickHandler).on('click', cancelBtnClickHandler);
                $btn.children().eq(1).off('click', confirmBtnClickHandler).on('click', confirmBtnClickHandler);
                $btn.children().eq(2).off('click', otherBtnClickHandler).on('click', otherBtnClickHandler);
            }

            //取消按钮事件
            function cancelBtnClickHandler() {
                $this.remove();
                if (settings.cancelCallback && typeof settings.cancelCallback == 'function') {
                    settings.cancelCallback();
                }
            }

            function confirmBtnClickHandler() {
                $this.remove();
                if (settings.confirmCallback && typeof settings.confirmCallback == 'function') {
                    settings.confirmCallback();
                }
            }
            
            function otherBtnClickHandler(){
            	$this.remove();
                if (settings.otherCallback && typeof settings.otherCallback == 'function') {
                    settings.otherCallback();
                }
            }

            initialize();

        },

    });

})(jQuery)

(function() {

    $.extend($.fn, {

        //提示框组件
        alert: function(options) {

        	var defaults = {
                tip: '选择单据状态',
                maskColor: '#000',
                colors:['#449d44','#1B96A9','#e73268'],
                btnLbl:[['采购订单','购货单', '销货单'],['客户订单','销货单', '销退单']],
                callback:[[null,null, null],[null,null, null]]
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
	                		   	'</div>';
	                		   	for(var i = 0 ; i < settings.btnLbl.length ; i++){
	                		   		var lbl = settings.btnLbl[i];
	                		   		HTML += '<div style="display:table;width:100%;">';
	                		   		for(var j = 0 ; j < lbl.length ; j++){
	                		   			HTML += '<span style="display:'+(lbl[j]?'table-cell':'none')+';width:'+(100/lbl.length)+'%;font-weight:bold;height:60px;line-height:50px;vertical-align:middle;font-size:16px;color:'+settings.colors[i]+';">'; 
	                		   			HTML += lbl[j];
	                		   			HTML += '</span>';
	                		   		}
	                		   		HTML += '</div>';
	                		   	}
            		HTML += '</div>';
                $this = $(HTML).appendTo($('body'));
                for(var i = 0 ; i < settings.btnLbl.length ; i++){
                	var $btn = $this.children('div:eq('+(i+1)+')');
                	var lbl = settings.btnLbl[i];
                	for(var j = 0 ; j < lbl.length ; j++){
                		var callback = settings.callback[i][j];
                		$btn.children().eq(j).off('click',callbackHandler).on('click',callback, callbackHandler);
                	}
                }
            }
            
            function callbackHandler(e) {
            	var callback = e.data;
            	$this.remove();
                if (callback && typeof callback == 'function') {
                	callback();
                }
            }
            initialize();
        },

    });

})(jQuery)
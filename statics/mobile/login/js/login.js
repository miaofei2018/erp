window.onload=function(){
    var aInput=document.getElementsByTagName('input');
    var oUser=aInput[0];
    var oPwd=aInput[1]
    var aI=document.getElementsByTagName('i')[0];
    var sub = document.getElementById("submit");
    sub.onclick = function(){
    	if(oUser.value==""){
            aI.innerHTML='账号不可为空';
            return false;
        }
    	if(oPwd.value==""){
            aI.innerHTML='密码不可为空';
            return false;
        }
    	/*Ajax.post("loginIn",
    			"user=1&pwd=2",
    			function(rtn){
    				alert(rtn);
    			}
    			);*/
    	ajax({ 
    		  type:"POST", 
    		  url:"loginIn", 
    		  dataType:"json", 
    		  data:{user:oUser.value,pwd:oPwd.value}, 
    		  beforeSend:function(){ 
    		    //some js code 
    		  }, 
    		  success:function(rtn){ 
    			  if(rtn.code !=200)
    				  aI.innerHTML= rtn.msg;
    			  else
    				  location.href = rtn.msg;
    		  }, 
    		  error:function(){ 
    		    console.log("error") 
    		  } 
    		})

    	return false;
    }
    
    
    
    //用户名检测
    
    oUser.onfocus=function(){
        aI.innerHTML='';
        oUser.removeAttribute("placeholder");
    }
    
    oUser.onkeyup=function(){
        
    }
    
    oUser.onblur=function(){
    	if(oUser.value==""){
    		oUser.setAttribute("placeholder","账号不可为空");
    	}
       /* var tel = /1[3|4|5|7|8][0-9]\d{8}$/;
        if(!tel.test(this.value)){
            aI.innerHTML='手机号不正确';
        }else if(this.value==""){
            aI.innerHTML='手机号不可为空';
        }*/
    }
    
    //密码检测
    
    oPwd.onfocus=function(){
        oPwd.removeAttribute("placeholder");
    }
    oPwd.onblur=function(){
    	if(oPwd.value==""){
    		oPwd.setAttribute("placeholder","请输入确认密码");
    	}
    }
    
    
}
var Ajax={
	    get: function(url, fn) {
	        var obj = new XMLHttpRequest();  // XMLHttpRequest对象用于在后台与服务器交换数据          
	        obj.open('GET', url, true);
	        obj.onreadystatechange = function() {
	            if (obj.readyState == 4 && obj.status == 200 || obj.status == 304) { // readyState == 4说明请求已完成
	                fn.call(this, obj.responseText);  //从服务器获得数据
	            }
	        };
	        obj.send();
	    },
	    post: function (url, data, fn) {         // datat应为'a=a1&b=b1'这种字符串格式，在jq里如果data为对象会自动将对象转成这种字符串格式
	        var obj = new XMLHttpRequest();
	        obj.open("POST", url, true);
	        obj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  // 添加http头，发送信息至服务器时内容编码类型
	        obj.onreadystatechange = function() {
	            if (obj.readyState == 4 && (obj.status == 200 || obj.status == 304)) {  // 304未修改
	                fn.call(this, obj.responseText);
	            }
	        };
	        obj.send(data);
	    }
	}
function ajax(){ 
	  var ajaxData = { 
	    type:arguments[0].type || "GET", 
	    url:arguments[0].url || "", 
	    async:arguments[0].async || "true", 
	    data:arguments[0].data || null, 
	    dataType:arguments[0].dataType || "text", 
	    contentType:arguments[0].contentType || "application/x-www-form-urlencoded", 
	    beforeSend:arguments[0].beforeSend || function(){}, 
	    success:arguments[0].success || function(){}, 
	    error:arguments[0].error || function(){} 
	  } 
	  ajaxData.beforeSend() 
	  var xhr = createxmlHttpRequest();  
	  xhr.responseType=ajaxData.dataType; 
	  xhr.open(ajaxData.type,ajaxData.url,ajaxData.async);  
	  xhr.setRequestHeader("Content-Type",ajaxData.contentType);  
	  xhr.send(convertData(ajaxData.data));  
	  xhr.onreadystatechange = function() {  
	    if (xhr.readyState == 4) {  
	      if(xhr.status == 200){ 
	        ajaxData.success(xhr.response) 
	      }else{ 
	        ajaxData.error() 
	      }  
	    } 
	  }  
	} 
	  
	function createxmlHttpRequest() {  
	  if (window.ActiveXObject) {  
	    return new ActiveXObject("Microsoft.XMLHTTP");  
	  } else if (window.XMLHttpRequest) {  
	    return new XMLHttpRequest();  
	  }  
	} 
	  
	function convertData(data){ 
	  if( typeof data === 'object' ){ 
	    var convertResult = "" ;  
	    for(var c in data){  
	      convertResult+= c + "=" + data[c] + "&";  
	    }  
	    convertResult=convertResult.substring(0,convertResult.length-1) 
	    return convertResult; 
	  }else{ 
	    return data; 
	  } 
	}

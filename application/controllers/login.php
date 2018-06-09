<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	define('WX_ID','wx7a1edaf7f4b7445f');  
	define('WX_SC','nF78uj4jDsk1EmT4kdG41RY1TAqCiu0eCvX1Si8enag');  	
	define('WX_CODE_URL','https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_userinfo&agentid=2&state=%s#wechat_redirect');  
	define('WX_TOKEN_URL','https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token=%s&code=%s');  
	define('WX_USER_URL','https://qyapi.weixin.qq.com/cgi-bin/user/getuserdetail?access_token=%s');  
	define('WX_ACCESS_TOKEN','https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=%s&corpsecret=%s');
	define('WEB_HOST','http://erp.globalqskj.com/index.php/login/wxLogin');
	define('WEB_HOME','http://erp.globalqskj.com/index.php/home/index');
class Login extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }
	
	public function index(){
	    $data = str_enhtml($this->input->post(NULL,TRUE));
		if (is_array($data)&&count($data)>0) {
			!token(1) && die('token验证失败'); 
			strlen($data['username']) < 1 && die('用户名不能为空'); 
			strlen($data['userpwd']) < 1  && die('密码不能为空'); 
			$user = $this->mysql_model->get_rows('admin','(username="'.$data['username'].'") or (mobile="'.$data['username'].'") ');
			if (count($user)>0) {
			    $user['status']!=1 && die('账号被锁定'); 
				if ($user['userpwd'] == md5($data['userpwd'])) {
					$data['jxcsys']['uid']      = $user['uid'];
					$data['jxcsys']['name']     = $user['name'];
					$data['jxcsys']['roleid']   = $user['roleid'];
					$data['jxcsys']['username'] = $user['username'];
					$data['jxcsys']['login']    = 'jxc'; 
					if (isset($data['ispwd']) && $data['ispwd'] == 1) {
					    $this->input->set_cookie('username',$data['username'],3600000); 
						$this->input->set_cookie('userpwd',$data['userpwd'],3600000); 
					} 
					$this->input->set_cookie('ispwd',$data['ispwd'],3600000);
					$this->session->set_userdata($data); 
					$this->common_model->logs('登陆成功 用户名：'.$data['username']);
					die('1'); 
			   }		
			}
			die('账号或密码错误');
		} else {
		    $this->load->view('login',$data);
		}
	}
	
	public function wxIndex(){
	    $codeUrl = WX_CODE_URL;  
		$codeUrl = sprintf($codeUrl,WX_ID, urlencode(WEB_HOST),'gerinn');  
		header("Location:".$codeUrl); 
	}
	
	public function wxLogin(){
		if(isset($_GET['code'])){//获取到code  
			$token = getAccessToken(WX_ID,WX_SC);//获取toekn
			$tokenUrl = sprintf(WX_TOKEN_URL,$token,$_GET['code']);//组装URL获取user_ticket  
			$tokenStr = file_get_contents($tokenUrl);  
			$tokenArr = json_decode($tokenStr,true);  
			if(isset($tokenArr['user_ticket'])){  
				 $userUrl = sprintf(WX_USER_URL,$token);//组装URL获取用户信息  
				 $post['user_ticket'] = $tokenArr['user_ticket'];  
				 $userStr = httpPost($userUrl, json_encode($post));  
				 $userArr = json_decode($userStr,true); 
				 if($userArr['errcode']>0){  
					echo '<script>alert("'.$tokenArr['errmsg'].'");window.location.href="./index.php"</script>';  
				 }else{  
					$userid = $userArr['userid'];  
					$username = $userArr['name'];  
					$userimg = $userArr['avatar'];  
					$user = $this->mysql_model->get_rows('admin','(username="'.$userid.'") or (mobile="'.$userid.'") ');
					$data['jxcsys']['uid']      = $user['uid'];
					$data['jxcsys']['name']     = $user['name'];
					$data['jxcsys']['roleid']   = $user['roleid'];
					$data['jxcsys']['username'] = $user['username'];
					$data['jxcsys']['login']    = 'jxc'; 
					if (isset($data['ispwd']) && $data['ispwd'] == 1) {
					    $this->input->set_cookie('username',$data['username'],3600000); 
						$this->input->set_cookie('userpwd',$data['userpwd'],3600000); 
					} 
					$this->input->set_cookie('ispwd',$data['ispwd'],3600000);
					$this->session->set_userdata($data); 
					$this->common_model->logs('登陆成功 用户名：'.$data['username']);
					header("Location:".WEB_HOME);  
				 }  
			}else{//没有获取user_ticket两种情况 1出错2非成员  
				if($tokenArr['errcode']>0){  
				  echo '<script>alert("'.$tokenArr['errmsg'].'");window.location.href="./index.php"</script>';  
				}else{  
				  echo "<script>alert('你非企业号成员');WeixinJSBridge.call('closeWindow');</script>";  
				}  
			} 
		}
	}
	
	
	public function out(){
	    $this->session->sess_destroy();
		redirect(site_url('login'));
	}
	
	public function code(){
	    $this->load->library('lib_code');
		$this->lib_code->image();
	}

}

	function getAccessToken($corpid,$secrect) {  
        $data = json_decode(file_get_contents("access_token.json"));  
        if ($data->expire_time < time()) {  
			$url = sprintf(WX_ACCESS_TOKEN,$corpid,$secrect);			
            $res = json_decode(httpGet($url));  
            $access_token = $res->access_token;  
            if ($access_token) {  
              $data->expire_time = time() + 6000;  
              $data->access_token = $access_token;  
              $fp = fopen("access_token.json", "w");  
              fwrite($fp, json_encode($data));  
              fclose($fp);  
            }  
        } else {  
            $access_token = $data->access_token;  
        }  
        return $access_token;  
    }  
    function httpGet($url) { 
        $curl = curl_init();  
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);   
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  
        curl_setopt($curl, CURLOPT_URL, $url);  
  
        $res = curl_exec($curl);  
        curl_close($curl);  
        return $res;  
    }  
    function httpPost($url,$data_string){  
        $ch = curl_init($url);  
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
          'Content-Type: application/json',  
          'Content-Length: ' . strlen($data_string))  
        );  
        $result = curl_exec($ch);  
        return $result;  
    }  
	
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
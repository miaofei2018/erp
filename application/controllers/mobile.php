<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mobile extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }
	 
	public function login(){
	    $user = get_cookie('user');
	    $pwd = get_cookie('pwd');//die($user.$pwd);
	    if(!empty($user) && !empty($pwd)){
	        $list = $this->getUser($user,$pwd);
	        if(count($list)>0){
	            $data = reset($list);
	            $this->input->set_cookie('user',$data['number'],3600000);
	            $this->input->set_cookie('pwd',$data['passWord'],3600000);
	            $this->input->set_cookie('userName',$data['name'],3600000);
	            $this->input->set_cookie('deptId',$data['deptId'],3600000);
	            $this->input->set_cookie('deptName',$data['deptName'],3600000);
	            $this->input->set_cookie('score',$data['score'],3600000);
	            redirect('mobile/good','refresh');
	        }
	    }
	    $this->load->view('mobile/login',NULL);
	}
	
	public function loginIn(){
	    $user = str_enhtml($this->input->get_post('user',TRUE));
	    $pwd = str_enhtml($this->input->get_post('pwd',TRUE));
	    $list = $this->getUser($user,$pwd);
	    if(count($list)>0){
	        $data = reset($list);
	        $this->input->set_cookie('user',$data['number'],3600000);
	        $this->input->set_cookie('pwd',$data['passWord'],3600000);
	        $this->input->set_cookie('userName',$data['name'],3600000);
	        $this->input->set_cookie('deptId',$data['deptId'],3600000);
	        $this->input->set_cookie('deptName',$data['deptName'],3600000);
	        $this->input->set_cookie('score',$data['score'],3600000);
	        $rtn['code'] = '200';
	        $rtn['msg'] = 'good';
	    }else{
	        $rtn['code'] = '-1';
	        $rtn['msg'] = '账号或密码错误';
	    }
	    die(json_encode($rtn));
	}
	
	public function loginOut(){
	    $this->input->set_cookie('user','',3600000);
	    $this->input->set_cookie('pwd','',3600000);
	    redirect('mobile/login','refresh');
	}
	
	public function selfs(){
	    $this->load->view('mobile/self',NULL);
	}
	
	public function bigCust(){
	    $this->load->view('mobile/bigCust',NULL);
	}
	
	public function good(){
	    $user = get_cookie('user');
	    $pwd = get_cookie('pwd');//die($user.$pwd);
	    if(empty($user)||empty($pwd)){
	        $this->load->view('mobile/login',NULL);return;
	    }
	    $this->load->view('mobile/good',NULL);
	}
	
	public function invoice(){
	    $this->load->view('mobile/invoice',NULL);
	}
	
	
	//商品列表
	public function getGoods() {
	    $page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),10);
	    $skey = str_enhtml($this->input->get_post('skey',TRUE));
	    $where = '(a.isDelete=0)';
	    $where .= $skey ? ' and (name like "%'.$skey.'%" or number like "%'.$skey.'%" or spec like "%'.$skey.'%")' : '';
	    $list = $this->data_model->get_goods($where.' order by a.id desc limit '.$rows*($page-1).','.$rows);
	    foreach ($list as $arr=>$row) {
	        $v[$arr]['amount']        = (float)$row['iniamount'];
	        $v[$arr]['barCode']       = $row['barCode'];
	        $v[$arr]['categoryName']  = $row['categoryName'];
	        $v[$arr]['currentQty']    = $row['totalqty'];                            //当前库存
	        $v[$arr]['delete']        = intval($row['disable'])==1 ? true : false;   //是否禁用
	        $v[$arr]['discountRate']  = 0;
	        $v[$arr]['id']            = intval($row['id']);
	        $v[$arr]['isSerNum']      = intval($row['isSerNum']);
	        $v[$arr]['josl']          = $row['josl'];
	        $v[$arr]['name']          = $row['name'];
	        $v[$arr]['number']        = $row['number'];
	        $v[$arr]['pinYin']        = $row['pinYin'];
	        $v[$arr]['locationId']    = intval($row['locationId']);
	        $v[$arr]['locationName']  = $row['locationName'];
	        $v[$arr]['locationNo']    = '';
	        $v[$arr]['purPrice']      = $row['purPrice'];
	        $v[$arr]['quantity']      = $row['iniqty'];
	        $v[$arr]['salePrice']     = $row['salePrice'];
	        $v[$arr]['skuClassId']    = $row['skuClassId'];
	        $v[$arr]['spec']          = $row['spec'];
	        $v[$arr]['unitCost']      = $row['iniunitCost'];
	        $v[$arr]['unitId']        = intval($row['unitId']);
	        $v[$arr]['unitName']      = $row['unitName'];
	        $v[$arr]['remark']        = $row['remark'];
	        	
	    }
	    $json['status'] = 200;
	    $json['msg']    = 'success';
	    $json['data']['page']      = $page;
	    $json['data']['records']   = $this->data_model->get_goods($where,3);
	    $json['data']['total']     = ceil($json['data']['records']/$rows);
	    $json['data']['rows']      = isset($v) ? $v :'';
	    die(json_encode($json));
	}
	
	//获取图片信息
	public function getImage() {
	    $id = intval($this->input->get_post('pid',TRUE));
	    $data = $this->mysql_model->get_rows('goods_img',array('id'=>$id));
	    if (count($data)>0) {
	        $url     = './data/upfile/goods/'.$data['name'];
	        $info    = getimagesize($url);
	        $imgdata = fread(fopen($url,'rb'),filesize($url));
	        header('content-type:'.$info['mime'].'');
	        echo $imgdata;
	    }
	}
	//获取图片信息
	public function getImageById() {
	    $id = intval($this->input->get('id',TRUE));
	    $data = $this->mysql_model->get_rows('goods_img',array('isDelete'=>0,'invId'=>$id));
	    //die(var_export($data,true));
	    if (count($data)>0) {
	        $url     = './data/upfile/goods/'.$data['name'];
	        $info    = getimagesize($url);
	        $imgdata = fread(fopen($url,'rb'),filesize($url));
	        header('content-type:'.$info['mime'].'');
	        echo $imgdata;
	    }else{
	        $url = './statics/mobile/images/no.png';
	        $info    = getimagesize($url);
	        $imgdata = fread(fopen($url,'rb'),filesize($url));
	        header('content-type:'.$info['mime'].'');
	        echo $imgdata;
	    }
	}
	
	//获取图片信息
	public function getImagesById() {
	    $id = intval($this->input->post('id',TRUE));
	    $list = $this->mysql_model->get_results('goods_img',array('isDelete'=>0,'invId'=>$id));
	    foreach ($list as $arr=>$row) {
	        $v[$arr]['pid']          = $row['id'];
	        $v[$arr]['status']       = 1;
	        $v[$arr]['name']         = $row['name'];
	        $v[$arr]['url']          = site_url().'/mobile/getImage?action=getImage&pid='.$row['id'];
	        $v[$arr]['thumbnailUrl'] = site_url().'/mobile/getImage?action=getImage&pid='.$row['id'];
	        $v[$arr]['deleteUrl']    = '';
	        $v[$arr]['deleteType']   = '';
	    }
	    $list = $this->data_model->get_inventory('(a.isDelete=0) and (a.invId='.$id.')'.' GROUP BY a.invId,a.locationId ');
	    foreach ($list as $arr=>$row) {
	        $s[$arr]['assistName']    = $row['categoryName'];
	        $s[$arr]['invSpec']       = $row['invSpec'];
	        $s[$arr]['locationId']    = intval($row['locationId']);
	        $s[$arr]['skuName']       = '';
	        $s[$arr]['qty']           = (float)$row['qty'];
	        $s[$arr]['locationName']  = $row['locationName'];
	        $s[$arr]['assistId']      = 0;
	        $s[$arr]['invCost']       = 0;
	        $s[$arr]['unitName']      = $row['unitName'];
	        $s[$arr]['skuId']         = 0;
	        $s[$arr]['invId']         = intval($row['invId']);
	        $s[$arr]['invNumber']     = $row['invNumber'];
	        $s[$arr]['invName']       = $row['invName'];
	    }
	    $json['status'] = 200;
	    $json['msg']    = 'success';
	    $json['files']  = isset($v) ? $v : array();
	    $json['locations']  = isset($s) ? $s : array();
	    die(json_encode($json));
	}
	
	private function getUser($user,$pwd){
	    $sql = 'select
					a.*,b.name as deptName
				from '.$this->db->dbprefix('staff').' as a
				left join '.$this->db->dbprefix('contact').' as b on b.id=a.deptId
				where a.isDelete=0 and a.deptId<>0 and a.number="'.$user.'" and a.passWord="'.$pwd.'"';
	    $list = $this->mysql_model->query($sql,2);
	    return $list;
	}
	
	public function soList(){
	    $page = max(intval($this->input->get_post('page',TRUE)),1);
	    $rows = max(intval($this->input->get_post('rows',TRUE)),10);
	    $skey = str_enhtml($this->input->get_post('skey',TRUE));
	    $user = strval($_COOKIE['user']);
	    $where = 'a.isDelete=0 and a.billType="SALE"';
	    $where .= ' and a.transType=150601 and a.userName="'.$user.'"';
	    $offset = $rows * ($page-1);
	    $list = $this->data_model->get_order($where.' order by a.id desc limit '.$offset.','.$rows);
	    foreach ($list as $arr=>$row) {
	        $v[$arr]['checkName']    = $row['checkName'];
	        $v[$arr]['checked']      = intval($row['checked']);
	        $v[$arr]['salesId']      = intval($row['salesId']);
	        $v[$arr]['salesName']    = $row['salesName'];
	        $v[$arr]['billDate']     = $row['billDate'];
	        $v[$arr]['deliveryDate'] = $row['deliveryDate'];
	        $v[$arr]['billStatus']   = intval($row['billStatus']);
	        $v[$arr]['billStatusName']  = intval($row['billStatus'])==2 ? '全部出库' :'未出库';
	
	        $v[$arr]['totalQty']     = (float)$row['totalQty'];
	        $v[$arr]['id']           = intval($row['id']);
	        $v[$arr]['amount']       = (float)abs($row['amount']);
	
	        $v[$arr]['transType']    = intval($row['transType']);
	        $v[$arr]['rpAmount']     = (float)abs($row['rpAmount']);
	        $v[$arr]['contactName']  = $row['contactName'];
	        $v[$arr]['description']  = $row['description'];
	        $v[$arr]['billNo']       = $row['billNo'];
	        $v[$arr]['totalAmount']  = (float)abs($row['totalAmount']);
	        $v[$arr]['userName']     = $row['userName'];
	        $v[$arr]['transTypeName']= $row['transTypeName'];
	    }
	    $data['status'] = 200;
	    $data['msg']    = 'success';
	    $data['data']['page']        = $page;
	    $data['data']['records']   = $this->data_model->get_order($where,3);
	    $data['data']['total']     = ceil($data['data']['records']/$rows);
	    $data['data']['rows']      = isset($v) ? $v : array();
	    die(json_encode($data));
	}
	
	public function soCount(){
	    $user = strval($_COOKIE['user']);
	    $this->common_model->logs('a'.$user.'b');
	    $where = '(isDelete=0) and (billType="SALE")';
	    $where .= ' and (transType=150601) and (userName="'.$user.'")';
	    $count = $this->mysql_model->get_count('order',$where);
	    $data['status'] = 200;
	    $data['msg']    = strval($count);
	    die(json_encode($data));
	}
	
	//公共验证
	private function validform($data) {
	    $data['id']              = isset($data['id']) ? intval($data['id']) : 0;
	    $data['buId']            = intval($data['buId']);
	    $data['salesId']         = intval($data['salesId']);
	    $data['billType']        = 'SALE';
	    $data['billDate']        = $data['date'];
	    $data['transType']       = intval($data['transType']);
	    $data['transTypeName']   = $data['transType']==150601 ? '订货' : '退货';
	    $data['description']     = $data['description'];
	    $data['totalQty']        = (float)$data['totalQty'];
	    $data['totalTax']        = isset($data['totalTax']) ? (float)$data['totalTax'] : 0;
	    $data['totalTaxAmount']  = isset($data['totalTaxAmount']) ? (float)$data['totalTaxAmount'] : 0;
	    $data['amount']          = $data['transType']==150601 ? abs($data['amount']) : -abs($data['amount']);
	    $data['totalAmount']     = $data['transType']==150601 ? abs($data['totalAmount']) : -abs($data['totalAmount']);
	    $data['disRate']        = (float)$data['disRate'];
	    $data['disAmount']      = (float)$data['disAmount'];
	    $data['totalDiscount']  = (float)$data['totalDiscount'];
	    $data['uid']            = 0;
	    $data['userName']       = $_COOKIE['user'];
	    $data['modifyTime']     = date('Y-m-d H:i:s');
	
	    //修改的时候
	    if ($data['id']>0) {
	        $invoice = $this->mysql_model->get_rows('order',array('id'=>$data['id'],'billType'=>'SALE','isDelete'=>0));
	        count($invoice)<1 && str_alert(-1,'单据不存在、或者已删除');
	        $data['checked'] = $invoice['checked'];
	        $data['billNo']  = $invoice['billNo'];
	    } else {
	        $data['billNo']  = str_no('XSDD');
	    }
	
	    $data['disRate'] < 0  && str_alert(-1,'折扣率要为数字，请输入有效数字！');
	    abs($data['amount']) < abs($data['disAmount']) && str_alert(-1,'折扣额不能大于合计金额！');
	    
	    //数据验证
	    if (is_array($data['entries'])) {
	        count($data['entries']) < 1 && str_alert(-1,'提交的是空数据');
	    } else {
	        str_alert(-1,'提交的是空数据');
	    }

	    //供应商验证
	    $this->mysql_model->get_count('contact','(id='.intval($data['buId']).')')<1 && str_alert(-1,'客户不存在');
	    	
	    //商品录入验证
	    $storage   = array_column($this->mysql_model->get_results('storage','(disable=0)'),'id');
	    foreach ($data['entries'] as $arr=>$row) {
	        intval($row['invId'])<1 && str_alert(-1,'请选择商品');
	        (float)$row['qty'] < 0  && str_alert(-1,'商品数量要为数字，请输入有效数字！');
	        (float)$row['price'] < 0  && str_alert(-1,'商品销售单价要为数字，请输入有效数字！');
	        (float)$row['discountRate'] < 0  && str_alert(-1,'折扣率要为数字，请输入有效数字！');
	        intval($row['locationId']) < 1 && str_alert(-1,'请选择相应的仓库！');
	        !in_array($row['locationId'],$storage) && str_alert(-1,$row['locationName'].'不存在或不可用！');
	    }
	    $data['postData'] = serialize($data);
	    return $data;
	
	}
	
	public function addOrder(){
	    $data = $this->input->post('postData',TRUE);
	    $data['buId'] = $_COOKIE['deptId'];
	    $data['contactName'] = $_COOKIE['deptName'];
	    $data['date'] = date('Y-m-d');
	    $data['deliveryDate'] = date('Y-m-d');
	    $data['billNo'] = str_no('XSDD');
	    if (count($data)>0) {
			$data = $this->validform($data);
			$info = elements(array(
				'billNo','billType','transType','transTypeName','buId',
				'billDate','description','totalQty','amount','rpAmount','totalAmount',
				'hxStateCode','totalArrears','disRate','disAmount','postData',
				'salesId','uid','userName','accId','deliveryDate','modifyTime'),$data);
			$this->db->trans_begin();
			$iid = $this->mysql_model->insert('order',$info);
			$this->invso_info($iid,$data);
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误或者提交的是空数据'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('新增销货 单据编号：'.$data['billNo']);
				str_alert(200,'success',array('id'=>intval($iid))); 
			}
		}
		str_alert(-1,'提交的是空数据'); 
	}
	
	private function invso_info($iid,$data) {
	    foreach ($data['entries'] as $arr=>$row) {
	        $v[$arr]['iid']           = $iid;
	        $v[$arr]['billNo']        = $data['billNo'];
	        $v[$arr]['billDate']      = $data['billDate'];
	        $v[$arr]['buId']          = $data['buId'];
	        $v[$arr]['transType']     = $data['transType'];
	        $v[$arr]['transTypeName'] = $data['transTypeName'];
	        $v[$arr]['billType']      = $data['billType'];
	        $v[$arr]['salesId']       = $data['salesId'];
	        $v[$arr]['invId']         = intval($row['invId']);
	        $v[$arr]['skuId']         = intval($row['skuId']);
	        $v[$arr]['unitId']        = intval($row['unitId']);
	        $v[$arr]['locationId']    = intval($row['locationId']);
	        $v[$arr]['qty']           = $data['transType']==150601 ? -abs($row['qty']) :abs($row['qty']);
	        $v[$arr]['amount']        = $data['transType']==150601 ? abs($row['amount']) :-abs($row['amount']);
	        $v[$arr]['price']         = abs($row['price']);
	        $v[$arr]['discountRate']  = $row['discountRate'];
	        $v[$arr]['deduction']     = $row['deduction'];
	        $v[$arr]['description']   = $row['description'];
	        $v[$arr]['uid']           = $data['uid'];
	    }
	    if (isset($v)) {
	        if (isset($data['id']) && $data['id']>0) {
	            $this->mysql_model->delete('order_info','(iid='.$iid.')');
	        }
	        $this->mysql_model->insert('order_info',$v);
	    }
	}
	
	public function getBigOrder(){
	    $where = 'a.isDelete=0 and a.billType="SALE"';
	    $where .= ' and a.transType=150601 and a.checked=0';
	    $list = $this->data_model->get_order($where.' order by a.id desc ');
	    foreach ($list as $arr=>$row) {
			$good = $this->mysql_model->get_rows('order_info',array('iid'=>$row['id']));
			$sql = 'select
					a.*,b.name as goodName
				from '.$this->db->dbprefix('order_info').' as a
				left join '.$this->db->dbprefix('goods').' as b on b.id=a.invId
				where a.isDelete=0 and a.iid="'.$row['id'].'"';
	        $good = $this->mysql_model->query($sql,1);
	        $v[$arr]['goodName']    = $good['goodName'];
			$v[$arr]['contactLevel']    = $row['contactLevel'];
	        $v[$arr]['checkName']    = $row['checkName'];
	        $v[$arr]['checked']      = intval($row['checked']);
	        $v[$arr]['salesId']      = intval($row['salesId']);
	        $v[$arr]['salesName']    = $row['salesName'];
	        $v[$arr]['billDate']     = $row['billDate'];
	        $v[$arr]['deliveryDate'] = $row['deliveryDate'];
	        $v[$arr]['billStatus']   = intval($row['billStatus']);
	        $v[$arr]['billStatusName']  = intval($row['billStatus'])==2 ? '全部出库' :'未出库';
	
	        $v[$arr]['totalQty']     = (float)$row['totalQty'];
	        $v[$arr]['id']           = intval($row['id']);
	        $v[$arr]['amount']       = (float)abs($row['amount']);
	
	        $v[$arr]['transType']    = intval($row['transType']);
	        $v[$arr]['rpAmount']     = (float)abs($row['rpAmount']);
	        $v[$arr]['contactName']  = $row['contactName'];
	        $v[$arr]['description']  = $row['description'];
	        $v[$arr]['billNo']       = $row['billNo'];
	        $v[$arr]['totalAmount']  = (float)abs($row['totalAmount']);
	        $v[$arr]['userName']     = $row['userName'];
	        $v[$arr]['transTypeName']= $row['transTypeName'];
	    }
	    $data['status'] = 200;
	    $data['msg']    = 'success';
	    $data['data']   = isset($v) ? $v : array();
	    die(json_encode($data));
	}
	/*----------------------------------------以下为新版本---------------------------------------*/
    public function main(){
	    $user = get_cookie('user');
	    $pwd = get_cookie('pwd');
	    if(empty($user)||empty($pwd)){
	        $this->load->view('mobile/vlogin',NULL);
	        return;
	    }
	    $u['boss'] = get_cookie('boss');
	    $this->load->view('mobile/main',$u);
	}
	public function center(){
	    $this->load->view('mobile/center',NULL);
	}
	public function vlogin(){
	    $user = get_cookie('user');
	    $pwd = get_cookie('pwd');//die($user.$pwd);
	    if(!empty($user) && !empty($pwd)){
	        $data = $this->mysql_model->get_rows('admin','(username="'.$user.'") or (mobile="'.$pwd.'") ');
	        if(count($data)>0){
	            if($data['status']==1){
	                if ($data['userpwd'] == md5($pwd)) {
	                    $this->input->set_cookie('user',$user,3600000);
	                    $this->input->set_cookie('pwd',$pwd,3600000);
	                    $this->input->set_cookie('uid',$data['uid'],3600000);
	                    $this->input->set_cookie('userName',$data['name'],3600000);
	                    if ($data['roleid']==0 || in_array('301',explode(',',$data['lever']))) {
	                        $boss = 1;
	                    }else
	                        $boss = 0;
	                    $this->input->set_cookie('boss',$boss,3600000);
	                    redirect('mobile/main','refresh');
	                }
	            }
	        }
	    }
	    $this->load->view('mobile/vlogin',NULL);
	}
	public function vloginIn(){
	    $user = str_enhtml($this->input->get_post('user',TRUE));
	    $pwd = str_enhtml($this->input->get_post('pwd',TRUE));
	    $data = $this->mysql_model->get_rows('admin','(username="'.$user.'") or (mobile="'.$pwd.'") ');
	    if(count($data)>0 && $data['status']==1 &&$data['userpwd'] == md5($pwd)){
	        $this->input->set_cookie('user',$user,3600000);
	        $this->input->set_cookie('pwd',$pwd,3600000);
	        $this->input->set_cookie('uid',$data['uid'],3600000);
	        $this->input->set_cookie('userName',$data['name'],3600000);
	        if ($data['roleid']==0 || in_array('301',explode(',',$data['lever']))) {
	            $boss = 1;
	        }else
	            $boss = 0;
	        $this->input->set_cookie('boss',$boss,3600000);
	        $rtn['code'] = '200';
	        $rtn['msg'] = 'main';
	    }else{
	        $rtn['code'] = '-1';
	        $rtn['msg'] = '账号或密码错误';
	    }
	    die(json_encode($rtn));
	}
	
	public function vloginOut(){
	    $this->input->set_cookie('user','',3600000);
	    $this->input->set_cookie('pwd','',3600000);
	    $this->input->set_cookie('uid','',3600000);
	    $this->input->set_cookie('boss','',3600000);
	    redirect('mobile/vlogin','refresh');
	}
	
	public function vsoold(){
	    $this->load->view('mobile/vsoold',NULL);
	}
	public function vsaold(){
	    $this->load->view('mobile/vsaold',NULL);
	}
	
	public function vso(){
	    $this->load->view('mobile/vso',NULL);
	}
	public function vsa(){
	    $this->load->view('mobile/vsa',NULL);
	}
	
	public function vsr(){
	    $this->load->view('mobile/vsr',NULL);
	}
	public function vsor(){
	    $this->load->view('mobile/vsor',NULL);
	}
	
	public function vpa(){
	    $this->load->view('mobile/vpa',NULL);
	}
	public function vpr(){
	    $this->load->view('mobile/vpr',NULL);
	}
	
	public function vsoList(){
	    $page = max(intval($this->input->get_post('page',TRUE)),1);
	    $rows = max(intval($this->input->get_post('rows',TRUE)),10);
	    $skey = str_enhtml($this->input->get_post('skey',TRUE));
	    $transType = intval($this->input->get_post('transType',TRUE));
	    $curStatus = str_enhtml($this->input->get_post('curStatus',TRUE));
	    $uid = intval($_COOKIE['uid']);
	    //$where = 'a.isDelete=0 and a.billType="SALE"';
	    $where = 'a.isDelete=0 and a.transType='.$transType.'';
	    //$where .= ' and a.transType=150601 ';
	    $data = $this->mysql_model->get_rows('admin',array('uid'=>$uid,'status'=>1));
	    if (count($data)>0 && ($data['roleid']==0 || in_array('301',explode(',',$data['lever'])))) {
	    }else{
	        $where .= ' and a.uid="'.$uid.'"';
	    }
	    $where .= empty($curStatus) ? '' : ($curStatus == 1 ? ' and a.checked=0 ' : ($curStatus == 3 ? ' and a.checked=1 and a.billStatus=2 ' : ' and a.checked=1 and a.billStatus=0 '));
	    $offset = $rows * ($page-1);
	    $list = $this->data_model->get_order($where.' order by a.id desc limit '.$offset.','.$rows);
	    foreach ($list as $arr=>$row) {
	        $v[$arr]['checkName']    = $row['checkName'];
	        $v[$arr]['checked']      = intval($row['checked']);
	        $v[$arr]['salesId']      = intval($row['salesId']);
	        $v[$arr]['salesName']    = $row['salesName'];
	        $v[$arr]['billDate']     = $row['billDate'];
	        $v[$arr]['deliveryDate'] = $row['deliveryDate'];
	        $v[$arr]['billStatus']   = intval($row['billStatus']);
	        $v[$arr]['billStatusName']  = intval($row['billStatus'])==2 ? '全部出库' :'未出库';
	
	        $v[$arr]['totalQty']     = (float)$row['totalQty'];
	        $v[$arr]['id']           = intval($row['id']);
	        $v[$arr]['amount']       = (float)abs($row['amount']);
	        $v[$arr]['disRate']        = (float)$row['disRate'];
	        $v[$arr]['disAmount']       = (float)abs($row['disAmount']);
	        $v[$arr]['transType']    = intval($row['transType']);
	        $v[$arr]['rpAmount']     = (float)abs($row['rpAmount']);
	        $v[$arr]['buId']           = intval($row['buId']);
	        $v[$arr]['contactName']  = $row['contactName'];
	        $v[$arr]['description']  = $row['description'];
	        $v[$arr]['billNo']       = $row['billNo'];
	        $v[$arr]['totalAmount']  = (float)abs($row['totalAmount']);
	        $v[$arr]['userName']     = $row['userName'];
	        $v[$arr]['transTypeName']= $row['transTypeName'];
	        $listdetail = $this->data_model->get_order_info('a.isDelete=0 and a.iid='.$row['id'].' order by a.id');
	        foreach ($listdetail as $ary=>$row) {
	            $w[$ary]['invSpec']           = $row['invSpec'];
	            $w[$ary]['taxRate']           = (float)$row['taxRate'];
	            $w[$ary]['srcOrderEntryId']   = intval($row['srcOrderEntryId']);
	            $w[$ary]['srcOrderNo']        = $row['srcOrderNo'];
	            $w[$ary]['srcOrderId']        = intval($row['srcOrderId']);
	            $w[$ary]['goods']             = $row['invNumber'].' '.$row['invName'].' '.$row['invSpec'];
	            $w[$ary]['invName']      = $row['invName'];
	            $w[$ary]['qty']          = (float)abs($row['qty']);
	            $w[$ary]['locationName'] = $row['locationName'];
	            $w[$ary]['amount']       = (float)abs($row['amount']);
	            $w[$ary]['taxAmount']    = (float)$row['taxAmount'];
	            $w[$ary]['price']        = (float)$row['price'];
	            $w[$ary]['tax']          = (float)$row['tax'];
	            $w[$ary]['mainUnit']     = $row['mainUnit'];
	            $w[$ary]['deduction']    = (float)$row['deduction'];
	            $w[$ary]['invId']        = intval($row['invId']);
	            $w[$ary]['invNumber']    = $row['invNumber'];
	            $w[$ary]['locationId']   = intval($row['locationId']);
	            $w[$ary]['locationName'] = $row['locationName'];
	            $w[$ary]['discountRate'] = $row['discountRate'];
	            $w[$ary]['description']  = $row['description'];
	            $w[$ary]['unitId']       = intval($row['unitId']);
	            $w[$ary]['mainUnit']     = $row['mainUnit'];
	        }
	        $v[$arr]['entries']     = isset($w) ? $w : array();
	    }
	    $data['status'] = 200;
	    $data['msg']    = 'success';
	    $data['data']['page']        = $page;
	    $data['data']['records']   = $this->data_model->get_order($where,3);
	    $data['data']['total']     = ceil($data['data']['records']/$rows);
	    $data['data']['rows']      = isset($v) ? $v : array();
	    die(json_encode($data));
	}
	
	public function vsaList(){
	    $page = max(intval($this->input->get_post('page',TRUE)),1);
	    $rows = max(intval($this->input->get_post('rows',TRUE)),10);
	    $skey = str_enhtml($this->input->get_post('skey',TRUE));
	    $transType = intval($this->input->get_post('transType',TRUE));
	    $curStatus = str_enhtml($this->input->get_post('curStatus',TRUE));
	    $uid = intval($_COOKIE['uid']);
	    $where = 'a.isDelete=0 and a.transType='.$transType.''; 
	    $data = $this->mysql_model->get_rows('admin',array('uid'=>$uid,'status'=>1));
	    if (count($data)>0 && ($data['roleid']==0 || in_array('301',explode(',',$data['lever'])))) {
	    }else{
	        $where .= ' and a.uid="'.$uid.'"';
	    }
	    $where .= empty($curStatus) ? '' : ($curStatus == 1 ? ' and a.checked=0 ' : ($curStatus == 3 ? ' and a.checked=2 ' : ' and a.checked=1 '));
	    $offset = $rows * ($page-1);
	    $list = $this->data_model->get_invoice($where.' order by a.id desc limit '.$offset.','.$rows);
	    foreach ($list as $arr=>$row) {
	        $v[$arr]['hxStateCode']  = intval($row['hxStateCode']);
		    //add begin
		    $hasCheck = (float)abs($row['hasCheck']);
		    if($hasCheck <= 0)
		        $hxStateCode = 0;
		    else if($hasCheck >= (float)abs($row['amount']))
		      $hxStateCode = 2;
		    else
		        $hxStateCode = 1;
		    //add end
		    $v[$arr]['hxStateCode']  = $hxStateCode;
		    $v[$arr]['checkName']    = $row['checkName'];
			$v[$arr]['checked']      = intval($row['checked']);
			$v[$arr]['salesId']      = intval($row['salesId']);
			$v[$arr]['salesName']    = $row['salesName'];
			$v[$arr]['billDate']     = $row['billDate'];
			$v[$arr]['billStatus']   = $row['billStatus'];
			$v[$arr]['totalQty']     = (float)$row['totalQty'];
			$v[$arr]['id']           = intval($row['id']);
			$v[$arr]['buId']         = intval($row['buId']);
			$v[$arr]['disRate']            = (float)$row['disRate'];
			$v[$arr]['disAmount']          = (float)$row['disAmount'];
			$v[$arr]['arrears']       = (float)abs($row['arrears']);
			$v[$arr]['accId']        = (float)$row['accId'];
		    $v[$arr]['amount']       = (float)abs($row['amount']);
			$v[$arr]['billStatusName']   = $row['billStatus']==0 ? '未出库' : '全部出库'; 
			$v[$arr]['transType']    = intval($row['transType']);
			$v[$arr]['rpAmount']     = (float)abs($row['hasCheck']);
			$v[$arr]['totalQty']     = (float)abs($row['totalQty']);
			$v[$arr]['contactName']  = $row['contactName'];
			$v[$arr]['serialno']     = $row['serialno'];
			$v[$arr]['description']  = $row['description'];
			$v[$arr]['billNo']       = $row['billNo'];
			$v[$arr]['totalAmount']  = (float)abs($row['totalAmount']);
			$v[$arr]['userName']     = $row['userName'];
			$v[$arr]['transTypeName']= $row['transTypeName'];
			//add by michen 20170724 begin
			$v[$arr]['udf01']        = $row['udf01'];
			$v[$arr]['udf02']        = $row['udf02'];
			$v[$arr]['udf03']        = $row['udf03'];
			//add by michen 20170724 end
	        $listdetail = $this->data_model->get_invoice_info('a.isDelete=0 and a.iid='.$row['id'].' order by a.id');
	        foreach ($listdetail as $ary=>$row) {
	            $w[$ary]['invSpec']           = $row['invSpec'];
	            $w[$ary]['taxRate']           = (float)$row['taxRate'];
	            $w[$ary]['srcOrderEntryId']   = intval($row['srcOrderEntryId']);
	            $w[$ary]['srcOrderNo']        = $row['srcOrderNo'];
	            $w[$ary]['srcOrderId']        = intval($row['srcOrderId']);
	            $w[$ary]['goods']             = $row['invNumber'].' '.$row['invName'].' '.$row['invSpec'];
	            $w[$ary]['invName']      = $row['invName'];
	            $w[$ary]['qty']          = (float)abs($row['qty']);
	            $w[$ary]['locationName'] = $row['locationName'];
	            $w[$ary]['amount']       = (float)abs($row['amount']);
	            $w[$ary]['taxAmount']    = (float)$row['taxAmount'];
	            $w[$ary]['price']        = (float)$row['price'];
	            $w[$ary]['tax']          = (float)$row['tax'];
	            $w[$ary]['mainUnit']     = $row['mainUnit'];
	            $w[$ary]['deduction']    = (float)$row['deduction'];
	            $w[$ary]['invId']        = intval($row['invId']);
	            $w[$ary]['invNumber']    = $row['invNumber'];
	            $w[$ary]['locationId']   = intval($row['locationId']);
	            $w[$ary]['locationName'] = $row['locationName'];
	            $w[$ary]['discountRate'] = $row['discountRate'];
	            $w[$ary]['description']  = $row['description'];
	            $w[$ary]['unitId']       = intval($row['unitId']);
	            $w[$ary]['mainUnit']     = $row['mainUnit'];
	            $w[$ary]['serialno']     = $row['serialno'];
	        }
	        $v[$arr]['entries']     = isset($w) ? $w : array();
	    }
	    $data['status'] = 200;
	    $data['msg']    = 'success';
	    $data['data']['page']        = $page;
	    $data['data']['records']   = $this->data_model->get_invoice($where,3);
	    $data['data']['total']     = ceil($data['data']['records']/$rows);
	    $data['data']['rows']      = isset($v) ? $v : array();
	    die(json_encode($data));
	}
	
	public function vsoCount(){
	    $uid = intval($_COOKIE['uid']);
	    $this->common_model->logs('a'.$uid.'b');
	    $transType = intval($this->input->get_post('transType',TRUE));
	    $where = '(isDelete=0) and (transType='.$transType.')';
	    $data = $this->mysql_model->get_rows('admin',array('uid'=>$uid,'status'=>1));
	    if (count($data)>0 && ($data['roleid']==0 || in_array('301',explode(',',$data['lever'])))) {
	    }else{
	        $where .= ' and (uid="'.$uid.'")';
	    }
	    $count = $this->mysql_model->get_count('order',$where);
	    $data['status'] = 200;
	    $data['msg']    = strval($count);
	    die(json_encode($data));
	}
	
	public function vsaCount(){
	    $uid = intval($_COOKIE['uid']);
	    $this->common_model->logs('a'.$uid.'b');
	    //$where = '(isDelete=0) and (billType="SALE")';
	    $transType = intval($this->input->get_post('transType',TRUE));
	    $where = '(isDelete=0) and (transType='.$transType.')';
	    //$where .= ' and (transType=150601) ';
	    $data = $this->mysql_model->get_rows('admin',array('uid'=>$uid,'status'=>1));
	    if (count($data)>0 && ($data['roleid']==0 || in_array('301',explode(',',$data['lever'])))) {
	    }else{
	        $where .= ' and (uid="'.$uid.'")';
	    }
	    $count = $this->mysql_model->get_count('invoice',$where);
	    $data['status'] = 200;
	    $data['msg']    = strval($count);
	    die(json_encode($data));
	}
	
	public function vstock(){
	    $this->load->view('mobile/vstock',NULL);
	}
	
	public function getDayBillNum(){
	    $orderNum = $this->mysql_model->get_count('order','(isDelete=0) and (billType="SALE") and (billdate=DATE_FORMAT(now(),"%Y-%m-%d"))');
	    $purNum = $this->mysql_model->get_count('invoice','(isDelete=0) and (transType="150501") and (billdate=DATE_FORMAT(now(),"%Y-%m-%d"))');
	    $purRtnNum = $this->mysql_model->get_count('invoice','(isDelete=0) and (transType="150502") and (billdate=DATE_FORMAT(now(),"%Y-%m-%d"))');
	    $saleNum = $this->mysql_model->get_count('invoice','(isDelete=0) and (transType="150601") and (billdate=DATE_FORMAT(now(),"%Y-%m-%d"))');
	    $saleRtnNum = $this->mysql_model->get_count('invoice','(isDelete=0) and (transType="150602") and (billdate=DATE_FORMAT(now(),"%Y-%m-%d"))');
	    $v['orderNum'] = $orderNum;
	    $v['purNum'] = $purNum;
	    $v['purRtnNum'] = $purRtnNum;
	    $v['saleNum'] = $saleNum;
	    $v['saleRtnNum'] = $saleRtnNum;
	    $data['status'] = 200;
	    $data['msg']    = 'success';
	    $data['data']   = $v;
	    die(json_encode($data));
	}
	
	public function vreport(){
	    $this->load->view('mobile/vreport',NULL);
	}
	
	public function get_goods_beginning($where='',$beginDate,$type=2) {
	    $sql = 'select
					a.id,a.name as invName, a.number as invNumber,a.unitName, a.spec as invSpec,b.qty
				from '.$this->db->dbprefix('goods').' as a
				inner join
					(select invId,sum(qty) as qty from '.$this->db->dbprefix('invoice_info').' where isDelete=0 and billDate="'.$beginDate.'" group by invId) as b
				on a.id=b.invId
				where '.$where;
	    return $this->mysql_model->query($sql,$type);
	}
	
	public function vreportDetail() {
	    $sum1 = $sum2 = $sum3 = $sum4 = $sum5 = 0;
	    $where = '';
	    $page = max(intval($this->input->get_post('page',TRUE)),1);
	    $rows = max(intval($this->input->get_post('rows',TRUE)),5);
	    $storageNo  = str_enhtml($this->input->get_post('storageNo',TRUE));
	    $goodsNo    = str_enhtml($this->input->get_post('goodsNo',TRUE));
	    $beginDate  = str_enhtml($this->input->get_post('beginDate',TRUE));
	    $endDate    = str_enhtml($this->input->get_post('endDate',TRUE));
	    $where1 =  'a.isDelete=0';
	    $where2 = 'a.isDelete=0 and a.transType>0';
	    $where2 .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : '';
	    //$where2 .= $endDate ? ' and a.billDate<="'.$endDate.'"' : '';
	    $where2 .= $beginDate ? ' and a.billDate<="'.$beginDate.'"' : '';
	    $list1   = $this->get_goods_beginning($where1.' order by a.id',$beginDate);
	    $list2   = $this->data_model->get_invoice_info($where2.' order by a.billDate,a.id');
	    foreach ($list1 as $arr=>$row) {
	        $v[$arr]['date']          = '';
	        $v[$arr]['billNo']        = '';
	        $v[$arr]['billId']        = '';
	        $v[$arr]['billType']      = '';
	        $v[$arr]['buName']        = '';
	        $v[$arr]['transType']     = '期初数量';
	        $v[$arr]['transTypeId']   = '';
	        $v[$arr]['invNo']         = $row['invNumber'];
	        $v[$arr]['invName']       = $row['invName'];
	        $v[$arr]['spec']          = '';
	        $v[$arr]['unit']          = $row['unitName'];
	        $v[$arr]['entryId']       = '';
	        $v[$arr]['location']      = '';
	        $v[$arr]['locationNo']    = '';
	        $v[$arr]['inout']         = 0;
	        $v[$arr]['qty']           = '';
	        $v[$arr]['baseQty']       = '';
	        $v[$arr]['inqty']         = '';
	        $v[$arr]['outqty']        = '';
	        $v[$arr]['totalqty']      = round($row['qty'],$this->systems['qtyPlaces']);
	        foreach ($list2 as $arr1=>$row1) {
	            $arr = time() + $arr1;
	            if ($row['id']==$row1['invId']) {
	                $inqty         = $row1['qty']>0 ? abs($row1['qty']) : '';
	                $outqty        = $row1['qty']<0 ? abs($row1['qty']) : '';
	                $sum1   += $inqty;
	                $sum2   += $outqty;
	                $totalqtys   = $row['qty']  + $sum1 - $sum2;
	                $v[$arr]['date']          = $row1['billDate'];
	                $v[$arr]['billNo']        = $row1['billNo'];
	                $v[$arr]['billId']        = $row1['iid'];
	                $v[$arr]['billType']      = $row1['billType'];
	                $v[$arr]['buName']        = $row1['contactName'];
	                $v[$arr]['transType']     = $row1['transTypeName'];
	                $v[$arr]['transTypeId']   = $row1['transType'];
	                $v[$arr]['invNo']         = $row1['invNumber'];
	                $v[$arr]['invName']       = $row1['invName'];
	                $v[$arr]['spec']          = $row1['invSpec'];
	                $v[$arr]['unit']          = $row1['mainUnit'];
	                $v[$arr]['entryId']       = '';
	                $v[$arr]['location']      = $row1['locationName'];
	                $v[$arr]['locationNo']    = $row1['locationNo'];
	                $v[$arr]['inout']         = $inqty>0 ? 1 :-1;
	                $v[$arr]['qty']           = 0;
	                $v[$arr]['baseQty']       = 0;
	                $v[$arr]['unitCost']      = 0;
	                $v[$arr]['cost']          = 0;
	                $v[$arr]['inqty']         = round($inqty,$this->systems['qtyPlaces']);
	                $v[$arr]['outqty']        = round($outqty,$this->systems['qtyPlaces']);
	                $v[$arr]['totalqty']      = round($totalqtys,$this->systems['qtyPlaces']);
	            }
	        }
	        $sum3   += $sum1;
	        $sum4   += $sum2;
	        $sum5   += $totalqtys;
	        $totalqtys   = $sum1 = $sum2 =  0;
	    }
	    $data['status'] = 200;
	    $data['msg']    = 'success';
	    $data['data']['page']      = $page;
	    $data['data']['records']   = 1;
	    $data['data']['total']     = ceil($data['data']['records']/$rows);
	    $data['data']['rows']    = isset($v) ? array_values($v) : array();
	    $data['data']['userdata']['date']       = '';
	    $data['data']['userdata']['billNo']     = '';
	    $data['data']['userdata']['billId']     = '';
	    $data['data']['userdata']['billType']   = '';
	    $data['data']['userdata']['buName']     = '';
	    $data['data']['userdata']['type']       = '';
	    $data['data']['userdata']['transTypeId']= '';
	    $data['data']['userdata']['invNo']      = '';
	    $data['data']['userdata']['invName']    = '';
	    $data['data']['userdata']['spec']       = '';
	    $data['data']['userdata']['unit']       = '';
	    $data['data']['userdata']['location']   = '';
	    $data['data']['userdata']['locationNo'] = '';
	    $data['data']['userdata']['inout']      = '';
	    $data['data']['userdata']['qty']        = 0;
	    $data['data']['userdata']['baseQty']    = '';
	    $data['data']['userdata']['unitCost']   = '';
	    $data['data']['userdata']['cost']       = '';
	    $data['data']['userdata']['cost_5']     = '';
	    $data['data']['userdata']['inqty']      = round($sum3,$this->systems['qtyPlaces']);
	    $data['data']['userdata']['outqty']     = round($sum4,$this->systems['qtyPlaces']);
	    $data['data']['userdata']['totalqty']   = round($sum5,$this->systems['qtyPlaces']);
	    die(json_encode($data));
	}
	
	public function vcstList() {
	    $type   = str_enhtml($this->input->get_post('type',TRUE));
	    empty($type) && $type=-10;
	    $skey   = str_enhtml($this->input->get_post('skey',TRUE));
	    $page   = max(intval($this->input->get_post('page',TRUE)),1);
	    $rows   = max(intval($this->input->get_post('rows',TRUE)),10);
	    $where  = '(isDelete=0) and type='.$type;
	    $where .= $skey ? ' and (number like "%'.$skey.'%" or name like "%'.$skey.'%" or linkMans like "%'.$skey.'%")' : '';
	    $list = $this->mysql_model->get_results('contact',$where,'id desc',$rows*($page-1),$rows);
	    //if($type == 10){
	    foreach ($list as $arr=>$row) {
	        $v[$arr]['id']           = intval($row['id']);
	        $v[$arr]['number']       = $row['number'];
	        $v[$arr]['cCategory']    = intval($row['cCategory']);
	        $v[$arr]['customerType'] = $row['cCategoryName'];
	        $v[$arr]['pinYin']       = $row['pinYin'];
	        $v[$arr]['name']         = $row['name'];
	        $v[$arr]['type']         = $row['type'];
	        $v[$arr]['delete']       = intval($row['disable'])==1 ? true : false;
	        $v[$arr]['cLevel']       = intval($row['cLevel']);
	        $v[$arr]['amount']       = (float)$row['amount'];
	        $v[$arr]['periodMoney']  = (float)$row['periodMoney'];
	        $v[$arr]['difMoney']     = (float)$row['difMoney'];
	        $v[$arr]['remark']       = $row['remark'];
	        $v[$arr]['taxRate']      = (float)$row['taxRate'];
	        $v[$arr]['links']        = '';
	        $v[$arr]['linkMen']      = $row['linkMans'];//add by michen 20170724
	        if (strlen($row['linkMans'])>0) {
	            $list = (array)json_decode($row['linkMans'],true);
	            foreach ($list as $arr1=>$row1) {
	                if ($row1['linkFirst']==1) {
	                    $v[$arr]['contacter']            = $row1['linkName'];
	                    $v[$arr]['mobile']               = $row1['linkMobile'];
	                    $v[$arr]['place']               = $row1['linkPlace'];
	                    $v[$arr]['telephone']            = $row1['linkPhone'];
	                    $v[$arr]['linkIm']               = $row1['linkIm'];
	                    $v[$arr]['city']                 = $row1['city'];
	                    $v[$arr]['county']               = $row1['county'];
	                    $v[$arr]['province']             = $row1['province'];
	                    $v[$arr]['deliveryAddress']      = $row1['address'];
	                    $v[$arr]['firstLink']['first']   = $row1['linkFirst'];
	                }
	            }
	        }
	    }
	    $json['status'] = 200;
	    $json['msg']    = 'success';
	    $json['data']['page']      = $page;
	    $json['data']['records']   = $this->mysql_model->get_count('contact',$where);
	    $json['data']['total']     = ceil($json['data']['records']/$rows);
	    $json['data']['rows']      = isset($v) ? array_values($v) : array();
	    die(json_encode($json));
	}
	
	//新增
	public function vaddOrder(){
	    $data = $this->input->post('postData',TRUE);
	    $data['date'] = date('Y-m-d');
	    $data['deliveryDate'] = date('Y-m-d');
	    $data['billNo'] = str_no('XSDD');
	    if (count($data)>0) {
	        $data = $this->vsovalidform($data);
	        $info = elements(array(
	            'billNo','billType','transType','transTypeName','buId',
	            'billDate','description','totalQty','amount','rpAmount','totalAmount',
	            'hxStateCode','totalArrears','disRate','disAmount','postData',
	            'salesId','uid','userName','accId','deliveryDate','modifyTime'),$data);
	        $this->db->trans_begin();
	        if($data[id]<=0)
	            $iid = $this->mysql_model->insert('order',$info);
	        else{
	            $iid = $data['id'];
	            $this->mysql_model->update('order',$info,'(id='.$data['id'].')');
	        }
	        $this->invso_info($iid,$data);
	        if ($this->db->trans_status() === FALSE) {
	            $this->db->trans_rollback();
	            str_alert(-1,'SQL错误或者提交的是空数据');
	        } else {
	            $this->db->trans_commit();
	            $this->common_model->logs('新增销货 单据编号：'.$data['billNo']);
	            str_alert(200,'success',array('id'=>intval($iid)));
	        }
	    }
	    str_alert(-1,'提交的是空数据');
	}
	
	//新增
	public function vaddSa(){
	    $data = $this->input->post('postData',TRUE);
	    $data['date'] = date('Y-m-d');
	    $data['billNo'] = str_no('XS');
	    if (count($data)>0) {
	        $data = $this->vsavalidform($data);
	        $info = elements(array(
				'billNo','billType','transType','transTypeName','buId','billDate','srcOrderNo','srcOrderId',
				'description','totalQty','amount','arrears','rpAmount','totalAmount','hxStateCode',
				'totalArrears','disRate','disAmount','postData','createTime',
				'salesId','uid','userName','accId','modifyTime','udf01','udf02','udf03'),$data,NULL);
	        $this->db->trans_begin();
	        if($data[id]<=0)
	            $iid = $this->mysql_model->insert('invoice',$info);
	        else{
	            $iid = $data['id'];
	            $this->mysql_model->update('invoice',$info,'(id='.$data['id'].')');
	        }
	        $this->invoice_info($iid,$data);
			$this->account_info($iid,$data);
	        if ($this->db->trans_status() === FALSE) {
	            $this->db->trans_rollback();
	            str_alert(-1,'SQL错误或者提交的是空数据');
	        } else {
	            $this->db->trans_commit();
	            $this->common_model->logs('新增销货 单据编号：'.$data['billNo']);
	            str_alert(200,'success',array('id'=>intval($iid)));
	        }
	    }
	    str_alert(-1,'提交的是空数据');
	}
	
	//新增
	public function vaddPu(){
	    $data = $this->input->post('postData',TRUE);
	    $data['date'] = date('Y-m-d');
	    $data['billNo'] = str_no('CG');
	    if (count($data)>0) {
	        $data = $this->vpuvalidform($data);
	        $info = elements(array(
	            'billNo','billType','transType','transTypeName','buId','billDate','srcOrderNo','srcOrderId',
	            'description','totalQty','amount','arrears','rpAmount','totalAmount','hxStateCode',
	            'totalArrears','disRate','disAmount','postData','createTime',
	            'salesId','uid','userName','accId','modifyTime','udf01','udf02','udf03'),$data,NULL);
	        $this->db->trans_begin();
	        if($data[id]<=0)
	            $iid = $this->mysql_model->insert('invoice',$info);
	        else{
	            $iid = $data['id'];
	            $this->mysql_model->update('invoice',$info,'(id='.$data['id'].')');
	        }
	        $this->invoice_info($iid,$data);
	        $this->account_info($iid,$data);
	        if ($this->db->trans_status() === FALSE) {
	            $this->db->trans_rollback();
	            str_alert(-1,'SQL错误或者提交的是空数据');
	        } else {
	            $this->db->trans_commit();
	            $this->common_model->logs('新增购货 单据编号：'.$data['billNo']);
	            str_alert(200,'success',array('id'=>intval($iid)));
	        }
	    }
	    str_alert(-1,'提交的是空数据');
	}
	
	//组装数据
	private function invoice_info($iid,$data) {
	    $i = 1;
	    foreach ($data['entries'] as $arr=>$row) {
	        $v[$arr]['iid']           = $iid;
	        $v[$arr]['uid']           = $data['uid'];
	        $v[$arr]['billNo']        = $data['billNo'];
	        $v[$arr]['billDate']      = $data['billDate'];
	        $v[$arr]['buId']          = $data['buId'];
	        $v[$arr]['transType']     = $data['transType'];
	        $v[$arr]['transTypeName'] = $data['transTypeName'];
	        $v[$arr]['billType']      = $data['billType'];
	        $v[$arr]['salesId']       = $data['salesId'];
	        $v[$arr]['invId']         = intval($row['invId']);
	        $v[$arr]['skuId']         = intval($row['skuId']);
	        $v[$arr]['unitId']        = intval($row['unitId']);
	        $v[$arr]['locationId']    = intval($row['locationId']);
	        $v[$arr]['qty']           = $data['transType']==150601 ? -abs($row['qty']) :abs($row['qty']);
	        $v[$arr]['amount']        = $data['transType']==150601 ? abs($row['amount']) :-abs($row['amount']);
	        $v[$arr]['price']         = abs($row['price']);
	        $v[$arr]['discountRate']  = $row['discountRate'];
	        $v[$arr]['deduction']     = $row['deduction'];
	        $v[$arr]['serialno']      = $row['serialno'];
	        $v[$arr]['description']   = $row['description'];
	        if (intval($row['srcOrderId'])>0) {
	            $v[$arr]['srcOrderEntryId']  = intval($row['srcOrderEntryId']);
	            $v[$arr]['srcOrderId']       = intval($row['srcOrderId']);
	            $v[$arr]['srcOrderNo']       = $row['srcOrderNo'];
	        } else {
	            $v[$arr]['srcOrderEntryId']  = 0;
	            $v[$arr]['srcOrderId']       = 0;
	            $v[$arr]['srcOrderNo']       = '';
	        }
	        $v[$arr]['srcDopey'] = '';
	        $v[$arr]['srcDopeyName'] = '';
	        $v[$arr]['udf01'] = '';
	        $v[$arr]['udf02'] = '';
	        $v[$arr]['udf06'] = '';
	        //add by michen 20170717 begin
	        $srcGood = $v[$arr];
	        $srcGood['invName'] = $row['invName'];
	        $srcGood['invNumber'] = $row['invNumber'];
	        $srcGood['invSpec'] = $row['invSpec'];
	        $srcGood['mainUnit'] = $row['mainUnit'];
	        $srcGood['locationId'] = $row['locationId'];
	        $srcGood['locationName'] = $row['locationName'];
	        $udf06 = json_encode($srcGood);
	        $goods = $this->mysql_model->get_results('goods','(id ='.$row['invId'].') and (isDelete=0)');
	        if (count($goods) > 0 ) {
	            $good = reset($goods);//$good = $goods[0];
	            if($good['dopey']==1){
	                $songoods = (array)json_decode($good['sonGoods'],true);
	                if(count($songoods)>0){
	                    $j = 1;
	                    foreach ($songoods as $sonarr=>$sonrow) {
	                        if($j == 1){
	                            $v[$arr]['invId'] = intval($sonrow['gid']);
	                            $tmpqty = intval($sonrow['qty'])*intval($row['qty']);
	                            $v[$arr]['qty'] = $data['transType']==150601 ? -abs($tmpqty) :abs($tmpqty);
	                            $v[$arr]['price'] = intval($row['amount'])/($tmpqty);
	                            $v[$arr]['amount'] = $data['transType']==150601 ? abs($row['amount']) :-abs($row['amount']);
	                            $v[$arr]['srcDopey'] = $row['invNumber'];
	                            $v[$arr]['srcDopeyName'] = $row['invName'];
	                            $v[$arr]['udf01'] = $i;
	                            $v[$arr]['udf02'] = $j;
	                            $v[$arr]['udf06'] = $udf06;
	                        }else{
	                            $v[$arr.$j]['iid']           = $iid;
	                            $v[$arr.$j]['uid']           = $data['uid'];
	                            $v[$arr.$j]['billNo']        = $data['billNo'];
	                            $v[$arr.$j]['billDate']      = $data['billDate'];
	                            $v[$arr.$j]['buId']          = $data['buId'];
	                            $v[$arr.$j]['transType']     = $data['transType'];
	                            $v[$arr.$j]['transTypeName'] = $data['transTypeName'];
	                            $v[$arr.$j]['billType']      = $data['billType'];
	                            $v[$arr.$j]['salesId']       = $data['salesId'];
	                            //$v[$arr.$j]['invId']         = intval($sonrow['invId']);
	                            $v[$arr.$j]['skuId']         = intval($row['skuId']);
	                            $v[$arr.$j]['unitId']        = intval($row['unitId']);
	                            $v[$arr.$j]['locationId']    = intval($row['locationId']);
	                            //$v[$arr.$j]['qty']           = $data['transType']==150601 ? -abs($sonrow['qty']) :abs($sonrow['qty']);
	                            //$v[$arr.$j]['amount']        = $data['transType']==150601 ? abs($sonrow['amount']) :-abs($sonrow['amount']);
	                            // $v[$arr.$j]['price']         = abs($sonrow['price']);
	                            $v[$arr.$j]['discountRate']  = $row['discountRate'];
	                            $v[$arr.$j]['deduction']     = $row['deduction'];
	                            $v[$arr.$j]['serialno']      = $row['serialno'];
	                            $v[$arr.$j]['description']   = $row['description'];
	                            if (intval($row['srcOrderId'])>0) {
	                                $v[$arr.$j]['srcOrderEntryId']  = intval($row['srcOrderEntryId']);
	                                $v[$arr.$j]['srcOrderId']       = intval($row['srcOrderId']);
	                                $v[$arr.$j]['srcOrderNo']       = $row['srcOrderNo'];
	                            } else {
	                                $v[$arr.$j]['srcOrderEntryId']  = 0;
	                                $v[$arr.$j]['srcOrderId']       = 0;
	                                $v[$arr.$j]['srcOrderNo']       = '';
	                            }
	                            $v[$arr.$j]['invId'] = intval($sonrow['gid']);
	                            $tmpqty = intval($sonrow['qty'])*intval($row['qty']);
	                            $v[$arr.$j]['qty'] = $data['transType']==150601 ? -abs($tmpqty) :abs($tmpqty);
	                            $v[$arr.$j]['price'] = 0;
	                            $v[$arr.$j]['amount'] = 0;
	                            $v[$arr.$j]['srcDopey'] = $row['invNumber'];
	                            $v[$arr.$j]['srcDopeyName'] = $row['invName'];
	                            $v[$arr.$j]['udf01'] = $i;
	                            $v[$arr.$j]['udf02'] = $j;
	                            $v[$arr.$j]['udf06'] = $udf06;
	                        }
	                        $j++;
	                    }
	                }
	            }
	        }
	        $i++;
	        //add by michen 20170717  end
	    }
	    if (isset($v)) {
	        if ($data['id']>0) {
	            $this->mysql_model->delete('invoice_info',array('iid'=>$iid));
	        }
	        $this->mysql_model->insert('invoice_info',$v);
	    }
	}
	
	//组装数据
	private function account_info($iid,$data) {
	    foreach ($data['accounts'] as $arr=>$row) {
	        $v[$arr]['iid']           = intval($iid);
	        $v[$arr]['billNo']        = $data['billNo'];
	        $v[$arr]['buId']          = $data['buId'];
	        $v[$arr]['billType']      = $data['billType'];
	        $v[$arr]['transType']     = $data['transType'];
	        $v[$arr]['transTypeName'] = $data['transType']==150601 ? '普通销售' : '销售退回';
	        $v[$arr]['billDate']      = $data['billDate'];
	        $v[$arr]['accId']         = $row['accId'];
	        $v[$arr]['payment']       = $data['transType']==150601 ? abs($row['payment']) : -abs($row['payment']);
	        $v[$arr]['wayId']         = $row['wayId'];
	        $v[$arr]['settlement']    = $row['settlement'] ;
	        $v[$arr]['uid']           = $data['uid'];
	    }
	    if ($data['id']>0) {
	        $this->mysql_model->delete('account_info',array('iid'=>$iid));
	    }
	    if (isset($v)) {
	        $this->mysql_model->insert('account_info',$v);
	    }
	}
	
	//公共验证
	private function vsovalidform($data) {
	    $data['id']              = isset($data['id']) ? intval($data['id']) : 0;
	    $data['buId']            = intval($data['buId']);
	    $data['salesId']         = intval($data['salesId']);
	    $data['billType']        = 'SALE';
	    $data['billDate']        = $data['date'];
	    $data['transType']       = intval($data['transType']);
	    $data['transTypeName']   = $data['transType']==150601 ? '订货' : '退货';
	    $data['description']     = $data['description'];
	    $data['totalQty']        = (float)$data['totalQty'];
	    $data['totalTax']        = isset($data['totalTax']) ? (float)$data['totalTax'] : 0;
	    $data['totalTaxAmount']  = isset($data['totalTaxAmount']) ? (float)$data['totalTaxAmount'] : 0;
	    $data['amount']          = $data['transType']==150601 ? abs($data['amount']) : -abs($data['amount']);
	    $data['totalAmount']     = $data['transType']==150601 ? abs($data['totalAmount']) : -abs($data['totalAmount']);
	    $data['disRate']        = (float)$data['disRate'];
	    $data['disAmount']      = (float)$data['disAmount'];
	    $data['totalDiscount']  = (float)$data['totalDiscount'];
	    $data['uid']            = intval($_COOKIE['uid']);
	    $data['userName']       = $_COOKIE['userName'];
	    $data['modifyTime']     = date('Y-m-d H:i:s');
	
	    //修改的时候
	    if ($data['id']>0) {
	        $invoice = $this->mysql_model->get_rows('order',array('id'=>$data['id'],'billType'=>'SALE','isDelete'=>0));
	        count($invoice)<1 && str_alert(-1,'单据不存在、或者已删除');
	        $data['checked'] = $invoice['checked'];
	        $data['billNo']  = $invoice['billNo'];
	    } else {
	        $data['billNo']  = str_no('XSDD');
	    }
	
	    $data['disRate'] < 0  && str_alert(-1,'折扣率要为数字，请输入有效数字！');
	    abs($data['amount']) < abs($data['disAmount']) && str_alert(-1,'折扣额不能大于合计金额！');
	
	    //数据验证
	    if (is_array($data['entries'])) {
	        count($data['entries']) < 1 && str_alert(-1,'提交的是空数据');
	    } else {
	        str_alert(-1,'提交的是空数据');
	    }
	
	    //供应商验证
	    $this->mysql_model->get_count('contact','(id='.intval($data['buId']).')')<1 && str_alert(-1,'客户不存在');
	    	
	    //商品录入验证
	    $storage   = array_column($this->mysql_model->get_results('storage','(disable=0)'),'id');
	    foreach ($data['entries'] as $arr=>$row) {
	        intval($row['invId'])<1 && str_alert(-1,'请选择商品');
	        (float)$row['qty'] < 0  && str_alert(-1,'商品数量要为数字，请输入有效数字！');
	        (float)$row['price'] < 0  && str_alert(-1,'商品销售单价要为数字，请输入有效数字！');
	        (float)$row['discountRate'] < 0  && str_alert(-1,'折扣率要为数字，请输入有效数字！');
	        intval($row['locationId']) < 1 && str_alert(-1,'请选择相应的仓库！');
	        !in_array($row['locationId'],$storage) && str_alert(-1,$row['locationName'].'不存在或不可用！');
	    }
	    $data['postData'] = serialize($data);
	    return $data;
	
	}
	//公共验证
	private function vsavalidform($data) {
	    $data['id']              = isset($data['id']) ? intval($data['id']) : 0;
	    $data['buId']            = intval($data['buId']);
	    $data['accId']           = intval($data['accId']);
	    $data['salesId']         = intval($data['salesId']);
	    $data['transType']       = intval($data['transType']);
	    $data['amount']          = (float)$data['amount'];
	    $data['arrears']         = (float)$data['arrears'];
	    $data['disRate']         = (float)$data['disRate'];
	    $data['disAmount']       = (float)$data['disAmount'];
	    $data['rpAmount']        = (float)$data['rpAmount'];
	    $data['totalQty']        = (float)$data['totalQty'];
	    $data['totalArrears']    = isset($data['totalArrears']) ?(float)$data['totalArrears']:0;
	    $data['totalDiscount']   = isset($data['totalDiscount']) ? (float)$data['totalDiscount']:0;
	    $data['customerFree']    = isset($data['customerFree']) ? (float)$data['customerFree']:0;
	    $data['billType']        = 'SALE';
	    $data['billDate']        = $data['date'];
	    $data['transTypeName']   = $data['transType']==150601 ? '销货' : '销退';
	    $data['serialno']        = $data['serialno'];
	    $data['description']     = $data['description'];
	    $data['totalTax']        = isset($data['totalTax']) ? (float)$data['totalTax'] :0;
	    $data['totalTaxAmount']  = isset($data['totalTaxAmount']) ? (float)$data['totalTaxAmount'] :0;
	
	    $data['arrears'] < 0 && str_alert(-1,'本次欠款要为数字，请输入有效数字！');
	    $data['disRate'] < 0 && str_alert(-1,'折扣率要为数字，请输入有效数字！');
	    $data['rpAmount'] < 0  && str_alert(-1,'本次收款要为数字，请输入有效数字！');
	    $data['customerFree'] < 0 && str_alert(-1,'客户承担费用要为数字，请输入有效数字！');
	    $data['amount'] < $data['rpAmount']  && str_alert(-1,'本次收款不能大于折后金额！');
	    $data['amount'] < $data['disAmount'] && str_alert(-1,'折扣额不能大于合计金额！');
	
	    if ($data['amount']==$data['rpAmount']) {
	        $data['hxStateCode'] = 2;
	    } else {
	        $data['hxStateCode'] = $data['rpAmount']!=0 ? 1 : 0;
	    }
	
	    $data['amount']          = $data['transType']==150601 ? abs($data['amount']) : -abs($data['amount']);
	    $data['arrears']         = $data['transType']==150601 ? abs($data['arrears']) : -abs($data['arrears']);
	    $data['rpAmount']        = $data['transType']==150601 ? abs($data['rpAmount']) : -abs($data['rpAmount']);
	    $data['totalAmount']     = $data['transType']==150601 ? abs($data['totalAmount']) : -abs($data['totalAmount']);
	    $data['uid']            = intval($_COOKIE['uid']);
	    $data['userName']       = $_COOKIE['userName'];
	    $data['modifyTime']      = date('Y-m-d H:i:s');
	    $data['createTime']      = $data['modifyTime'];
	    $data['accounts']        = isset($data['accounts']) ? $data['accounts'] : array();
	    $data['entries']         = isset($data['entries']) ? $data['entries'] : array();
	
	    count($data['entries']) < 1 && str_alert(-1,'提交的是空数据');
	     
	
	    //选择了结算账户 需要验证
	    foreach ($data['accounts'] as $arr=>$row) {
	        (float)$row['payment'] < 0 && str_alert(-1,'结算金额要为数字，请输入有效数字！');
	    }
	
	    if ($data['id']>0) {
	        $invoice = $this->mysql_model->get_rows('invoice',array('id'=>$data['id'],'billType'=>'SALE','isDelete'=>0));
	        count($invoice)<1 && str_alert(-1,'单据不存在、或者已删除');
	        $data['checked'] = $invoice['checked'];
	        $data['billNo']  = $invoice['billNo'];
	    } else {
	        //$data['billNo']  = str_no('XS');
	    }
	
	    //供应商验证
	    $this->mysql_model->get_count('contact',array('id'=>$data['buId']))<1 && str_alert(-1,'客户不存在');
	    	
	    //商品录入验证
	    $system    = $this->common_model->get_option('system');
	
	    //库存验证
	    if ($system['requiredCheckStore']==1) {
	        $inventory = $this->data_model->get_invoice_info_inventory();
	    }
	
	    $storage   = array_column($this->mysql_model->get_results('storage',array('disable'=>0)),'id');
	    foreach ($data['entries'] as $arr=>$row) {
	        intval($row['invId'])<1 && str_alert(-1,'请选择商品');
	        (float)$row['qty'] < 0 && str_alert(-1,'商品数量要为数字，请输入有效数字！');
	        (float)$row['price'] < 0 && str_alert(-1,'商品销售单价要为数字，请输入有效数字！');
	        (float)$row['discountRate'] < 0 && str_alert(-1,'折扣率要为数字，请输入有效数字！');
	        intval($row['locationId']) < 1 && str_alert(-1,'请选择相应的仓库！');
	        !in_array($row['locationId'],$storage) && str_alert(-1,$row['locationName'].'不存在或不可用！');
	        //库存判断 修改不验证
	        if ($system['requiredCheckStore']==1 && $data['id']<1) {
	            if (intval($data['transType'])==150601) {                        //销售才验证
	                if (isset($inventory[$row['invId']][$row['locationId']])) {
	                    	
	                    $inventory[$row['invId']][$row['locationId']] < $row['qty'] && str_alert(-1,$row['locationName'].$row['invName'].'商品库存不足！');
	                } else {
	                    //str_alert(-1,$row['invName'].'库存不足！');
	                    //add by michen 20170719 for 组合品库存检查
	                    $gooddata = $this->mysql_model->get_results('goods','(id ='.$row['invId'].') and (isDelete=0)');
	                    if(count($gooddata)>0){
	                        $dopey = reset($gooddata);
	                        if($dopey['dopey'] != 1){
	                            str_alert(-1,'商品'.$row['invName'].'库存不足！');
	                        }else{
	                            $sonlist = (array)json_decode($dopey['sonGoods'],true) ;
	                            if(count($sonlist)>0){
	                                foreach ($sonlist as $sonkey=> $sonrow){
	                                    if($inventory[$sonrow['gid']][$row['locationId']] < $row['qty']*$sonrow['qty'])
	                                        str_alert(-1,'商品“'.$row['invName'].'”的子商品“'.$sonrow['name'].'”库存不足！');
	                                }
	                            }else{
	                                str_alert(-1,'商品“'.$row['invName'].'”的子商品“'.$sonrow['name'].'”丢失，请检查！');
	                            }
	                        }
	                    }else{
	                        str_alert(-1,'商品“'.$row['invName'].'”不存在！');
	                    }
	                }
	            }
	        }
	    }
	    $data['srcOrderNo'] = $data['entries'][0]['srcOrderNo'] ? $data['entries'][0]['srcOrderNo'] : 0;
	    $data['srcOrderId'] = $data['entries'][0]['srcOrderId'] ? $data['entries'][0]['srcOrderId'] : 0;
	    $data['postData'] = serialize($data);
	    return $data;
	}
	
	private function vpuvalidform($data) {
	    $data['id']              = isset($data['id']) ? intval($data['id']) : 0;
	    $data['billType']        = 'PUR';
	    $data['transTypeName']   = $data['transType']==150501 ? '购货' : '退货';
	    $data['billDate']        = $data['date'];
	    $data['buId']            = intval($data['buId']);
	    $data['accId']           = intval($data['accId']);
	    $data['transType']       = intval($data['transType']);
	    $data['amount']          = (float)$data['amount'];
	    $data['arrears']         = (float)$data['arrears'];
	    $data['disRate']         = (float)$data['disRate'];
	    $data['disAmount']       = (float)$data['disAmount'];
	    $data['rpAmount']        = (float)$data['rpAmount'];
	    $data['totalQty']        = (float)$data['totalQty'];
	    $data['totalArrears']    = (float)$data['totalArrears'];
	    $data['accounts']        = isset($data['accounts']) ? $data['accounts'] : array();
	    $data['entries']         = isset($data['entries']) ? $data['entries'] : array();
	
	    $data['arrears'] < 0 && str_alert(-1,'本次欠款要为数字，请输入有效数字！');
	    $data['disRate'] < 0 && str_alert(-1,'折扣率要为数字，请输入有效数字！');
	    $data['rpAmount'] < 0  && str_alert(-1,'本次收款要为数字，请输入有效数字！');
	    $data['amount'] < $data['rpAmount']  && str_alert(-1,'本次收款不能大于折后金额！');
	    $data['amount'] < $data['disAmount'] && str_alert(-1,'折扣额不能大于合计金额！');
	
	    if ($data['amount']==$data['rpAmount']) {
	        $data['hxStateCode'] = 2;
	    } else {
	        $data['hxStateCode'] = $data['rpAmount']!=0 ? 1 : 0;
	    }
	
	    $data['amount']          = $data['transType']==150501 ? abs($data['amount']) : -abs($data['amount']);
	    $data['arrears']         = $data['transType']==150501 ? abs($data['arrears']) : -abs($data['arrears']);
	    $data['rpAmount']        = $data['transType']==150501 ? abs($data['rpAmount']) : -abs($data['rpAmount']);
	    $data['totalAmount']     = $data['transType']==150501 ? abs($data['totalAmount']) : -abs($data['totalAmount']);
	    $data['uid']             = $this->jxcsys['uid'];
	    $data['userName']        = $this->jxcsys['name'];
	    $data['modifyTime']      = date('Y-m-d H:i:s');
	    $data['createTime']      = $data['modifyTime'];
	
	
	
	    strlen($data['billNo']) < 1 && str_alert(-1,'单据编号不为空');
	    count($data['entries']) < 1 && str_alert(-1,'提交的是空数据');
	
	
	
	    	
	    if ($data['id']>0) {
	        $invoice = $this->mysql_model->get_rows('invoice',array('id'=>$data['id'],'billType'=>'PUR','isDelete'=>0));
	        count($invoice)<1 && str_alert(-1,'单据不存在、或者已删除');
	        $data['checked'] = $invoice['checked'];
	        $data['billNo']  = $invoice['billNo'];
	    } else {
	        //$data['billNo']  = str_no('CG');
	    }
	     
	    	
	    foreach ($data['accounts'] as $arr=>$row) {
	        (float)$row['payment'] < 0 && str_alert(-1,'结算金额要为数字，请输入有效数字！');
	    }
	
	
	    $this->mysql_model->get_count('contact',array('id'=>$data['buId'])) < 1 && str_alert(-1,'购货单位不存在');
	
	    	
	    $system  = $this->common_model->get_option('system');
	
	
	    if ($system['requiredCheckStore']==1) {
	        $inventory = $this->data_model->get_invoice_info_inventory();
	    }
	    	
	    $storage = array_column($this->mysql_model->get_results('storage',array('disable'=>0)),'id');
	    foreach ($data['entries'] as $arr=>$row) {
	        intval($row['invId'])<1 && str_alert(-1,'请选择商品');
	        (float)$row['qty'] < 0  && str_alert(-1,'商品数量要为数字，请输入有效数字！');
	        (float)$row['price'] < 0  && str_alert(-1,'商品销售单价要为数字，请输入有效数字！');
	        (float)$row['discountRate'] < 0  && str_alert(-1,'折扣率要为数字，请输入有效数字！');
	        intval($row['locationId']) < 1 && str_alert(-1,'请选择相应的仓库！');
	        !in_array($row['locationId'],$storage) && str_alert(-1,$row['locationName'].'不存在或不可用！');
	        	
	        if ($system['requiredCheckStore']==1 && $data['id']<1) {
	            if ($data['transType']==150502) {
	                if (isset($inventory[$row['invId']][$row['locationId']])) {
	                    $inventory[$row['invId']][$row['locationId']] < $row['qty'] && str_alert(-1,$row['locationName'].$row['invName'].'商品库存不足！');
	                } else {
	                    str_alert(-1,$row['invName'].'库存不足！');
	                }
	            }
	        }
	    }
	    $data['srcOrderNo'] = $data['entries'][0]['srcOrderNo'] ? $data['entries'][0]['srcOrderNo'] : 0;
	    $data['srcOrderId'] = $data['entries'][0]['srcOrderId'] ? $data['entries'][0]['srcOrderId'] : 0;
	    $data['postData'] = serialize($data);
	
	    return $data;
	}
	
	//员工列表
	public function vsalesList(){ 
		$skey   = str_enhtml($this->input->get_post('skey',TRUE));
	    $page   = max(intval($this->input->get_post('page',TRUE)),1);
	    $rows   = max(intval($this->input->get_post('rows',TRUE)),10);
	    $where  = '(isDelete=0) and (deptId=0)';
	    $where .= $skey ? ' and (number like "%'.$skey.'%" or name like "%'.$skey.'%")' : '';
		$list = $this->mysql_model->get_results('staff',$where,'id desc',$rows*($page-1),$rows);  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['birthday']    =$row['birthday'];
		    $v[$arr]['allowNeg']    = false;
			$v[$arr]['commissionrate'] = $row['commissionrate'];
			$v[$arr]['creatorId']    = $row['creatorId'];
			$v[$arr]['deptId']       = $row['deptId'];
			$v[$arr]['description']  = $row['description'];
			$v[$arr]['email']        = $row['name'];
			$v[$arr]['empId']        = $row['empId'];
			$v[$arr]['empType']      = $row['empType'];
			$v[$arr]['fullId']       = $row['fullId'];
			$v[$arr]['id']           = intval($row['id']);
			$v[$arr]['leftDate']     = NULL;
			$v[$arr]['mobile']       = $row['mobile'];
			$v[$arr]['name']         = $row['name'];
			$v[$arr]['number']       = $row['number'];
			$v[$arr]['parentId']     = $row['parentId'];
			$v[$arr]['sex']          = $row['sex'];
			$v[$arr]['userName']     = $row['userName'];
			$v[$arr]['passWord']     = $row['passWord'];
			$v[$arr]['score']     = $row['score'];
			$v[$arr]['delete']       = intval($row['disable'])==1 ? true : false;   //是否禁用
		}
		$json['status'] = 200;
		$json['msg']    = 'success';
		$json['data']['page']      = $page;
	    $json['data']['records']   = $this->mysql_model->get_count('staff',$where);
	    $json['data']['total']     = ceil($json['data']['records']/$rows);
	    $json['data']['rows']      = isset($v) ? array_values($v) : array();
		die(json_encode($json));	  
	}
	
	public function vgetAsales(){ 
	    $where  = '(isDelete=0) and (deptId=0)';
	    $where .=  ' and (number like "%'.$_COOKIE['user'].'%" or name like "%'.$_COOKIE['userName'].'%")';
		$row = $this->mysql_model->get_rows('staff',$where);  
		if(count($row)>0){
		    $v['birthday']    =$row['birthday'];
		    $v['allowNeg']    = false;
			$v['commissionrate'] = $row['commissionrate'];
			$v['creatorId']    = $row['creatorId'];
			$v['deptId']       = $row['deptId'];
			$v['description']  = $row['description'];
			$v['email']        = $row['name'];
			$v['empId']        = $row['empId'];
			$v['empType']      = $row['empType'];
			$v['fullId']       = $row['fullId'];
			$v['id']           = intval($row['id']);
			$v['leftDate']     = NULL;
			$v['mobile']       = $row['mobile'];
			$v['name']         = $row['name'];
			$v['number']       = $row['number'];
			$v['parentId']     = $row['parentId'];
			$v['sex']          = $row['sex'];
			$v['userName']     = $row['userName'];
			$v['passWord']     = $row['passWord'];
			$v['score']     = $row['score'];
			$v['delete']       = intval($row['disable'])==1 ? true : false;   //是否禁用
		}
		$json['status'] = 200;
		$json['msg']    = 'success';
		$json['data']     = isset($v) ? $v : array();
		die(json_encode($json));	  
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
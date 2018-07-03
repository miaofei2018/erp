<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PriceClause extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
    }

	//价格条款列表
	public function index(){
		$list = $this->mysql_model->get_results('price_clause',array('isDelete'=>0),'id desc');
		foreach ($list as $arr=>$row) {
		    $v[$arr]['code']    =$row['code'];
			$v[$arr]['clauseName']    = $row['clauseName'];
			$v[$arr]['description']       = $row['description'];
			$v[$arr]['id']           = intval($row['id']);
		}
		$json['status'] = 200;
		$json['msg']    = 'success';
		$json['data']['items']       = isset($v) ? $v : array();
		$json['data']['totalsize']   = count($list);
		die(json_encode($json));
	}

	//新增
	public function add(){
		$this->common_model->checkpurview(59);
		$data = str_enhtml($this->input->post(NULL,TRUE));
		if (count($data)>0) {
			$data = $this->validform($data);
			$this->mysql_model->get_count('price_clause',array('isDelete'=>0,'code'=>$data['code'])) > 0 && str_alert(-1,'价格条款编号重复');
			$sql  = $this->mysql_model->insert('price_clause',elements(array('clauseName','code','description'),$data));
			if ($sql) {
				$data['id'] = $sql;
				$this->common_model->logs('新增价格条款:编号'.$data['code'].' 名称'.$data['clauseName']);
				str_alert(200,'success',$data);
			}
		}
		str_alert(-1,'添加失败');
	}

	//修改
	public function update(){
		$this->common_model->checkpurview(59);
		$data = str_enhtml($this->input->post(NULL,TRUE));
		if (count($data)>0) {
			$data = $this->validform($data);
			$this->mysql_model->get_count('price_clause',array('isDelete'=>0,'code'=>$data['code'],'id !='=>$data['id'])) > 0 && str_alert(-1,'价格条款编号重复');
			$sql  = $this->mysql_model->update('price_clause',elements(array('clauseName','code','description'),$data),array('id'=>$data['id']));
			if ($sql) {
				$this->common_model->logs('更新价格条款:编号'.$data['number'].' 名称'.$data['name']);
				str_alert(200,'success',$data);
			}
		}
		str_alert(-1,'更新失败');
	}

	//删除
	public function delete(){
		$this->common_model->checkpurview(59);
		$id = intval($this->input->post('id',TRUE));
		$data = $this->mysql_model->get_rows('price_clause',array('id'=>$id));
		if (count($data)>0) {
			$info['isDelete'] = 1;
			$sql = $this->mysql_model->update('price_clause',$info,array('id'=>$id));
		    if ($sql) {
				$this->common_model->logs('删除价格条款:ID='.$id.' 名称:'.$data['name']);
				str_alert(200,'success',array('msg'=>'成功删除'));
			}
		}
		str_alert(-1,'删除失败');
	}

	//名称查询
	public function findByNumberOrName(){
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100);
		$skey = str_enhtml($this->input->get_post('skey',TRUE));
		$where  = $skey ? 'name like "%'.$skey.'%" or number like "%'.$skey.'%"' : '';
		$offset = $rows * ($page-1);
		$list = $this->mysql_model->get_results('staff',$where,'id desc',$offset,$rows);
		foreach ($list as $arr=>$row) {
		    $v[$arr]['id']         = intval($row['id']);
			$v[$arr]['name']       = $row['name'];
			$v[$arr]['number']     = $row['number'];
		}
		$json['status'] = 200;
		$json['msg']    = 'success';
		$json['data']['totalsize'] = $this->mysql_model->get_count('staff',$where);
		$json['data']['items']     = isset($v) ? $v : array();
		die(json_encode($json));
	}

	//公共验证
	private function validform($data) {
	    $data['id']  = intval($data['id']);
        strlen($data['clauseName']) < 1 && str_alert(-1,'名称不能为空');
		strlen($data['code']) < 1 && str_alert(-1,'编号不能为空');
		return $data;
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
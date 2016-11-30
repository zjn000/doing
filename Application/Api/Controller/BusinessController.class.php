<?php
namespace Api\Controller;
use Common\Controller\PublicBaseController;
/**
 * 客户首页Controller
 */
class BusinessController extends PublicBaseController{
	/**
	 * 首页
	 */
	public function index(){
		
		$this->search();
	}

	
	public function search()
	{
		$businessModel = D('Business');
		
		$data = I('get.');
		//商家名称
		if(!empty($data['name']) ){
			$where['name'] = array('LIKE','%'.$data['name'].'%');			
		}
		
		$data = $businessModel->getById(18);
		
		$list = get_page_data($businessModel,$where,'create_time desc');
		
		$this->assign('list',$list);
		$this->display('Business/index');
	}
    
	
	/**
	 * 添加
	 */
	public function add(){
		if(IS_POST){
			$data=I('post.');
			$result = D('Business')->addData($data);
			if($result){
				// 操作成功
				$this->success('添加成功',U('Api/Business/index'));
			}else{
				$error_word=D('Business')->getError();
				// 操作失败
				$this->error($error_word);
			}
		}else{
			
			$this->display();
		}
	}
	
	
	

}
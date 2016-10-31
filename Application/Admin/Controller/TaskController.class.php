<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 任务指标
 */
class TaskController extends AdminBaseController{
    /**
     * 列表
     */
    public function index(){
    	$this->search();   
    }
    
    public function search()
    {
    	$data = I('get.');
    	
    	$TaskModel = D('Task');
    	
    	//查询条件
    	$where = array();
    	//分页跳转的时候保证查询条件
    	$where_parameter = array();
    	
    	
    	//判断显示局部数据还是全部
    	if(empty($_SESSION['user']['data_range']))
    	{
    		$where['create_id'] = $_SESSION['user']['id'];
    		$where_parameter['create_id'] = $_SESSION['user']['id'];
    	}
    	else
    	{
    		if(!empty($data['create_id']))
    		{
    			$where['create_id'] = $data['create_id'];
    			$where_parameter['create_id'] = $data['create_id'];
    		}
    	}
    	
    	
    	//完成状态
    	if(!empty($data['task_status'])){
    		$where['task_status'] = $data['task_status'];
    		$where_parameter['task_status'] = $data['task_status'];
    	}
    	
    	
    	//只有开始日期
    	if(!empty($data['start_date']) && empty($data['end_date'])){
    		$where['task_date'] = array('EGT',strtotime($data['start_date']));
    		$where_parameter['start_date'] = $data['start_date'];
    	}
    	//只有结束日期
    	if( empty($data['start_date']) && !empty($data['end_date'])){
    		$where['task_date'] = array('ELT',strtotime($data['end_date']));
    		$where_parameter['end_date'] = $data['end_date'];
    	}
    	//开始日期-结束日期
    	if(!empty($data['start_date']) && !empty($data['end_date']))
    	{
    		$where_parameter['start_date'] = $data['start_date'];
    		$where_parameter['end_date'] = $data['end_date'];
    		$where['task_date'] = array(array('EGT',strtotime($data["start_date"])),array('ELT',strtotime($data["end_date"])),'AND');
    	}
    	
    	 
    	$count = $TaskModel->where($where)->count();
    	
    	$page = new_page($count,15,$where_parameter);
    	 
    	//获取列表数据
    	$list = $TaskModel->where($where)->order('create_time desc')->limit($page->firstRow.','.$page->listRows)->select();
    	//分页链接
    	$show = $page->show();
    	
    	//获取销售部下的所有员工姓名组
    	$userList = D('Users')->getUidsBySectorId(3);
    	
    	foreach ($list as $key=>$row)
    	{
    		$list[$key]['nikename'] = $userList[$row['create_id']];
    		$list[$key]['task_date'] = date('Y-m-d',$row['task_date']);
    		$list[$key]['status'] = $row['task_status'] == 1 ? '未完成' : '已完成';
    	}
    	
    	
    	$this->assign('empty',"<tr><td colspan='4'><span class='empty'>暂时没有数据</span></td></tr>"); //数据集为空时
    	$this->assign('userList',$userList); //赋值活动负责人集合
    	$this->assign('page',$show);// 赋值分页输出
    	$this->assign('list',$list);// 赋值数据集
    	$this->display('Task/index');
    }
    
    
    
    
    
    /**
     * 添加
     */
    public function add(){
    	if(IS_POST){
    		$data=I('post.');
    		
    		
    		$data['task_date'] = strtotime($data['task_date']);
    		
    		$result = D('Task')->addData($data);
    		
    		if($result){
    			// 操作成功
    			$this->success('添加成功',U('Admin/Task/index'));
    		}else{
    			$error_word=D('Task')->getError();
    			// 操作失败
    			$this->error($error_word);
    		}
    	}else{
    		$this->display();
    	}
    }
    
    /**
     * 编辑
     */
    public function edit(){
    	
    	if(IS_POST){	
    		
    		$data=I('post.');
    		
    		$map = array(
    			'id'=>$data['id']
    		);
    		
    		$result = D('Task')->editData($map,$data);
    		
    		if($result){
    			// 操作成功
    			$this->success('编辑成功',U('Admin/Task/index'));
    		}else{
    			$error_word=D('Task')->getError();
    			// 操作失败
    			$this->error($error_word);
    		}
    		
    	}else{
    		
    		$id = I('get.id',0,'intval');
    		
    		$assign = D('Task')->find($id);
    	
    		$assign['task_date'] = date('Y-m-d',$assign['task_date']);
    		
    		$this->assign('assign',$assign);
    		$this->display();
    	}
    }
    
    /**
     * 导出数据
     */
    public function excel_out()
    {
    
    	$data = I('get.');
    	 
    	$where = array();
    
    	//判断显示局部数据还是全部
    	if(empty($_SESSION['user']['data_range']))
    	{
    		$where['create_id'] = $_SESSION['user']['id'];    		
    	}
    	else
    	{
    		if(!empty($data['create_id']))
    		{
    			$where['create_id'] = $data['create_id'];
    		}
    	}
    	     	 
    	//完成状态
    	if(!empty($data['task_status'])){
    		$where['task_status'] = $data['task_status'];   		
    	}
    
    	//只有开始日期
    	if(!empty($data['start_date']) && empty($data['end_date'])){
    		$where['task_date'] = array('EGT',strtotime($data['start_date']));
    	}
    	//只有结束日期
    	if( empty($data['start_date']) && !empty($data['end_date'])){
    		$where['task_date'] = array('ELT',strtotime($data['end_date']));
    	}
    	//开始日期-结束日期
    	if(!empty($data['start_date']) && !empty($data['end_date']))
    	{
    		$where['task_date'] = array(array('EGT',strtotime($data["start_date"])),array('ELT',strtotime($data["end_date"])),'AND');
    	}
    	 
    	
    	$list = D('Task')->getAllData($where);
    	
    	
    	
    	//获取销售部下的所有员工姓名组
    	$userList = D('Users')->getUidsBySectorId(3);
    	 
    	foreach ($list as $key=>$row)
    	{
    		$list[$key]['create_id'] = $userList[$row['create_id']];
    		$list[$key]['task_date'] = date('Y-m-d',$row['task_date']);
    		$list[$key]['task_status'] = $row['task_status'] == 1 ? '未完成' : '已完成';
    	}
    	
    	 
    	$arrHead = array(
    			'create_id' => 'BD',
    			'task_date' => '日期',
    			'task_status' => '完成状态',
    			'plan_new_num' => '新签约商家数（计划）',
    			'real_new_num' => '新签约商家数（实际）',
    			'plan_new_price' => '新签约商家金额（计划）',
    			'real_new_price' => '新签约商家金额（实际）',
    			'plan_renewal_num' => '续签商家数（计划）',
    			'real_renewal_num' => '续签商家数（实际）',
    			'plan_renewal_price' => '续签商家金额（计划）',
    			'real_renewal_price' => '续签商家金额（实际）',
    			'plan_toll_num' => '收缴欠费商家数（计划）',
    			'real_toll_num' => '收缴欠费商家数（实际）',
    			'plan_toll_price'=> '收缴欠费商家金额（计划）',
    			'real_toll_price' => '收缴欠费商家金额（实际）',
    			'plan_ad_num' => '广告商家数（计划）',
    			'real_ad_num' => '广告商家数（实际）',
    			'plan_ad_price' => '广告商家金额（计划）',
    			'real_ad_price' => '广告商家金额（实际）',
    			'plan_hour' => '48小时（计划）',
    			'real_hour' => 	'48小时（实际）',
    			'plan_back_num' => 	'退机商家数（计划）',
    			'real_back_num' => 	'退机商家数（实际）'
    	);
    	 
    	 
    	array_unshift($list,$arrHead);
    	 
    	create_xls($list);
    }
    
    
}
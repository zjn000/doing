<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 拜访计划管理
 */
class VisitsPlanController extends AdminBaseController{
    /**
     * 拜访计划列表
     */
    public function index(){
    	$this->search();   
    }
    
    public function search()
    {
    	$data = I('get.');
    	
    	$visitsPlanModel = D('VisitsPlan');
    	
    	//查询字符串
    	$whereStr = '';
    	//分页跳转的时候保证查询条件
    	$where_parameter = array();
    	
    	
    	//判断显示局部数据还是全部
    	if(empty($_SESSION['user']['data_range']))
    	{
    		$whereStr .= " and vp.create_id=".$_SESSION['user']['id'];
    		$where_parameter['create_id'] = $_SESSION['user']['id'];
    	}
    	else
    	{
    		if(!empty($data['create_id']))
    		{
    			$whereStr .= " and vp.create_id=".$data['create_id'];
    			$where_parameter['create_id'] = $data['create_id'];
    		}
    	}
    	
    	
    	//商家名称
    	if(!empty($data['name'])){
    		$whereStr .= " and b.name like '%{$data['name']}%'";
    		$where_parameter['name'] = $data['name'];
    	}
    	//拜访内容
    	if(!empty($data['type'])){
    		$whereStr .= " and vp.type={$data['type']}";
    		$where_parameter['type'] = $data['type'];
    	}
    	//拜访状态
    	if(!empty($data['status'])){
    		$whereStr .= " and vp.status={$data['status']}";
    		$where_parameter['status'] = $data['status'];
    	}
    	
    	 
    	//只有开始日期
    	if(!empty($data['start_date']) && empty($data['end_date'])){
    		
    		$whereStr .= " and vp.plan_time>=".strtotime($data['start_date']);
    		$where_parameter['start_date'] = $data['start_date'];
    	}
    	//只有结束日期
    	if( empty($data['start_date']) && !empty($data['end_date'])){
    		$whereStr .= " and vp.plan_time<=".strtotime($data['end_date']);
    		$where_parameter['end_date'] = $data['end_date'];
    	}
    	//开始日期-结束日期
    	if(!empty($data['start_date']) && !empty($data['end_date']))
    	{
    		$where_parameter['start_date'] = $data['start_date'];
    		$where_parameter['end_date'] = $data['end_date'];
    		$whereStr .= " and vp.plan_time between ".strtotime($data['start_date']).' and '.strtotime($data['end_date']);
    	}
    	 
    	
    	$count = $visitsPlanModel->field('vp.*,b.name,b.address,b.principal,b.phone')->alias('vp')->join('__BUSINESS__ b ON vp.business_id=b.id'.$whereStr)->count();
    	 
    	$page = new_page($count,15,$where_parameter);
    	
    	//获取列表数据
    	$list = $visitsPlanModel->field('vp.*,b.name,b.address,b.principal,b.phone')->alias('vp')->join('__BUSINESS__ b ON vp.business_id=b.id'.$whereStr)->order('create_time desc')->limit($page->firstRow.','.$page->listRows)->select();
    	
    	
    	//分页链接
    	$show = $page->show();
    	
    	//获取销售部下的所有员工姓名组
    	$userList = D('Users')->getUidsBySectorId(3);
    	//获取配置数据
    	$visitsTypeList = C('VISITS_TYPE_CONFIG');
    	
    	foreach ($list as $key=>$row)
    	{
    		$list[$key]['status_name'] = $row['status'] == 1 ? '未完成':'已完成';
    		$list[$key]['plan_time'] = $row['plan_time'] > 0 ? date('Y-m-d H:i:s',$row['plan_time']) : '';
    		$list[$key]['type'] = $visitsTypeList[$row['type']];
    		$list[$key]['nikename'] = $userList[$row['create_id']];
    	} 
    	
    	$this->assign('empty',"<tr><td colspan='10'><span class='empty'>暂时没有数据</span></td></tr>"); //数据集为空时
    	$this->assign('userList',$userList); //赋值活动负责人集合
    	$this->assign('page',$show);// 赋值分页输出
    	$this->assign('list',$list);// 赋值数据集
    	$this->display('VisitsPlan/index');
    }
    
    
    
    
    
    /**
     * 添加
     */
    public function add(){
    	if(IS_POST){
    		$data=I('post.');
    		
    		$data['plan_time'] = strtotime($data['plan_time']);
    		
    		$result = D('VisitsPlan')->addData($data);
    		
    		if($result){
    			// 操作成功
    			$this->success('添加成功',U('Admin/Business/index'));
    		}else{
    			$error_word=D('VisitsPlan')->getError();
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
    		
    	$data = I('get.');
    		
    	$map = array(
    		'id'=>$data['id']
    	);
    	
    	$status = D('VisitsPlan')->where($map)->getField('status');
    	
    	if(intval($status) > 1)
    	{
    		$this->error('已完成计划');
    		return;
    	}
    	
    	$data['status'] = 2;
    	
    	$result = D('VisitsPlan')->editData($map,$data);
    		
    	if($result){
    		// 操作成功
    		$this->success('计划完成',U('Admin/VisitsPlan/index'));
    	}else{
    		$error_word=D('VisitsPlan')->getError();
    		// 操作失败
    		$this->error($error_word);
    	}
    }
    
    
    
    /**
     * 导出数据
     */
    public function excel_out()
    {
    
    	$data = I('get.');
    
    	$visitsPlanModel = D('VisitsPlan');
    	
    	//查询字符串
    	$whereStr = '';
    	
    	//判断显示局部数据还是全部
    	if(empty($_SESSION['user']['data_range']))
    	{
    		$whereStr .= " and vp.create_id=".$_SESSION['user']['id'];
    	}
    	else
    	{
    		if(!empty($data['create_id']))
    		{
    			$whereStr .= " and vp.create_id=".$data['create_id'];
    		}
    	}
    	
    	
    	//商家名称
    	if(!empty($data['name'])){
    		$whereStr .= " and b.name like '%{$data['name']}%'";
    	}
    	//拜访内容
    	if(!empty($data['type'])){
    		$whereStr .= " and vp.type={$data['type']}";
    	}
    	//拜访状态
    	if(!empty($data['status'])){
    		$whereStr .= " and vp.status={$data['status']}";
    	}
    	 
    	//只有开始日期
    	if(!empty($data['start_date']) && empty($data['end_date'])){
    		
    		$whereStr .= " and vp.plan_time>=".strtotime($data['start_date']);
    	}
    	//只有结束日期
    	if( empty($data['start_date']) && !empty($data['end_date'])){
    		$whereStr .= " and vp.plan_time<=".strtotime($data['end_date']);
    	}
    	//开始日期-结束日期
    	if(!empty($data['start_date']) && !empty($data['end_date']))
    	{
    		$whereStr .= " and vp.plan_time between ".strtotime($data['start_date']).' and '.strtotime($data['end_date']);
    	}
    	
    	//获取列表数据
    	$list = $visitsPlanModel->field('b.name,b.address,b.principal,b.phone,vp.create_id,vp.type,vp.plan_time,vp.status')->alias('vp')->join('__BUSINESS__ b ON vp.business_id=b.id'.$whereStr)->order('vp.create_time desc')->select();
    	
    	//获取销售部下的所有员工姓名组
    	$userList = D('Users')->getUidsBySectorId(3);
    	//获取配置数据
    	$visitsTypeList = C('VISITS_TYPE_CONFIG');
    	
    	foreach ($list as $key=>$row)
    	{
    		$list[$key]['status'] = $row['status'] == 1 ? '未完成':'已完成';
    		$list[$key]['plan_time'] = $row['plan_time'] > 0 ? date('Y-m-d H:i:s',$row['plan_time']) : '';
    		$list[$key]['type'] = $visitsTypeList[$row['type']];
    		$list[$key]['create_id'] = $userList[$row['create_id']];
    	} 
    	
    
    	$arrHead = array(
    			'name' => '商家名称',
    			'address' => '商家地址',
    			'principal' => '联系人',
    			'phone' => '联系电话',
    			'create_id' => '负责BD',
    			'type' => '拜访内容',
    			'plan_time' => '计划时间',
    			'status' => '拜访状态'    			
    	);
    
    
    	array_unshift($list,$arrHead);
    
    	create_xls($list);
    }
    
    
}
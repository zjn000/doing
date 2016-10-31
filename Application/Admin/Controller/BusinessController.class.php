<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 客户信息管理
 */
class BusinessController extends AdminBaseController{
    /**
     * 客户信息列表
     */
    public function index(){
    	$this->search();   
    }
    
    /*
     * 查询搜索
     */
    public function search()
    {
    	$data = I('get.');
    	
    	$businessModel = D('Business');
    	
    	$where = array();
    	
    	//分页跳转的时候保证查询条件
    	$where_parameter = array();
    	
    	//商家名称
    	if(!empty($data['name']) ){
    		$where['name'] = array('LIKE','%'.$data['name'].'%');
    		$where_parameter['name'] = $data['name'];
    	}
    	//商区
    	if(!empty($data['district']) ){
    		$where['district'] = $data['district'];
    		$where_parameter['district'] = $data['district'];
    	}
    	
    	
    	//负责BD
    	if(!empty($data['create_id']) ){
    		$where['create_id'] = $data['create_id'];
    		$where_parameter['create_id'] = $data['create_id'];
    	}
    	
    	
    	//BD所属大区
    	if(!empty($data['region']) ){
    		$where['region'] = $data['region'];
    		$where_parameter['region'] = $data['region'];
    	}
    	
    	//签约状态
    	if(!empty($data['status']))
    	{
    		$where['status'] = $data['status'];
    		$where_parameter['status'] = $data['status'];
    	}
    	
    	//三证齐全
    	if(!empty($data['prove']))
    	{
    		$where['prove'] = $data['prove'];
    		$where_parameter['prove'] = $data['prove'];
    	}
    	
    	//合同开始日期
    	if(!empty($data['start_time'])){
    		$where['start_time'] = strtotime($data['start_time']);
    		$where_parameter['start_time'] = $data['start_time'];
    	}
    	//合同结束日期
    	if(!empty($data['end_time'])){
    		$where['end_time'] = strtotime($data['end_time']);
    		$where_parameter['end_time'] = $data['end_time'];
    	}
    	
    	//当天00:00:00
    	$day = strtotime(date('Y-m-d',time()));
    	
    	//即将到期商家
    	if(!empty($data['expiring'])){
    		
    		switch ($data['expiring'])
    		{
    			//7天内
    			case 1:
    				$where['end_time'] = array('ELT',$day+7*24*3600);
    			break;
    			
    			//一个月内
    			case 2:
    				$where['end_time'] = array('ELT',$day+30*24*3600);
    			break;
    			
    			//三个月内
    			case 3:
    				$where['end_time'] = array('ELT',$day+90*24*3600);
    			break;
    		}
    		
    		
    		$where_parameter['expiring'] = $data['expiring'];
    	
    		
    		//排除未签约
    		$where['status'] = array('IN','2,3');
    	}
    	
    	//商家套餐类型
    	if(!empty($data['package_type'])){
    		$where['package_type'] = $data['package_type'];
    		$where_parameter['package_type'] = $data['package_type'];
    	}
    	//品类
    	if(!empty($data['category'])){
    		$where['category'] = $data['category'];
    		$where_parameter['category'] = $data['category'];
    	}
    	

    	$count = $businessModel->where($where)->count();
    	
    	$page = new_page($count,15,$where_parameter);
    	
    	//获取列表数据
    	$list = $businessModel->where($where)->order('create_time desc')->limit($page->firstRow.','.$page->listRows)->select();
    	
    	
    	//分页链接
    	$show = $page->show();
    	
    	//获取销售部下的所有员工姓名组
    	$userList = D('Users')->getUidsBySectorId(3);
    	
    	//配置数据
    	$regionList = C('USER_REGION_CONFIG');
    	$contractStatusList = C('CONTRACT_STATUS_CONFIG');
    	$shopAreaList = C('ACTIVITY_AREA_CONFIG');
    	
    	foreach ($list as $key=>$row)
    	{
    		$list[$key]['district'] = $shopAreaList[$row['district']];
    		$list[$key]['nikename'] = $userList[$row['create_id']];
    		$list[$key]['region'] = $regionList[$row['region']];
    		$list[$key]['status'] = $contractStatusList[$row['status']];
    		$list[$key]['visitors_time'] = $row['visitors_time'] > 0 ? date('Y-m-d H:i:s',$row['visitors_time']) : '';
    		$list[$key]['start_time'] = $row['start_time'] > 0 ? date('Y-m-d H:i:s',$row['start_time']) : '';
    		$list[$key]['end_time'] = $row['end_time'] > 0 ? date('Y-m-d H:i:s',$row['end_time']) : '';
    		
    	}
    	
    	$this->assign('empty',"<tr><td colspan='12'><span class='empty'>暂时没有数据</span></td></tr>"); //数据集为空时
    	$this->assign('userList',$userList); //赋值负责BD集合
    	$this->assign('page',$show);// 赋值分页输出
    	$this->assign('list',$list);// 赋值数据集
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
    			$this->success('添加成功',U('Admin/Business/index'));
    		}else{
    			$error_word=D('Business')->getError();
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
    		
    		$result = D('Business')->editData($map,$data);
    		
    		if($result){
    			// 操作成功
    			$this->success('编辑成功',U('Admin/Business/index'));
    		}else{
    			$error_word=D('Business')->getError();
    			// 操作失败
    			$this->error($error_word);
    		}
    		
    	}else{
    		
    		$id = I('get.id',0,'intval');
    		$assign = M('Business')->find($id);
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
    	
    	$businessModel = D('Business');
    	
    	$where = array();
    	
    	//商家名称
    	if(!empty($data['name']) ){
    		$where['name'] = array('LIKE','%'.$data['name'].'%');
    	}
    	//商区
    	if(!empty($data['district']) ){
    		$where['district'] = $data['district'];
    	}
    	
    	
    	//负责BD
    	if(!empty($data['create_id']) ){
    		$where['create_id'] = $data['create_id'];
    	}
    	
    	
    	//BD所属大区
    	if(!empty($data['region']) ){
    		$where['region'] = $data['region'];
    	}
    	
    	//签约状态
    	if(!empty($data['status']))
    	{
    		$where['status'] = $data['status'];
    	}
    	
    	//三证齐全
    	if(!empty($data['prove']))
    	{
    		$where['prove'] = $data['prove'];
    	}
    	
    	//合同开始日期
    	if(!empty($data['start_time'])){
    		$where['start_time'] = strtotime($data['start_time']);
    	}
    	//合同结束日期
    	if(!empty($data['end_time'])){
    		$where['end_time'] = strtotime($data['end_time']);
    	}
    	
    	//当天00:00:00
    	$day = strtotime(date('Y-m-d',time()));
    	
    	//即将到期商家
    	if(!empty($data['expiring'])){
    		
    		switch ($data['expiring'])
    		{
    			//7天内
    			case 1:
    				$where['end_time'] = array('ELT',$day+7*24*3600);
    			break;
    			
    			//一个月内
    			case 2:
    				$where['end_time'] = array('ELT',$day+30*24*3600);
    			break;
    			
    			//三个月内
    			case 3:
    				$where['end_time'] = array('ELT',$day+90*24*3600);
    			break;
    		}
    		
    		
    		//排除未签约
    		$where['status'] = array('IN','2,3');
    		
    	}
    	
    	//商家套餐类型
    	if(!empty($data['package_type'])){
    		$where['package_type'] = $data['package_type'];
    	}
    	//品类
    	if(!empty($data['category'])){
    		$where['category'] = $data['category'];
    	}
    	
    	
    	//查询字段
    	$param = array('name','district','address','principal','phone','create_id','region','visitors_time','status','start_time','end_time');
    	
    	//获取列表数据
    	$list = $businessModel->field($param)->where($where)->order('create_time desc')->select();
    	
    	//获取销售部下的所有员工姓名组
    	$userList = D('Users')->getUidsBySectorId(3);
    	
    	//配置数据
    	$regionList = C('USER_REGION_CONFIG');
    	$contractStatusList = C('CONTRACT_STATUS_CONFIG');
    	$shopAreaList = C('ACTIVITY_AREA_CONFIG');
    	
    	foreach ($list as $key=>$row)
    	{
    		$list[$key]['district'] = $shopAreaList[$row['district']];
    		$list[$key]['create_id'] = $userList[$row['create_id']];
    		$list[$key]['region'] = $regionList[$row['region']];
    		$list[$key]['status'] = $contractStatusList[$row['status']];
    		$list[$key]['visitors_time'] = $row['visitors_time'] > 0 ? date('Y-m-d H:i:s',$row['visitors_time']) : '';
    		$list[$key]['start_time'] = $row['start_time'] > 0 ? date('Y-m-d H:i:s',$row['start_time']) : '';
    		$list[$key]['end_time'] = $row['end_time'] > 0 ? date('Y-m-d H:i:s',$row['end_time']) : '';
    		
    	}
    	
    	$arrHead = array(
    		'name' => '商家名称',
    		'district' => '商区',
    		'address' => '商家地址',
    		'principal' => '联系人',
    		'phone' => '联系电话',
    		'create_id' => '负责BD',
    		'region' => 'BD所属大区',
    		'visitors_time' => '最近拜访',
    		'status' => '签约状态',
    		'start_time' => '合同开始时间',
    		'end_time' => '合同结束时间'
    	);
    	
    	
    	array_unshift($list,$arrHead);
    	
 		create_xls($list);
    }
    
    
    
    /**
     * 新签
     */
    public function new_contract()
    {
    	if(IS_POST)
    	{
    		
            $data = I('post.');
            
            
            $data['start_date'] = strtotime($data['start_date']);
            $data['end_date'] = strtotime($data['end_date']);
            
            $map = array('id'=>$data['id']);
            
            
            if(empty($map['id']))
            {     
            	$result = D('NewContract')->addData($data);
            }else
            {    
            	
            	$result = D('NewContract')->editData($map,$data);
            }
            
    		if($result){
    			
    			
    			//更新商户表签约状态以及合同时间、套餐类型、三证,当签约状态为续签时，在编辑新签时不更新字段
    			$b_status = D('Business')->where(array('id'=>$data['business_id']))->getField('status');
    			
    			if($b_status < 3)
    			{
    				$param = array(
    					'status' => 2,	
    					'start_time' => $data['start_date'],	
    					'end_time' => $data['end_date'],	
    					'package_type' => $data['type'],	
    					'prove' => $data['prove']	
    				);
    				
    				D('Business')->where(array('id'=>$data['business_id']))->save($param);
    			}
    			
    			
    			// 操作成功
    			$this->success('编辑成功',U('Admin/Business/index'));
    		}else{
    			$error_word=D('NewContract')->getError();
    			// 操作失败
    			$this->error($error_word);
    		}
        }
        else
        {
        	
            $business_id = I('get.id');
            
            $obj = array();
            
            $obj = D('NewContract')->getByBusiness_id($business_id);
            
            //判断是否有新签
            if(empty($obj))
            {
            	//没有，实例模板显示默认值
            	$obj = array(
            			'id' => '',	
            			'protocol_no' => '',
            			'title' => '',
            			'type' => 1,
            			'deposit' => '',
            			'toll' => '',
            			'draw_points' => '',
            			'start_date' => '',
            			'end_date' => '',
            			'contractor' => '',
            			'phone' => '',
            			'accout_holder' => '',
            			'bank' => '',
            			'bank_no' => '',
            			'prove' => 2
            	);
            }
            $obj['start_date'] = date('Y-m-d',$obj['start_date']);
            $obj['end_date'] = date('Y-m-d',$obj['end_date']);
            $this->assign('obj',$obj);
            $this->display();
        }
    }
    
    
    /**
     * 续签
     */
    public function renewal_contract()
    {
    	if(IS_POST)
    	{
    	
    		$data = I('post.');
    	
    	
    		$data['start_date'] = strtotime($data['start_date']);
    		$data['end_date'] = strtotime($data['end_date']);
    	
    		$map = array('id'=>$data['id']);
    	
    	
    		if(empty($map['id']))
    		{
    			$result = D('RenewalContract')->addData($data);
    		}else
    		{
    			 
    			$result = D('RenewalContract')->editData($map,$data);
    		}
    	
    	
    		if($result){
    			 
    			$param = array(
    				'status' => 3,
    				'start_time' => $data['start_date'],
    				'end_time' => $data['end_date'],
    				'package_type' => $data['type'],
    				'prove' => $data['prove']
    			);
    	
    			D('Business')->where(array('id'=>$data['business_id']))->save($param);
    			 
    			// 操作成功
    			$this->success('编辑成功',U('Admin/Business/index'));
    		}else{
    			$error_word=D('RenewalContract')->getError();
    			// 操作失败
    			$this->error($error_word);
    		}
    	}
    	else
    	{
    		 
    		$business_id = I('get.id');
    	
    		$obj = array();
    	
    		$obj = D('RenewalContract')->getByBusiness_id($business_id);
    	
    		//判断是否有新签
    		if(empty($obj))
    		{
    			//没有，实例模板显示默认值
    			$obj = array(
    					'id' => '',
    					'protocol_no' => '',
    					'title' => '',
    					'type' => 1,
    					'deposit' => '',
    					'toll' => '',
    					'draw_points' => '',
    					'start_date' => '',
    					'end_date' => '',
    					'contractor' => '',
    					'phone' => '',
    					'accout_holder' => '',
    					'bank' => '',
    					'bank_no' => '',
    					'prove' => 2
    			);
    		}
    		$obj['start_date'] = date('Y-m-d',$obj['start_date']);
    		$obj['end_date'] = date('Y-m-d',$obj['end_date']);
    		$this->assign('obj',$obj);
    		$this->display();
    	}
    }
    
    
}
<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;

/**
 * 广告管理Controller
 */
class AdsController extends AdminBaseController{
	
	
	/**
	 * 首页
	 */
	public function index(){
		
		$this->search();
	}

	
	public function search()
	{
		
		$data = I('get.');
    	
    	$adsModel = D('Ads');
    	
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
    	
    	
    	
    	//商家编号
    	if(!empty($data['b_no']) ){
    		$where['b_no'] = array('LIKE','%'.$data['b_no'].'%');
    		$where_parameter['b_no'] = $data['b_no'];
    	}
    	
    	//商家名称
    	if(!empty($data['b_name']) ){
    		$where['b_name'] = array('LIKE','%'.$data['b_name'].'%');
    		$where_parameter['b_name'] = $data['b_name'];
    	}
    	
    	//审核状态
    	if($data['status']!='')
    	{
    		$where['status'] = $data['status'];
    		$where_parameter['status'] = $data['status'];
    	}
    	
    	//到账状态
    	if(!empty($data['account_state']) ){
    		$where['account_state'] = $data['account_state'];
    		$where_parameter['account_state'] = $data['account_state'];
    	}
    	
    	
    	//上线状态
    	if(!empty($data['line_state']) ){
    		$where['line_state'] = $data['line_state'];
    		$where_parameter['line_state'] = $data['line_state'];
    	}
    	 
    	
    	
    	
    	$count = $adsModel->where($where)->count();
    	
    	$page = new_page($count,15,$where_parameter);
    	
    	//获取列表数据
    	$list = $adsModel->where($where)->order('create_time desc')->limit($page->firstRow.','.$page->listRows)->select();
    	
    	
    	//分页链接
    	$show = $page->show();
    	
    	//获取销售部下的所有员工姓名组
    	$userList = D('Users')->getUidsBySectorId(3);
    	
    	
    	//配置数据
    	$districtList = C('ACTIVITY_AREA_CONFIG');//商区
    	
    	foreach ($list as $key=>$row)
    	{
     		$list[$key]['district_title'] = $districtList[$row['b_district']];
     		$list[$key]['nikename'] = $userList[$row['create_id']];
     		$list[$key]['status_title'] = $row['status'] == 0 ? '待审核' : ($row['status'] == 1 ? '审核成功' : '无效作废');
     		$list[$key]['line_title'] = $row['line_state'] == 1 ? '已上线' : '未上线';
     		$list[$key]['arrived_title'] = $row['account_state'] == 1 ? '已到账' : '未到账';
    	}
    	
    	$this->assign('empty',"<tr><td colspan='14'><span class='empty'>暂时没有数据</span></td></tr>"); //数据集为空时
    	$this->assign('userList',$userList); //赋值负责BD集合
    	$this->assign('page',$show);// 赋值分页输出
    	$this->assign('list',$list);// 赋值数据集
		$this->display('Ads/index');
	}
    
	
	/**
	 * 待审核列表
	 */
	public function pending_review()
	{
		$adsModel = D('Ads');
			
		$where = array('status'=>0);
			
		$count = $adsModel->where($where)->count();
			
		$page = new_page($count,15);
			
		//获取列表数据
		$list = $adsModel->where($where)->order('create_time desc')->limit($page->firstRow.','.$page->listRows)->select();
			
			
		//分页链接
		$show = $page->show();
			
		//获取销售部下的所有员工姓名组
    	$userList = D('Users')->getUidsBySectorId(3);
    	
    	
    	//配置数据
    	$districtList = C('ACTIVITY_AREA_CONFIG');//商区
    	
    	foreach ($list as $key=>$row)
    	{
     		$list[$key]['district_title'] = $districtList[$row['b_district']];
     		$list[$key]['nikename'] = $userList[$row['create_id']];
     		$list[$key]['status_title'] = $row['status'] == 0 ? '待审核' : ($row['status'] == 1 ? '审核成功' : '无效作废');
     		$list[$key]['line_title'] = $row['line_state'] == 1 ? '已上线' : '未上线';
     		$list[$key]['arrived_title'] = $row['account_state'] == 1 ? '已到账' : '未到账';
    	}
    	
    	$this->assign('empty',"<tr><td colspan='14'><span class='empty'>暂时没有数据</span></td></tr>"); //数据集为空时
    	$this->assign('userList',$userList); //赋值负责BD集合
    	$this->assign('page',$show);// 赋值分页输出
    	$this->assign('list',$list);// 赋值数据集
		$this->display('Ads/pending_review');
	}
	
	
	/**
	 * 待收账
	 */
	public function pending_account()
	{
		$adsModel = D('Ads');
			
		$where = array('status'=>1,'account_state'=>2);
			
		$count = $adsModel->where($where)->count();
			
		$page = new_page($count,15);
			
		//获取列表数据
		$list = $adsModel->where($where)->order('create_time desc')->limit($page->firstRow.','.$page->listRows)->select();
			
			
		//分页链接
		$show = $page->show();
			
		//获取销售部下的所有员工姓名组
    	$userList = D('Users')->getUidsBySectorId(3);
    	
    	
    	//配置数据
    	$districtList = C('ACTIVITY_AREA_CONFIG');//商区
    	
    	foreach ($list as $key=>$row)
    	{
     		$list[$key]['district_title'] = $districtList[$row['b_district']];
     		$list[$key]['nikename'] = $userList[$row['create_id']];
     		$list[$key]['status_title'] = $row['status'] == 0 ? '待审核' : ($row['status'] == 1 ? '审核成功' : '无效作废');
     		$list[$key]['line_title'] = $row['line_state'] == 1 ? '已上线' : '未上线';
     		$list[$key]['arrived_title'] = $row['account_state'] == 1 ? '已到账' : '未到账';
    	}
    	
    	$this->assign('empty',"<tr><td colspan='14'><span class='empty'>暂时没有数据</span></td></tr>"); //数据集为空时
    	$this->assign('userList',$userList); //赋值负责BD集合
    	$this->assign('page',$show);// 赋值分页输出
    	$this->assign('list',$list);// 赋值数据集
		$this->display('Ads/pending_account');
	}
	
	
	/**
	 * 待上线
	 */
	public function pending_line()
	{
		$adsModel = D('Ads');
			
		$where = array('status'=>1,'account_state'=>1,'line_state'=>2);
			
		$count = $adsModel->where($where)->count();
			
		$page = new_page($count,15);
			
		//获取列表数据
		$list = $adsModel->where($where)->order('create_time desc')->limit($page->firstRow.','.$page->listRows)->select();
			
			
		//分页链接
		$show = $page->show();
			
		//获取销售部下的所有员工姓名组
    	$userList = D('Users')->getUidsBySectorId(3);
    	
    	
    	//配置数据
    	$districtList = C('ACTIVITY_AREA_CONFIG');//商区
    	
    	foreach ($list as $key=>$row)
    	{
     		$list[$key]['district_title'] = $districtList[$row['b_district']];
     		$list[$key]['nikename'] = $userList[$row['create_id']];
     		$list[$key]['status_title'] = $row['status'] == 0 ? '待审核' : ($row['status'] == 1 ? '审核成功' : '无效作废');
     		$list[$key]['line_title'] = $row['line_state'] == 1 ? '已上线' : '未上线';
     		$list[$key]['arrived_title'] = $row['account_state'] == 1 ? '已到账' : '未到账';
    	}
    	
    	$this->assign('empty',"<tr><td colspan='14'><span class='empty'>暂时没有数据</span></td></tr>"); //数据集为空时
    	$this->assign('userList',$userList); //赋值负责BD集合
    	$this->assign('page',$show);// 赋值分页输出
    	$this->assign('list',$list);// 赋值数据集
		$this->display('Ads/pending_line');
	}
	
	
	/**
	 * 添加
	 */
	public function add(){
		if(IS_POST){
			$data=I('post.');
			$result = D('Ads')->addData($data);
			if($result){
				// 操作成功
				$this->success('添加成功',U('Admin/Ads/index'));
			}else{
				$error_word=D('Ads')->getError();
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
	
			$result = D('Ads')->editData(array('id'=>$data['id']),$data);
	
			if($result){
				// 操作成功
				$this->success('编辑成功',U('Admin/Ads/index'));
			}else{
				$error_word=D('Ads')->getError();
				// 操作失败
				$this->error($error_word);
			}
	
		}
		else
		{
	
			$id = I('get.id',0,'intval');
			$assign = M('Ads')->find($id);
			$this->assign('assign',$assign);
			$this->display('Ads/edit');
			
			
		}
	}
	
	/**
	 * 查看详情
	 */
	public function view_ads()
	{
		$id = I('get.id',0,'intval');
		$assign = M('Ads')->find($id);
		
		$districtList = C('ACTIVITY_AREA_CONFIG');//商区
		$assign['b_district'] = $districtList[$assign['b_district']];
		$assign['is_submit'] = $assign['is_submit'] == 1 ? '已提交' : '否';
		
		$this->assign('assign',$assign);
		$this->display('Ads/view_ads');
	}
	
	
	/**
	 * 审核操作
	 */
	public function ustatus()
	{
		if(IS_POST){
	
			$data=I('post.');
	
			$map = array(
				'id'=>$data['id']
			);
	
			$result = D('Ads')->editData($map,$data);
	
			if($result){
				// 操作成功
				$this->success('编辑成功',U('Admin/Ads/pending_review'));
			}else{
				$error_word=D('Ads')->getError();
				// 操作失败
				$this->error($error_word);
			}
	
		}
	}
	
	
	
	/**
	 * 确认到账
	 */
	public function confirm_account()
	{
		$data=I('get.');
    	
    	$result = D('Ads')->editData(array('id'=>$data['id']),array('id'=>$data['id'],'account_state'=>1));
    	
    	if($result){
    		// 操作成功
    		$this->success('已确认到账',U('Admin/Ads/pending_account'));
    	}else{
    		$error_word=D('Ads')->getError();
    		// 操作失败
    		$this->error($error_word);
    	}
	}
	
	
	/**
	 * 确认上线
	 */
	public function on_line()
	{
		$data=I('get.');
    	
    	$result = D('Ads')->editData(array('id'=>$data['id']),array('id'=>$data['id'],'line_state'=>1));
    	
    	if($result){
    		// 操作成功
    		$this->success('已确认到账',U('Admin/Ads/pending_line'));
    	}else{
    		$error_word=D('Ads')->getError();
    		// 操作失败
    		$this->error($error_word);
    	}
	}
	
	
	
	
	/**
	 * 数据导出
	 */
	public function excel_out()
	{
		$data = I('get.');
		 
		$adsModel = D('Ads');
		 
		$where=array();
		
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
    	
    	
    	
    	//商家编号
    	if(!empty($data['b_no']) ){
    		$where['b_no'] = array('LIKE','%'.$data['b_no'].'%');
    	}
    	
    	//商家名称
    	if(!empty($data['b_name']) ){
    		$where['b_name'] = array('LIKE','%'.$data['b_name'].'%');
    	}
    	
    	//审核状态
    	if($data['status']!='')
    	{
    		$where['status'] = $data['status'];
    	}
    	
    	//到账状态
    	if(!empty($data['account_state']) ){
    		$where['account_state'] = $data['account_state'];
    	}
    	
    	
    	//上线状态
    	if(!empty($data['line_state']) ){
    		$where['line_state'] = $data['line_state'];
    	}
    	 
    	$list = $adsModel->field('id,create_time,modify_id,modify_time',true)->where($where)->order('create_time desc')->select();
    	
    	
    	//获取销售部下的所有员工姓名组
    	$userList = D('Users')->getUidsBySectorId(3);
    	
    	
    	//配置数据
    	$districtList = C('ACTIVITY_AREA_CONFIG');//商区
    	
    	foreach ($list as $key=>$row)
    	{
     		$list[$key]['b_district'] = $districtList[$row['b_district']];
     		$list[$key]['create_id'] = $userList[$row['create_id']];
     		$list[$key]['status'] = $row['status'] == 0 ? '待审核' : ($row['status'] == 1 ? '审核成功' : '无效作废');
     		$list[$key]['line_state'] = $row['line_state'] == 1 ? '已上线' : '未上线';
     		$list[$key]['account_state'] = $row['account_state'] == 1 ? '已到账' : '未到账';
     		$list[$key]['is_submit'] = $row['is_submit'] == 1 ? '已提交' : '否';
    	}
		
		
		$arrHead = array(
				'b_no' => '商家编号',
				'b_name' => '店铺名称',
				'b_district' => '商区',
				'coordinate' => '定位',
				'range' => '投放范围',
				'time_period' => '投放时间段',
				'price' => '原价',
				'is_submit' => '资料是否提交',
				'start_date' => '活动开始日期',
				'end_date' => '活动结束日期',
				'remark' => '商务部协助事项',
				'status' => '审核状态',
				'account_state' => '广告费是否到账',
				'line_state' => '上线状态',
				'create_id' => '签约人员'
		);
		 
		array_unshift($list,$arrHead);
		
		//p($list);
		
		create_xls($list,'广告'.date('Y-m-d',time()));
		
	}
	
	
	
	

}
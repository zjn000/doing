<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 活动管理
 */
class ActivityController extends AdminBaseController{
    /**
     * 活动信息列表
     */
    public function index(){
    	$this->search();   
    }
    
    public function search()
    {
    	$data = I('get.');
    	
    	$activityModel = M('Activity');
    	
    	$where = array();
    	 
    	//分页跳转的时候保证查询条件
    	$where_parameter = array();
    	 
    	//活动名称
    	if(!empty($data['activity_name'])){
    		$where['activity_name'] = array('LIKE',$data['activity_name'].'%');
    		$where_parameter['activity_name'] = $data['activity_name'];
    	}
    	//活动地点
    	if(!empty($data['activity_location'])){
    		$where['activity_location'] = array('LIKE','%'.$data['activity_location'].'%');
    		$where_parameter['activity_location'] = $data['activity_location'];
    	}
    	 
    	//活动负责人
    	if(!empty($data['activity_leader_id'])){
    		$where['activity_leader_id'] = $data['activity_leader_id'];
    		$where_parameter['activity_leader_id'] = $data['activity_leader_id'];
    	}
    	
    	//商家名称
    	if(!empty($data['business_name']) ){
    		$where['business_name'] = array('LIKE','%'.$data['business_name'].'%');
    		$where_parameter['business_name'] = $data['business_name'];
    	}
    	//商家优惠
    	if(!empty($data['business_deals'])){
    		$where['business_deals'] = array('LIKE','%'.$data['business_deals'].'%');
    		$where_parameter['business_deals'] = $data['business_deals'];
    	}
    	//所属区域
    	if(!empty($data['activity_area'])){
    		$where['activity_area'] = $data['activity_area'];
    		$where_parameter['activity_area'] = $data['activity_area'];
    	}
    	
    	//活动方式
    	if(!empty($data['activity_mode'])){
    		$where['activity_mode'] = array('LIKE','%'.$data['activity_mode'].'%');
    		$where_parameter['activity_mode'] = $data['activity_mode'];
    	}
    	 
    	//只有开始日期
    	if(!empty($data['start_date']) && empty($data['end_date'])){
    		$where['activity_date'] = array('EGT',strtotime($data['start_date']));
    		$where_parameter['start_date'] = $data['start_date'];
    	}
    	//只有结束日期
    	if( empty($data['start_date']) && !empty($data['end_date'])){
    		$where['activity_date'] = array('ELT',strtotime($data['end_date'].' 23:59:59'));
    		$where_parameter['end_date'] = $data['end_date'];
    	}
    	//开始日期-结束日期
    	if(!empty($data['start_date']) && !empty($data['end_date']))
    	{
    		$where_parameter['start_date'] = $data['start_date'];
    		$where_parameter['end_date'] = $data['end_date'];
    		$where['activity_date'] = array(array('EGT',strtotime($data["start_date"])),array('ELT',strtotime($data["end_date"].' 23:59:59')),'AND');
    	}
    	 
    	$count = $activityModel->where($where)->count();
    	 
    	$page = new_page($count,15,$where_parameter);
    	
    	//获取列表数据
    	$list = $activityModel->where($where)->order('create_time desc')->limit($page->firstRow.','.$page->listRows)->select();
    	//分页链接
    	$show = $page->show();
    	
    	
    	//获取推广部下的所有员工姓名组
    	$userList = D('Users')->getUidsBySectorId(2);
    	
    	
    	$activity_area = C('ACTIVITY_AREA_CONFIG');
    	$activity_duration = C('ACTIVITY_DURATION_CONFIG');
    	foreach ($list as $k=>$row)
    	{
    		$list[$k]['activity_date'] = $row['activity_date'] == 0 ? '' : date("Y-m-d",$row['activity_date']);
    		$list[$k]['activity_area'] = $activity_area[$row['activity_area']];    		 		
    	}
    	 
    	 
    	
    	$this->assign('empty',"<tr><td colspan='13'><span class='empty'>暂时没有数据</span></td></tr>"); //数据集为空时
    	$this->assign('userList',$userList); //赋值活动负责人集合
    	$this->assign('page',$show);// 赋值分页输出
    	$this->assign('list',$list);// 赋值数据集
    	$this->display('Activity/index');
    }
    
    
    
    
    
    /**
     * 添加
     */
    public function add(){
    	if(IS_POST){
    		$data=I('post.');
    		$result = D('Activity')->addData($data);
    		if($result){
    			// 操作成功
    			$this->success('添加成功',U('Admin/Activity/index'));
    		}else{
    			$error_word=D('Activity')->getError();
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
    		
    		$result = D('Activity')->editData($map,$data);
    		
    		if($result){
    			// 操作成功
    			$this->success('编辑成功',U('Admin/Activity/index'));
    		}else{
    			$error_word=D('Activity')->getError();
    			// 操作失败
    			$this->error($error_word);
    		}
    		
    	}else{
    		
    		$id = I('get.id',0,'intval');
    		
    		$assign = M('Activity')->find($id);
    	
    		$assign['activity_date'] = date('Y-m-d H:i:s',$assign['activity_date']);
    		$assign['activity_edate'] = date('Y-m-d H:i:s',$assign['activity_edate']);
    		
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
    	 
    	//活动名称
    	if(!empty($data['activity_name'])){
    		$where['activity_name'] = array('LIKE',$data['activity_name'].'%');
    	}
    	//活动地点
    	if(!empty($data['activity_location'])){
    		$where['activity_location'] = array('LIKE','%'.$data['activity_location'].'%');
    	}
    	 
    	//活动负责人
    	if(!empty($data['activity_leader_id'])){
    		$where['activity_leader_id'] = $data['activity_leader_id'];
    	}
    	
    	//商家名称
    	if(!empty($data['business_name']) ){
    		$where['business_name'] = array('LIKE','%'.$data['business_name'].'%');
    	}
    	//商家优惠
    	if(!empty($data['business_deals'])){
    		$where['business_deals'] = array('LIKE','%'.$data['business_deals'].'%');
    	}
    	//所属区域
    	if(!empty($data['activity_area'])){
    		$where['activity_area'] = $data['activity_area'];
    	}
    	
    	//活动方式
    	if(!empty($data['activity_mode'])){
    		$where['activity_mode'] = array('LIKE','%'.$data['activity_mode'].'%');
    	}
    	 
    	//只有开始时间
    	if(!empty($data['start_date']) && empty($data['end_date'])){
    		$where['activity_date'] = array('EGT',strtotime($data['start_date']));
    	}
    	//只有结束时间
    	if( empty($data['start_date']) && !empty($data['end_date'])){
    		$where['activity_date'] = array('ELT',strtotime($data['end_date'].' 23:59:59'));
    	}
    	//开始时间-结束时间
    	if(!empty($data['start_date']) && !empty($data['end_date']))
    	{
    		$where['activity_date'] = array(array('EGT',strtotime($data["start_date"])),array('ELT',strtotime($data["end_date"].' 23:59:59')),'AND');
    	}
    	
    	
    	$list = D('Activity')->getAllData($where);
    	
    	$activity_area = C('ACTIVITY_AREA_CONFIG');
    	$activity_duration = C('ACTIVITY_DURATION_CONFIG');
    	$activity_period = C('ACTIVITY_PERIOD_CONFIG');
    	
    	foreach ($list as $k=>$row)
    	{
    		$list[$k]['activity_date'] = $row['activity_date'] == 0 ? '' : date("Y-m-d H:i:s",$row['activity_date']);
    		$list[$k]['activity_edate'] = $row['activity_edate'] == 0 ? '' : date("Y-m-d H:i:s",$row['activity_edate']);
    		$list[$k]['activity_area'] = $activity_area[$row['activity_area']];
    	}
    	   	
    	
    	$arrHead = array(
    		'activity_name' => '活动名称',
            'activity_location' => '活动地点',
            'activity_date' => '活动开始时间',
            'activity_edate' => '活动结束时间',
            'activity_leader' => '活动负责人',
            'activity_mode' => '活动方式',
            'activity_area' => '所属区域',
            'business_deals' => '商家优惠',
            'business_name' => '商家名称',
            'business_address' => '商家地址',
            'business_contacts' => '商家联系人',
            'business_tel' => '商家联系电话',
            'new_user_number' => '新用户数量',
            'old_user_number'=> '老用户数量',
            'flyer_number' => '传单数量',
            'poster_number' => '海报数量',
            'part_number' => '兼职人数',
            'gift_number' => '礼品数量',
            'part_time' => '兼职工时',
            'staff_costs' => '人员费用',
            'feedback' => 	'反馈'
    	);
    	
    	
    	array_unshift($list,$arrHead);
    	
 		create_xls($list);
    }
    
    
    
    
    
}
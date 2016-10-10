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
    	//活动时段：上午，下午，晚上
    	if(!empty($data['activity_period'])){
    		$where['activity_period'] = $data['activity_period'];
    		$where_parameter['activity_period'] = $data['activity_period'];
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
    	//活动时长：三小时，四小时
    	if(!empty($data['activity_duration'])){
    		$where['activity_duration'] = $data['activity_duration'];
    		$where_parameter['activity_duration'] = $data['activity_duration'];
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
    		$where['activity_date'] = array('ELT',strtotime($data['end_date']));
    		$where_parameter['end_date'] = $data['end_date'];
    	}
    	//开始日期-结束日期
    	if(!empty($data['start_date']) && !empty($data['end_date']))
    	{
    		$where_parameter['start_date'] = $data['start_date'];
    		$where_parameter['end_date'] = $data['end_date'];
    		$where['activity_date'] = array(array('EGT',strtotime($data["start_date"])),array('ELT',strtotime($data["end_date"])),'AND');
    	}
    	 
    	$count = $activityModel->where($where)->count();
    	 
    	$page = new_page($count,15,$where_parameter);
    	
    	//获取列表数据
    	$list = $activityModel->where($where)->order('create_time desc')->limit($page->firstRow.','.$page->listRows)->select();
    	//分页链接
    	$show = $page->show();
    	 
    	//获取管理员id集合
    	$uids = D('AuthGroupAccess')->getUidsByGroupId(array('NEQ',1));
    	 
    	//键值重复反转，去重
    	$uids = array_flip($uids);
    	$uids = array_flip($uids);
    	 
    	//获取列表管理员姓名组
    	$user_list = D('Users')->field('id,nikename')->where(array('id'=>array('IN',$uids)))->select();
    	$userList = array();
    	foreach ($user_list as $row)
    	{
    		$userList[$row['id']] = $row['nikename'];
    	}
    	 
    	$activity_area = C('ACTIVITY_AREA_CONFIG');
    	$activity_duration = C('ACTIVITY_DURATION_CONFIG');
    	foreach ($list as $k=>$row)
    	{
    		$list[$k]['activity_date'] = $row['activity_date'] == 0 ? '' : date("Y-m-d",$row['activity_date']);
    		$list[$k]['activity_area'] = $activity_area[$row['activity_area']];
    		$list[$k]['activity_duration'] = $activity_duration[$row['activity_duration']];
    		//$list[$k]['new_user_number'] = $row['new_user_number'] == 0 ? '' : $row['new_user_number'];
    		//$list[$k]['old_user_number'] = $row['old_user_number'] == 0 ? '' : $row['old_user_number'];
    		//$list[$k]['flyer_number'] = $row['flyer_number'] == 0 ? '' : $row['flyer_number'];
    		//$list[$k]['poster_number'] = $row['poster_number'] == 0 ? '' : $row['poster_number'];
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
    	
    		$assign['activity_date'] = date('Y-m-d',$assign['activity_date']);
    		
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
    	//活动时段：上午，下午，晚上
    	if(!empty($data['activity_period'])){
    		$where['activity_period'] = $data['activity_period'];
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
    	//活动时长：三小时，四小时
    	if(!empty($data['activity_duration'])){
    		$where['activity_duration'] = $data['activity_duration'];
    	}
    	//活动方式
    	if(!empty($data['activity_mode'])){
    		$where['activity_mode'] = array('LIKE','%'.$data['activity_mode'].'%');
    	}
    	 
    	//只有开始日期
    	if(!empty($data['start_date']) && empty($data['end_date'])){
    		$where['activity_date'] = array('EGT',strtotime($data['start_date']));
    	}
    	//只有结束日期
    	if( empty($data['start_date']) && !empty($data['end_date'])){
    		$where['activity_date'] = array('ELT',strtotime($data['end_date']));
    	}
    	//开始日期-结束日期
    	if(!empty($data['start_date']) && !empty($data['end_date']))
    	{
    		$where['activity_date'] = array(array('EGT',strtotime($data["start_date"])),array('ELT',strtotime($data["end_date"])),'AND');
    	}
    	
    	
    	$list = D('Activity')->getAllData($where);
    	
    	$activity_area = C('ACTIVITY_AREA_CONFIG');
    	$activity_duration = C('ACTIVITY_DURATION_CONFIG');
    	$activity_period = C('ACTIVITY_PERIOD_CONFIG');
    	
    	foreach ($list as $k=>$row)
    	{
    		$list[$k]['activity_date'] = $row['activity_date'] == 0 ? '' : date("Y-m-d",$row['activity_date']);
    		$list[$k]['activity_area'] = $activity_area[$row['activity_area']];
    		$list[$k]['activity_duration'] = $activity_duration[$row['activity_duration']];
    		$list[$k]['activity_period'] = $activity_period[$row['activity_period']];
    		//$list[$k]['new_user_number'] = $row['new_user_number'] == 0 ? '' : $row['new_user_number'];
    		//$list[$k]['old_user_number'] = $row['old_user_number'] == 0 ? '' : $row['old_user_number'];
    		//$list[$k]['flyer_number'] = $row['flyer_number'] == 0 ? '' : $row['flyer_number'];
    		//$list[$k]['poster_number'] = $row['poster_number'] == 0 ? '' : $row['poster_number'];
    		//$list[$k]['part_number'] = $row['part_number'] == 0 ? '' : $row['part_number'];
    		//$list[$k]['gift_number'] = $row['gift_number'] == 0 ? '' : $row['gift_number'];
    		//$list[$k]['part_time'] = $row['part_time'] == 0 ? '' : $row['part_time'];
    		//$list[$k]['staff_costs'] = $row['staff_costs'] == 0 ? '' : $row['staff_costs'];
    	}
    	   	
    	
    	$arrHead = array(
    		'activity_name' => '活动名称',
            'activity_location' => '活动地点',
            'activity_period' => '活动时段',
            'activity_date' => '活动日期',
            'activity_leader' => '活动负责人',
            'activity_mode' => '活动方式',
            'activity_area' => '所属区域',
            'activity_duration' => '活动时长',
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
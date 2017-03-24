<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
use Think\Model;
/**
 * 合同管理Controller
 */
class ContractController extends AdminBaseController{
	
	
	/**
	 * 首页
	 */
	public function index(){
		
		$this->search();
	}

	
	public function search()
	{
		
		$data = I('get.');
    	
    	$contractModel = D('Contract');
    	
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
    	
    	
    	
    	//商家名称
    	if(!empty($data['b_name']) ){
    		$where['b_name'] = array('LIKE','%'.$data['b_name'].'%');
    		$where_parameter['b_name'] = $data['b_name'];
    	}
    	
    	
    	//收费状态
    	if(!empty($data['is_toll']) ){
    		$where['is_toll'] = $data['is_toll'];
    		$where_parameter['is_toll'] = $data['is_toll'];
    	}
    	
    	
    	
    	//证件
    	if($data['certificate_id']!='')
    	{
    		//已上传
    		if($data['certificate_id'] == 1)
    		{
    			$where['certificate_id'] = array('GT',0);
    			$where_parameter['certificate_id'] = 1;
    		}
    		
    		//未上传
    		if($data['certificate_id'] == 2)
    		{
    			$where['certificate_id'] = 0;
    			$where_parameter['certificate_id'] = 2;
    		}
    	}
    	
    	
    	//协议编号
    	if(!empty($data['protocol_number']) ){
    		$where['protocol_number'] = array('LIKE','%'.$data['protocol_number']);
    		$where_parameter['protocol_number'] = $data['protocol_number'];
    	}
    	
    	
    	//合同类型
    	if(!empty($data['type']) ){
    		$where['type'] = $data['type'];
    		$where_parameter['type'] = $data['type'];
    	}
    	
    	//审核状态
    	if($data['status']!='')
    	{
    		$where['status'] = $data['status'];
    		$where_parameter['status'] = $data['status'];
    	}
    	
    	//签约类型
    	if(!empty($data['signed_type']) ){
    		$where['signed_type'] = $data['signed_type'];
    		$where_parameter['signed_type'] = $data['signed_type'];
    	}
    	
    	
    	//到账状态
    	if(!empty($data['has_arrived']) ){
    		$where['has_arrived'] = $data['has_arrived'];
    		$where_parameter['has_arrived'] = $data['has_arrived'];
    	}
    	
    	
    	$count = $contractModel->where($where)->count();
    	
    	$page = new_page($count,15,$where_parameter);
    	
    	//获取列表数据
    	$list = $contractModel->where($where)->order('create_time desc')->limit($page->firstRow.','.$page->listRows)->select();
    	
    	
    	//分页链接
    	$show = $page->show();
    	
    	//获取销售部下的所有员工姓名组
    	$userList = D('Users')->getUidsBySectorId(3);
    	
    	
    	//配置数据
    	$contractTypeList = C('CONTRACT_TYPE_CONFIG');
    	$signedTypeList = C('SIGNED_TYPE_CONFIG');
    	
    	foreach ($list as $key=>$row)
    	{
     		$list[$key]['type'] = $contractTypeList[$row['type']];
     		$list[$key]['signed_type_name'] = $signedTypeList[$row['signed_type']];
     		$list[$key]['nikename'] = $userList[$row['create_id']];
     		$list[$key]['create_time'] = $row['create_time'] > 0 ? date('Y-m-d',$row['create_time']) : '';
     		$list[$key]['status_name'] = $row['status'] == 0 ? '待审核' : ($row['status'] == 1 ? '有效归档' : '无效退回');
     		$list[$key]['is_toll_title'] = $row['is_toll'] == 1 ? '已收费' : '未收费';
     		$list[$key]['has_arrived_title'] = $row['has_arrived'] == 1 ? '已到账' : '未到账';
     		$list[$key]['certificate'] = $row['certificate_id'] > 0 ? '已上传' : '未上传';
    	}
    	
    	$this->assign('empty',"<tr><td colspan='14'><span class='empty'>暂时没有数据</span></td></tr>"); //数据集为空时
    	$this->assign('userList',$userList); //赋值负责BD集合
    	$this->assign('page',$show);// 赋值分页输出
    	$this->assign('list',$list);// 赋值数据集
		$this->display('Contract/index');
	}
    
	
	
	/**
	 * 待收账
	 */
	public function pending_account()
	{
		$contractModel = D('Contract');
			
		$where = array('has_arrived'=>2,'status'=>0,'is_toll'=>1);
			
		$count = $contractModel->where($where)->count();
			
		$page = new_page($count,15);
			
		//获取列表数据
		$list = $contractModel->where($where)->order('create_time desc')->limit($page->firstRow.','.$page->listRows)->select();
			
			
		//分页链接
		$show = $page->show();
			
		//获取销售部下的所有员工姓名组
		$userList = D('Users')->getUidsBySectorId(3);
			
			
		//配置数据
		$contractTypeList = C('CONTRACT_TYPE_CONFIG');
		$signedTypeList = C('SIGNED_TYPE_CONFIG');
	
		foreach ($list as $key=>$row)
		{
			$list[$key]['type'] = $contractTypeList[$row['type']];
			$list[$key]['signed_type_name'] = $signedTypeList[$row['signed_type']];
			$list[$key]['nikename'] = $userList[$row['create_id']];
			$list[$key]['create_time'] = $row['create_time'] > 0 ? date('Y-m-d',$row['create_time']) : '';
			$list[$key]['status_name'] = $row['status'] == 0 ? '待审核' : ($row['status'] == 1 ? '有效归档' : '无效退回');
			$list[$key]['is_toll_title'] = $row['is_toll'] == 1 ? '已收费' : '未收费';
			$list[$key]['has_arrived_title'] = $row['has_arrived'] == 1 ? '已到账' : '未到账';
			$list[$key]['certificate'] = $row['certificate_id'] > 0 ? '已上传' : '未上传';
		}
			
		$this->assign('empty',"<tr><td colspan='14'><span class='empty'>暂时没有数据</span></td></tr>"); //数据集为空时
		$this->assign('userList',$userList); //赋值负责BD集合
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('list',$list);// 赋值数据集
		$this->display('Contract/pending_account');
	}
	
	
	/**
	 * 待审核列表
	 */
	public function pending_index()
	{
		$contractModel = D('Contract');
		 
		$where = array('has_arrived'=>1,'status'=>0,'is_toll'=>1,array('_logic'=>'or','certificate_id'=>array('GT',0),'signed_type' => array('GT',1)));
		 
		$count = $contractModel->where($where)->count();
		 
		$page = new_page($count,15);
		 
		//获取列表数据
		$list = $contractModel->where($where)->order('create_time desc')->limit($page->firstRow.','.$page->listRows)->select();
		 
		 
		//分页链接
		$show = $page->show();
		 
		//获取销售部下的所有员工姓名组
		$userList = D('Users')->getUidsBySectorId(3);
		 
		 
		//配置数据
		$contractTypeList = C('CONTRACT_TYPE_CONFIG');
		$signedTypeList = C('SIGNED_TYPE_CONFIG');
		
		foreach ($list as $key=>$row)
		{
			$list[$key]['type'] = $contractTypeList[$row['type']];
			$list[$key]['signed_type_name'] = $signedTypeList[$row['signed_type']];
			$list[$key]['nikename'] = $userList[$row['create_id']];
			$list[$key]['create_time'] = $row['create_time'] > 0 ? date('Y-m-d',$row['create_time']) : '';
			$list[$key]['status_name'] = $row['status'] == 0 ? '待审核' : ($row['status'] == 1 ? '有效归档' : '无效退回');
			$list[$key]['is_toll_title'] = $row['is_toll'] == 1 ? '已收费' : '未收费';
			$list[$key]['has_arrived_title'] = $row['has_arrived'] == 1 ? '已到账' : '未到账';
			$list[$key]['certificate'] = $row['certificate_id'] > 0 ? '已上传' : '未上传';
		}
		 
		$this->assign('empty',"<tr><td colspan='14'><span class='empty'>暂时没有数据</span></td></tr>"); //数据集为空时
		$this->assign('userList',$userList); //赋值负责BD集合
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('list',$list);// 赋值数据集
		$this->display('Contract/pending_index');
	}
	
	
	
	/**
	 * 编辑
	 */
	public function edit(){
		 
		if(IS_POST){
			
			$data=I('post.');
				
			//合同类型
			$type = $data['type'];
				
			//预充值金额对应赠送金额（抽点合同）
			$pre_charge_credit_amount = array(
					'500'	=> 0,
					'1000'	=> 100,
					'2000'	=> 300,
					'3000'	=> 800,
					'4000'	=> 1500,
					'5000'	=> 2500
			);
				
			//根据不同合同类型附加不同数据项
			switch ($type)
			{
				//抽点新
				case 1:
						
					//赠送金额
					$data['credit_amount'] = $pre_charge_credit_amount[$data['service_pre_charge']];
						
					//总额=预充值金额+保证金
					$data['total'] = $data['service_pre_charge']+$data['bail'];
						
					//商家类别对应抽点
					$data['b_category_point'] = C('MERCHANT_CATEGORIES_CONFIG')[$data['b_category']]['point'];
						
						
					break;
					//抽点老
				case 2:
						
					//该合同类型终端机数默认为1
					$data['terminals_num'] = 1;
						
					//赠送金额
					$data['credit_amount'] = $pre_charge_credit_amount[$data['service_pre_charge']];
			
					//总额=预充值金额+保证金
					$data['total'] = $data['service_pre_charge']+$data['bail'];
			
					//商家类别对应抽点
					$data['b_category_point'] = C('MERCHANT_CATEGORIES_CONFIG')[$data['b_category']]['point'];
						
					break;
						
					//套餐新
				case 3:
					//套餐收费：1、全年套餐4888　2、半年套餐2688
					$package_charges=array(1=>4888,2=>2688);
					$data['package_charges'] = $package_charges[$data['service_items']];
						
					//总额 = 服务费
					$data['total'] = $data['service_charge'];
						
						
					break;
			
					//套餐老
				case 4:
					//该合同类型终端机数默认为1
					$data['terminals_num'] = 1;
			
					//套餐收费：1、全年套餐4888　2、半年套餐2688
					$package_charges=array(1=>4888,2=>2688);
					$data['package_charges'] = $package_charges[$data['service_items']];
			
					//总额 = 服务费
					$data['total'] = $data['service_charge'];
						
						
					break;
						
						
					//品牌合作
				case 5:
					//保证金=终端机数*2000
					$data['bail'] = $data['terminals_num']*2000;
						
					//总额 = 品牌入驻费+广告费用
					$data['total'] = $data['entry_fee']+$data['ads_fee'];
						
						
					break;
						
				default:
					$this->error("合同类型错误",U('Admin/Contract/index'));
					break;
			}
	
			//编辑处理时，审核状态变为待审核
			$data['status'] = 0;
			
			
			$result = D('Contract')->editData(array('id'=>$data['id']),$data);
	
			if($result){
				// 操作成功
				$this->success('编辑成功',U('Admin/Contract/index'));
			}else{
				$error_word=D('Contract')->getError();
				// 操作失败
				$this->error($error_word);
			}
	
		}
		else
		{
	
			$id = I('get.id',0,'intval');
			$assign = M('Contract')->find($id);
			$this->assign('assign',$assign);
			
			
			//合同类型
			$type = $assign['type'];
				
			switch ($type)
			{
				case 1:
					$this->display('Contract/edit_1');
					break;
				case 2:
					$this->display('Contract/edit_2');
					break;
				case 3:
					$this->display('Contract/edit_3');
					break;
				case 4:
					$this->display('Contract/edit_4');
					break;
				case 5:
					$this->display('Contract/edit_5');
					break;
				default:
					$this->error('合同类型出错',U('Admin/Contract/index'));
					break;
			}
		}
	}
	
	/**
	 * 查看合同
	 */
	public function view_contract()
	{
		$id = I('get.id',0,'intval');
		$assign = M('Contract')->find($id);
		
		$this->assign('assign',$assign);
		
		//合同类型
		$type = $assign['type'];
		
		switch ($type)
		{
			case 1:
				$this->display('Contract/contract_review_1');
				break;
			case 2:
				$this->display('Contract/contract_review_2');
				break;
			case 3:
				$this->display('Contract/contract_review_3');
				break;
			case 4:
				$this->display('Contract/contract_review_4');
				break;
			case 5:
				$this->display('Contract/contract_review_5');
				break;
			default:
				$this->error('合同类型出错',U('Admin/Contract/index'));
				break;
		}
	}
	
	/**
	 * 上传证件
	 */
	public function upload_certificate()
	{
		if(IS_POST){
		
			$data=I('post.');
		
			if(empty($data['id']))
			{
				$this->error('缺少参数',U('Admin/Contract/index'));
				return;
			}
			
			
			$picData = post_certificate_upload("/Upload/contract/certificate/",$data['id']);
			
			if(isset($picData['error_info']))
			{
				$this->error($picData['error_info'],U('Admin/Contract/index'));
				return;
			}
			
			
			
			$certificateModel = D('Certificate');
			
			//事务开启
			$certificateModel->startTrans();
			$result_id = $certificateModel->addData($picData);
			
			if($result_id === false){
				
				$certificateModel->rollback();
				
				$error_word=$certificateModel->getError();
				// 操作失败
				$this->error($error_word,U('Admin/Contract/index'));
				return;
			}
				
			//更新合同表中证件id
			$rs = D('Contract')->editData(array('id'=>$data['id']),array('id'=>$data['id'],'certificate_id'=>$result_id));
			
			if($rs === false)
			{
				$certificateModel->rollback();
				
				$error_word=D('Contract')->getError();
				// 操作失败
				$this->error($error_word,U('Admin/Contract/index'));
				return;
			}
			
			$certificateModel->commit();
			// 操作成功
			$this->success('操作成功',U('Admin/Contract/index'));
		
		}else{
			$id = I('get.id',0,'intval');
			$assign = M('Contract')->find($id);
			$this->assign('assign',$assign);
			$this->display();
		}
	}
	
	/**
	 * 编辑证件
	 */
	public function edit_certificate()
	{
		if(IS_POST){
			
			$id	= I('post.id',0,'intval');
			$certificate_id = I('post.certificate_id',0,'intval');
			
			if(empty($id) || empty($certificate_id))
			{
				$this->error('缺少参数',U('Admin/Contract/index'));
				return;
			}
			
			$data = M('certificate')->find($certificate_id);
			
			$picData = post_certificate_upload("/Upload/contract/certificate/{$id}/",$id);
			
			if(isset($picData['error_info']))
			{
				$this->error($picData['error_info'],U('Admin/Contract/index'));
				return;
			}
			
			$certificateModel = D('Certificate');
			
			//事务开启
			$certificateModel->startTrans();
			
			//解决自动完成数据操作类型判断
			$updateData = $picData;
			$updateData['id']=$certificate_id;
			
			$result = $certificateModel->editData(array('id'=>$certificate_id),$updateData);
			
			if($result === false){
				
				$certificateModel->rollback();
				
				$error_word=$certificateModel->getError();
				// 操作失败
				$this->error($error_word,U('Admin/Contract/index'));
				return;
			}
			
			$rs = D('Contract')->editData(array('id'=>$id),array('id'=>$id,'status'=>0));
			
			if($rs === false)
			{
				$certificateModel->rollback();
				
				$error_word=D('Contract')->getError();
				// 操作失败
				$this->error($error_word,U('Admin/Contract/index'));
				return;
			}
			
			
			//清除多余图片
			foreach ($picData as $key=>$row)
			{
				if(is_file(BASE_PATH.$data[$key]))
				{
					unlink(BASE_PATH.$data[$key]);
				}
			}
			$certificateModel->commit();
			// 操作成功
			$this->success('操作成功',U('Admin/Contract/index'));
		
		}else{
			$id = I('get.id',0,'intval');
			$certificate_id = I('get.certificate_id',0,'intval');
			$assignContract = M('Contract')->find($id);
			$assign = M('certificate')->find($certificate_id);
			$this->assign('assignContract',$assignContract);
			$this->assign('assign',$assign);
			
			$this->display();
		}
	}
	
	
	
	
	/**
	 * 确认收费
	 */
	public function confirm_toll()
	{
		$data=I('get.');
    	
    	$result = D('Contract')->editData(array('id'=>$data['id']),array('id'=>$data['id'],'is_toll'=>1));
    	
    	if($result){
    		// 操作成功
    		$this->success('收费已确认',U('Admin/Contract/index'));
    	}else{
    		$error_word=D('Contract')->getError();
    		// 操作失败
    		$this->error($error_word);
    	}
	}
	
	
	/**
	 * 确认到账
	 */
	public function confirm_account()
	{
		$data=I('get.');
    	
    	$result = D('Contract')->editData(array('id'=>$data['id']),array('id'=>$data['id'],'has_arrived'=>1));
    	
    	if($result){
    		// 操作成功
    		$this->success('已确认到账',U('Admin/Contract/pending_account'));
    	}else{
    		$error_word=D('Contract')->getError();
    		// 操作失败
    		$this->error($error_word);
    	}
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
			 
			$result = D('Contract')->editData($map,$data);
			 
			if($result){
				// 操作成功
				$this->success('编辑成功',U('Admin/Contract/pending_index'));
			}else{
				$error_word=D('Contract')->getError();
				// 操作失败
				$this->error($error_word);
			}
			 
		}
	}
	
	
	/**
	 * 数据导出
	 */
	public function excel_out()
	{
		$data = I('get.');
		 
		$contractModel = D('Contract');
		 
		$where = ' WHERE 1=1';
		 
		//判断显示局部数据还是全部
		if(empty($_SESSION['user']['data_range']))
		{
			$where .= ' AND co.create_id='.$_SESSION['user']['id'];
		}
		else
		{
			if(!empty($data['create_id']))
			{
				$where .= ' AND co.create_id='.$data['create_id'];
			}
		}
		 
		 
		 
		//商家名称
		if(!empty($data['b_name']) ){
			$where .=" AND co.b_name LIKE '%{$data['b_name']}%'";
		}
		 
		 
		//收费状态
		if(!empty($data['is_toll']) ){
			$where .= " AND co.is_toll={$data['is_toll']}";
		}
		 
		 
		 
		//证件
		if($data['certificate_id']!='')
		{
			//已上传
			if($data['certificate_id'] == 1)
			{
				$where .= " AND co.certificate_id>0";
			}
		
			//未上传
			if($data['certificate_id'] == 2)
			{
				$where .= " AND co.certificate_id=0";
			}
		}
		 
		 
		//协议编号
		if(!empty($data['protocol_number']) ){
			$where .=" AND co.protocol_number LIKE '%{$data['protocol_number']}'";
		}
		 
		//合同类型
		if(!empty($data['type']) ){
			$where .= " AND co.type={$data['type']}";
		}
		 
		//审核状态
		if($data['status']!='')
		{
			$where .= " AND co.status={$data['status']}";
		}
		 
		//签约类型
		if(!empty($data['signed_type']) ){
			$where .= " AND co.signed_type={$data['signed_type']}";
		}
		
		
		//到账状态
		if(!empty($data['has_arrived']) ){
			$where .= " AND co.has_arrived={$data['has_arrived']}";
		}
		
		
		
		$list=$contractModel
			->field('co.b_name,
					co.create_time,
					co.create_id,
					co.b_category,
					co.b_address,
					co.protocol_number,
					co.service_start_time,
					co.service_end_time,
					co.bail,
					co.b_category_point,
					co.service_charge,
					co.credit_amount,
					co.package_charges,
					co.online_pay,
					co.ads_fee,
					ce.business_license,
					ce.id_card_positive,
					ce.id_negative,
					ce.shop_photo,
					ce.shop_environment,
					ce.food_license,
					ce.kitchen_photo,
					ce.tobacco_alcohol,
					ce.other_photo')->alias('co')->join('LEFT JOIN __CERTIFICATE__ ce ON co.certificate_id=ce.id'.$where)->select();
			
		
			
			
		//获取销售部下的所有员工姓名组
		$userList = D('Users')->getUidsBySectorId(3);
		 
		$categorieList = C('MERCHANT_CATEGORIES_CONFIG');
		
		foreach ($list as $key=>$row)
		{
			$list[$key]['b_category'] = $categorieList[$row['b_category']]['title'];
			$list[$key]['create_id'] = $userList[$row['create_id']];
			$list[$key]['create_time'] = $row['create_time'] > 0 ? date('Y-m-d',$row['create_time']) : '';
			$list[$key]['online_pay'] = $row['online_pay'] == 1 ? '开通' : '未开通';
			$list[$key]['business_license'] = empty($row['business_license']) ? '':'有';
			$list[$key]['id_card_positive'] = empty($row['id_card_positive']) ? '':'有';
			$list[$key]['id_negative'] = empty($row['id_negative']) ? '':'有';
			$list[$key]['shop_photo'] = empty($row['shop_photo']) ? '':'有';
			$list[$key]['shop_environment'] = empty($row['shop_environment']) ? '':'有';
			$list[$key]['food_license'] = empty($row['food_license']) ? '':'有';
			$list[$key]['kitchen_photo'] = empty($row['kitchen_photo']) ? '':'有';
			$list[$key]['tobacco_alcohol'] = empty($row['tobacco_alcohol']) ? '':'有';
			$list[$key]['other_photo'] = empty($row['other_photo']) ? '':'有';
		}
		 
		
		
		
		$arrHead = array(
				'b_name' => '商家名称',
				'create_time' => '登记日期',
				'create_id' => '负责业务员',
				'b_category' => '经营大类',
				'b_address' => '地址',
				'protocol_number' => '协议编号',
				'service_start_time' => '合同开始日期',
				'service_end_time' => '合同结束日期',
				'bail' => '押金',
				'b_category_point' => '抽点',
				'service_charge' => '服务费',
				'credit_amount' => '赠送',
				'package_charges' => '套餐收费',
				'online_pay' => '线上支付',
				'ads_fee' => '广告费',
				'business_license' => '营业执照',
				'id_card_positive' => '身份证正面',
				'id_negative' => '身份证反面',
				'shop_photo' => '店面照',
				'shop_environment' => '店内环境',
				'food_license' => '食品经营许可证',
				'kitchen_photo' => '厨房照',
				'tobacco_alcohol' => '烟草/酒类',
				'other_photo' => '其它'
		);
		 
		array_unshift($list,$arrHead);
		
		create_xls($list,'合同表'.date('Y-m-d',time()));
		
	}
	
	
	
	

}
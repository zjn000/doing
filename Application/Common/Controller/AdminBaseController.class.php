<?php
namespace Common\Controller;
use Common\Controller\BaseController;
/**
 * admin 基类控制器
 */
class AdminBaseController extends BaseController{
	/**
	 * 初始化方法
	 */
	public function _initialize(){
		parent::_initialize();
		$auth=new \Think\Auth();
		$rule_name=MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
		
		check_login() === false && $this->error('您没有登录',U('Home/Index/index'));
		
		//当权限节点为以下值时，不进行权限验证
		$filterPermissions = array(
			'Admin/Ads/view_ads'	//广告详情查看
		);
		
		
		if(!in_array($rule_name,$filterPermissions)){
			$result=$auth->check($rule_name,$_SESSION['user']['id']);
			if(!$result){
				$this->error('您没有权限访问');
			}
		}
		
	}

}
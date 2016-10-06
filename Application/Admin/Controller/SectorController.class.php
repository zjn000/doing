<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 部门管理
 */
class SectorController extends AdminBaseController{
    /**
     * 部门信息列表
     */
    public function index(){
    	$this->search();   
    }
    
    /**
     * 部门列表
     */
    public function group(){
    	$data=D('AuthGroup')->select();
    	$assign=array(
    			'data'=>$data
    	);
    	$this->assign($assign);
    	$this->display();
    }
    
    /**
     * 添加
     */
    public function add_group(){
    	$data=I('post.');
    	unset($data['id']);
    	D('AuthGroup')->addData($data);
    	$this->success('添加成功',U('Admin/Rule/group'));
    }
    
    /**
     * 修改
     */
    public function edit_group(){
    	$data=I('post.');
    	$map=array(
    			'id'=>$data['id']
    	);
    	D('AuthGroup')->editData($map,$data);
    	$this->success('修改成功',U('Admin/Rule/group'));
    }
    
    
}
<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 后台权限管理
 */
class RuleController extends AdminBaseController{

//******************权限***********************
    /**
     * 权限列表
     */
    public function index(){
        $data=D('AuthRule')->getTreeData('tree','id','title');
        $assign=array(
            'data'=>$data
            );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 添加权限
     */
    public function add(){
        $data=I('post.');
        unset($data['id']);
        D('AuthRule')->addData($data);
        $this->success('添加成功',U('Admin/Rule/index'));
    }

    /**
     * 修改权限
     */
    public function edit(){
        $data=I('post.');
        $map=array(
            'id'=>$data['id']
            );
        D('AuthRule')->editData($map,$data);
        $this->success('修改成功',U('Admin/Rule/index'));
    }

    /**
     * 删除权限
     */
    public function delete(){
        $id=I('get.id');
        $map=array(
            'id'=>$id
            );
        $result=D('AuthRule')->deleteData($map);
        if($result){
            $this->success('删除成功',U('Admin/Rule/index'));
        }else{
            $this->error('请先删除子权限');
        }

    }
//*******************用户组**********************
    /**
     * 用户组列表
     */
    public function group(){
        
    	
    	$data = array();
    	$sectorData = array();
    	
    	//用户组数据
    	$data=D('AuthGroup')->select();
        //部门数据
        $sector_data = M('sector')->field('id,name')->select();
        
        
        foreach ($sector_data as $row)
        {
        	$sectorData[$row['id']] = $row['name'];
        }
        
        foreach ($data as $key=>$row)
        {
        	$data[$key]['sector'] = $sectorData[$row['pid']];
        }
       
        $assign=array(
            'data'=>$data,
        	'sectorList' => $sectorData	
        );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 添加用户组
     */
    public function add_group(){
        $data=I('post.');
        unset($data['id']);
        D('AuthGroup')->addData($data);
        $this->success('添加成功',U('Admin/Rule/group'));
    }

    /**
     * 修改用户组
     */
    public function edit_group(){
        $data=I('post.');
        $map=array(
            'id'=>$data['id']
            );
        D('AuthGroup')->editData($map,$data);
        $this->success('修改成功',U('Admin/Rule/group'));
    }

    /**
     * 删除用户组
     */
    public function delete_group(){
        $id=I('get.id');
        $map=array(
            'id'=>$id
            );
        D('AuthGroup')->deleteData($map);
        $this->success('删除成功',U('Admin/Rule/group'));
    }

//*****************权限-用户组*****************
    /**
     * 分配权限
     */
    public function rule_group(){
        if(IS_POST){
            $data=I('post.');
            $map=array(
                'id'=>$data['id']
                );
            $data['rules']=implode(',', $data['rule_ids']);
            D('AuthGroup')->editData($map,$data);
            $this->success('操作成功',U('Admin/Rule/group'));
        }else{
            $id=I('get.id');
            // 获取用户组数据
            $group_data=M('Auth_group')->where(array('id'=>$id))->find();
            $group_data['rules']=explode(',', $group_data['rules']);
            // 获取规则数据
            $rule_data=D('AuthRule')->getTreeData('level','id','title');
            $assign=array(
                'group_data'=>$group_data,
                'rule_data'=>$rule_data
                );
            $this->assign($assign);
            $this->display();
        }

    }
//******************用户-用户组*******************
    /**
     * 添加成员
     */
    public function check_user(){
        $username=I('get.username','');
        $group_id=I('get.group_id');
        $group_name=M('Auth_group')->getFieldById($group_id,'title');
        $uids=D('AuthGroupAccess')->getUidsByGroupId($group_id);
        // 判断用户名是否为空
        if(empty($username)){
            $user_data='';
        }else{
            $user_data=M('Users')->where(array('username'=>$username))->select();
        }
        $assign=array(
            'group_name'=>$group_name,
            'uids'=>$uids,
            'user_data'=>$user_data,
            );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 添加用户到用户组
     */
    public function add_user_to_group(){
        $data=I('get.');
        $map=array(
            'uid'=>$data['uid'],
            'group_id'=>$data['group_id']
            );
        $count=M('AuthGroupAccess')->where($map)->count();
        if($count==0){
            D('AuthGroupAccess')->addData($data);
        }
        $this->success('操作成功',U('Admin/Rule/check_user',array('group_id'=>$data['group_id'],'username'=>$data['username'])));
    }

    /**
     * 将用户移除用户组
     */
    public function delete_user_from_group(){
        $map=I('get.');
        D('AuthGroupAccess')->deleteData($map);
        $this->success('操作成功',U('Admin/Rule/admin_user_list'));
    }
    
    
    
/********************部门管理***********************/
  /**
   * 部门列表
   */
  public function sector_list()
  {
  		$data = M('sector')->field(true)->select();
  		
  		$assign=array(
  			'data'=>$data
  		);
  		$this->assign($assign);
  		$this->display();
  		
  }  
  
  
  
  /**
   * 添加部门
   */
  public function add_sector(){
  	$data=I('post.');
  	unset($data['id']);
  	D('Sector')->addData($data);
  	$this->success('添加成功',U('Admin/Rule/sector_list'));
  }
  
  /**
   * 修改部门
   */
  public function edit_sector(){
  	$data=I('post.');
  	$map=array(
  		'id'=>$data['id']
  	);
  	D('Sector')->editData($map,$data);
  	$this->success('修改成功',U('Admin/Rule/sector_list'));
  }

  
  
  
  
  
 /****************员工管理*******************/   
    /**
     * 管理员列表
     */
    public function admin_user_list(){
    	
    	$data=D('AuthGroupAccess')->getAllData();
        
    	$sectorModel = D('Sector');
    	
    	
        foreach ($data as $key=>$row)
        {
        	$data[$key]['sector'] = $sectorModel->getNameByGroupId($row['group_id']);
        	$data[$key]['status'] = $row['status'] == 1 ? '允许' : '禁止登录';
        }
        
        
        $assign=array(
            'data'=>$data
            );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 根据部门id获取职务数据
     * ajax调用json返回
     */
    public function getGroupBySectorId()
    {
    	$result = array();
    	$groupid =$_POST['groupid'];
    	
    	$result = M('auth_group')->where(array('pid'=> $groupid))->field('id,title')->select();
    	
    	$this->ajaxReturn($result,"JSON");
    	
    }
    
    
    
    /**
     * 添加管理员
     */
    public function add_admin(){
        if(IS_POST){
            $data=I('post.');
            
            $rs = D('Users')->where(array('username'=>$data['username']))->getField('id');
            
            !empty($rs) && $this->error('用户已存在');
            
            $result=D('Users')->addData($data);
            if($result){
                if (!empty($data['group_ids'])) {
                    foreach ($data['group_ids'] as $k => $v) {
                        $group=array(
                            'uid'=>$result,
                            'group_id'=>$v
                            );
                        D('AuthGroupAccess')->addData($group);
                    }                   
                }
                // 操作成功
                $this->success('添加成功',U('Admin/Rule/admin_user_list'));
            }else{
                $error_word=D('Users')->getError();
                // 操作失败
                $this->error($error_word);
            }
        }else{
            $sectorList = D('Sector')->field('id,name')->select();
            $assign=array(
            	'sectorList' => $sectorList	        
            );
            $this->assign($assign);
            $this->display();
        }
    }

    /**
     * 修改管理员
     */
    public function edit_admin(){
        if(IS_POST){
            $data=I('post.');
            // 组合where数组条件
            $uid=$data['id'];
            $map=array(
                'id'=>$uid
                );
            // 修改权限
            D('AuthGroupAccess')->deleteData(array('uid'=>$uid));
            foreach ($data['group_ids'] as $k => $v) {
                $group=array(
                    'uid'=>$uid,
                    'group_id'=>$v
                    );
                D('AuthGroupAccess')->addData($group);
            }
            $data=array_filter($data);
            // 如果修改密码则md5
            if (!empty($data['password'])) {
                $data['password']=md5($data['password']);
            }
             
            
            $data['status'] = isset($data['status']) ? $data['status'] : 0;
            $data['data_range'] = isset($data['data_range']) ? $data['data_range'] : 0;
            $data['region'] = isset($data['region']) ? $data['region'] : 0;

            $result=D('Users')->editData($map,$data);
            if($result){
                // 操作成功
                $this->success('编辑成功',U('Admin/Rule/admin_user_list'));
            }else{
                $error_word=D('Users')->getError();
                if (empty($error_word)) {                   
                    $this->success('编辑成功',U('Admin/Rule/admin_user_list'));
                }else{
                    // 操作失败
                    $this->error($error_word);                  
                }

            }
        }else{
            $id=I('get.id',0,'intval');
            // 获取用户数据
            $user_data=M('Users')->find($id);
            
            //员工所属职务id    
            $group_id = M('AuthGroupAccess')->where(array('uid'=>$id))->getField('group_id');
            
            //职务所属部门id
            $sector_id = D('AuthGroup')->where(array('id'=>$group_id))->getField('pid');
            
            //部门集合
            $sectorList = D('Sector')->field('id,name')->select();
            
            $assign=array(
            	'sectorList' => $sectorList,
            	'sector_id' => $sector_id,	
            	'group_id' => $group_id,	
                'user_data'=>$user_data,
            );
            $this->assign($assign);
            $this->display();
        }
    }
}

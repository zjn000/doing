<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 权限规则model
 */
class AuthGroupModel extends BaseModel{

	/**
	 * 传递主键id删除数据
	 * @param  array   $map  主键id
	 * @return boolean       操作是否成功
	 */
	public function deleteData($map){
		$this->where($map)->delete();
		$group_map=array(
			'group_id'=>$map['id']
			);
		// 删除关联表中的组数据
		$result=D('AuthGroupAccess')->deleteData($group_map);
		return $result;
	}


	
	
	/**
	 * 根据角色id获取其所属部门id
	 */
	public function getSectorIdByUid($userid){
		$data=$this
		->alias('ag')
		->join('__AUTH_GROUP_ACCESS__ aga ON aga.group_id=ag.id AND aga.uid='.$userid)
		->getField('ag.pid');		
		return $data;
	
	}
	
	

}

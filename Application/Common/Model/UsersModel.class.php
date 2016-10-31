<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * ModelName
 */
class UsersModel extends BaseModel{
    // 自动验证
    protected $_validate=array(
        array('username','require','用户名必填',0,'',3), // 验证字段必填
        array('nikename','require','姓名必填',0,'',3), // 验证字段必填
    );

    // 自动完成
    protected $_auto=array(
        array('password','md5',1,'function') , // 对password字段在新增的时候使md5函数处理
        array('register_time','time',1,'function'), // 对date字段在新增的时候写入当前时间戳
    );

    /**
     * 添加用户
     */
    public function addData($data){
        // 对data数据进行验证
        if(!$data=$this->create($data)){
            // 验证不通过返回错误
            return false;
        }else{
            // 验证通过
            $result=$this->add($data);
            return $result;
        }
    }

    /**
     * 修改用户
     */
    public function editData($map,$data){
        // 对data数据进行验证
        if(!$data=$this->create($data)){
            // 验证不通过返回错误
            return false;
        }else{
            // 验证通过
            $result=$this
                ->where(array($map))
                ->save($data);
            return $result;
        }
    }

    /**
     * 删除数据
     * @param   array   $map    where语句数组形式
     * @return  boolean         操作是否成功
     */
    public function deleteData($map){
        die('禁止删除用户');
    }

    
    /**
     * 根据部门id获取部门全部员工id,nikename
     * @param integer $sector_id 部门id
     * @return array
     */
    public function getUidsBySectorId($sector_id){
    	
    	$result = array();
    	$list = $this->field('u.id,u.nikename')
    				->alias('u')
    				->join('__AUTH_GROUP_ACCESS__ aga ON u.id=aga.uid','LEFT')
    				->join('__AUTH_GROUP__ ag ON aga.group_id=ag.id and ag.pid='.$sector_id)
    				->select();
    	if(!empty($list))
    	{
    		foreach ($list as $row)
    		{
    			$result[$row['id']] = $row['nikename'];
    		}
    	}
    	return $result;
    }


}

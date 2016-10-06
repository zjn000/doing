<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * ModelName
 */
class SectorModel extends BaseModel{
    // 自动验证
    protected $_validate=array(
        array('name','require','部门名称必填',0,'',3), // 验证字段必填
    );

    // 自动完成
    protected $_auto=array(    
        array('create_time','time',1,'function'), // 对date字段在新增的时候写入当前时间戳       
    );

    /**
     * 添加数据
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
     * 修改数据
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
		$result=$this->where($map)->delete();
		return $result;
    }
    
    /**
     * 根据用户组id获取部门名称
     * @param integer $id 用户组id
     * @return string $result 部门名称
     */
    public function getNameByGroupId($id)
    {
    	
    	$result = $this
    	->field('s.name')->alias('s')   	
    	->join('__AUTH_GROUP__ a ON s.id=a.pid')->where('a.id='.$id)
    	->select();
    	
    	return $result[0]['name'];
    }
    
    

}
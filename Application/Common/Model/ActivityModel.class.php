<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * ModelName
 */
class ActivityModel extends BaseModel{
    // 自动验证
    protected $_validate=array(
        array('activity_name','require','活动名称必填',0,'',3), // 验证字段必填
    );

    // 自动完成
    protected $_auto=array(
        array('activity_leader_id','get_uid',1,'function') , // 对activity_leader_id字段在新增的时候使get_uid函数处理
        array('modify_uid','get_uid',2,'function') , // 对modify_uid字段在更新的时候使get_uid函数处理
        array('activity_leader','get_nikename',1,'function') , // 对activity_leader字段在新增的时候使get_nikename函数处理
        array('activity_date','strtotime',1,'function') , // 对activity_date字段在新增的时候使strtotime函数处理
        array('activity_date','strtotime',2,'function') , // 对activity_date字段在更新的时候使strtotime函数处理
        array('create_time','time',1,'function'), // 对date字段在新增的时候写入当前时间戳
        array('modify_time','time',2,'function'), // 对date字段在更新的时候写入当前时间戳
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
     * 获取数据
     * @param array $map where语句数组形式
     * @return array
     */
	public function getAllData($map)
	{
		$result = $this->field(array('id','activity_leader_id','create_time','modify_uid','modify_time'),true)->where($map)->select();
		return $result;
	}

}
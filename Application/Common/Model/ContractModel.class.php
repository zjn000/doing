<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * ModelName
 */
class ContractModel extends BaseModel{

    // 自动完成
    protected $_auto=array(
        array('create_id','get_uid',1,'function') , // 对create_id字段在新增的时候使get_uid函数处理
        array('modify_id','get_uid',2,'function') , // 对modify_uid字段在更新的时候使get_uid函数处理
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
    

}
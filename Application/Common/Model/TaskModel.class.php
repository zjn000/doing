<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * ModelName
 */
class TaskModel extends BaseModel{
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
    
    /**
     * 获取数据
     * @param array $map where语句数组形式
     * @return array
     */
    public function getAllData($map)
    {
    	$arrHead = array(
    			'create_id',
    			'task_date',
    			'task_status',
    			'plan_new_num',
    			'real_new_num',
    			'plan_new_price',
    			'real_new_price',
    			'plan_renewal_num',
    			'real_renewal_num',
    			'plan_renewal_price',
    			'real_renewal_price',
    			'plan_toll_num',
    			'real_toll_num',
    			'plan_toll_price',
    			'real_toll_price',
    			'plan_ad_num',
    			'real_ad_num',
    			'plan_ad_price',
    			'real_ad_price',
    			'plan_hour',
    			'real_hour',
    			'plan_back_num',
    			'real_back_num'
    	);
    	
    	$result = $this->field($arrHead)->where($map)->select();
    	return $result;
    }
    
    
}
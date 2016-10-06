<?php
return array(
//*************************************附加设置***********************************
    'TMPL_ACTION_ERROR'      => THINK_PATH . 'Tpl/dispatch_jump.tpl', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'    => THINK_PATH . 'Tpl/dispatch_jump.tpl', // 默认成功跳转对应的模板文件
	//活动时段参数配置	
	'ACTIVITY_PERIOD_CONFIG' => array(
			0 => '',
			1 => '上午',
			2 => '下午',
			3 => '晚上'
	),
	//活动时长参数配置
	'ACTIVITY_DURATION_CONFIG' => array(
			0 => '',
			1 => '三小时',
			2 => '四小时'
	),
	//活动所属区域参数配置	
	'ACTIVITY_AREA_CONFIG' => array(
			0 => '',
			1 => '东区',
			2 => '西区',
			3 => '中区',
			4 => '广厦',
			5 => '澄海',
			6 => '棉城'
	)
);

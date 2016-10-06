<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>活动信息管理</title>
    
        <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/doing/Public/statics/bootstrap-3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/doing/Public/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="/doing/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/doing/Public/statics/css/bjy.css" />
    <link rel="stylesheet" href="/doing/tpl/Public/css/base.css" />
    <script src="/doing/Public/statics/laydate-v1.1/laydate.js"></script>    
</head>
<body>
<div class="bjy-admin-nav">
    <a href="<?php echo U('Admin/Index/index');?>" target="_parent"><i class="fa fa-home"></i> 首页 </a>
    &gt;
    活动信息列表        
</div>

<?php if(checkAuthShow('Admin/Activity/search')){ ?>
<form class="form-inline" method="get" action="<?php echo U('Admin/Activity/search');?>" >
	
    <table class="table table-striped table-bordered table-hover table-condensed">
        <tr>
        	<th width="10%">活动名称</th>
        	<td width="15%"><input class="form-control" type="text" name="activity_name" value="<?php echo ($_GET['activity_name']); ?>"></td>
        	<th width="10%">活动地点</th>
        	<td width="15%"><input class="form-control" type="text" name="activity_location" value="<?php echo ($_GET['activity_location']); ?>"></td>
        	<th width="10%">活动负责人</th>
        	<td width="15%">       	
        		<select class="form-control" name="activity_leader_id">
        			<option value=""></option>
        			<?php if(is_array($userList)): foreach($userList as $key=>$vo): ?><option value="<?php echo ($key); ?>" <?php if(($key) == $_GET['activity_leader_id']): ?>selected<?php endif; ?>  ><?php echo ($vo); ?></option><?php endforeach; endif; ?>
        		</select>
        	</td>
        	<th width="10%">活动时段</th>
        	<td width="15%">
        		<select name="activity_period" class="form-control">
	            <?php $_result=C('ACTIVITY_PERIOD_CONFIG');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($key) == $_GET['activity_period']): ?>selected<?php endif; ?> ><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>  
            </select>
        	
        	</td>
        </tr>
        <tr>
        	<th width="10%">商家名称</th>
        	<td width="15%"><input class="form-control" type="text" name="business_name" value="<?php echo ($_GET['business_name']); ?>"></td>
        	<th width="10%">商家优惠</th>
        	<td width="15%"><input class="form-control" type="text" name="business_deals" value="<?php echo ($_GET['business_deals']); ?>"></td>
        	<th width="10%">所属区域</th>
        	<td width="15%">
        		<select name="activity_area" class="form-control">
	            <?php $_result=C('ACTIVITY_AREA_CONFIG');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($key) == $_GET['activity_area']): ?>selected<?php endif; ?> ><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>  
            	</select>
            </td>
        	<th width="10%">活动时长</th>
        	<td width="15%">
        		<select name="activity_duration" class="form-control">
	            <?php $_result=C('ACTIVITY_DURATION_CONFIG');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($key) == $_GET['activity_duration']): ?>selected<?php endif; ?> ><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>  
            	</select>
        	</td>
        </tr>
        <tr>
        	<th width="10%">活动方式</th>
        	<td width="15%"><input class="form-control" type="text" name="activity_mode" value="<?php echo ($_GET['activity_mode']); ?>"></td>
        	<th width="10%">开始日期</th>
        	<td width="15%"><input class="form-control" type="text" id="start_date"  name="start_date" value="<?php echo ($_GET['start_date']); ?>" ></td>
        	<th width="10%">结束日期</th>
        	<td width="15%"><input class="form-control" type="text" id="end_date" name="end_date" value="<?php echo ($_GET['end_date']); ?>"  ></td>
        	<th width="25%" colspan="2"><input class="btn btn-success" type="submit" value="&nbsp;&nbsp;查&nbsp;&nbsp;询&nbsp;&nbsp; "></th>
        	
        </tr>
    </table>
</form>
<?php } ?>

<ul id="myTab" class="nav nav-tabs">
   <li class="active">
         <a href="<?php echo U('Admin/Activity/index');?>">活动信息列表</a>
   </li>
   <li>
        <a href="<?php echo U('Admin/Activity/add');?>">添加活动信息</a>
    </li>
   <li>
        <a href="<?php echo U('Admin/Activity/excel_out', array( 'activity_name'=>$_GET['activity_name'], 'activity_location'=>$_GET['activity_location'], 'activity_leader_id'=>$_GET['activity_leader_id'], 'activity_period'=>$_GET['activity_period'], 'business_name'=>$_GET['business_name'], 'business_deals'=>$_GET['business_deals'], 'activity_area'=>$_GET['activity_area'], 'activity_duration'=>$_GET['activity_duration'], 'activity_mode'=>$_GET['activity_mode'], 'start_date'=>$_GET['start_date'], 'end_date'=>$_GET['end_date'] ) );?>">excel导出查询数据</a>
    </li>
</ul>
<table class="table table-striped table-bordered table-hover table-condensed">
    <tr>
        <th width="10%">活动名称</th>
        <th>活动日期</th>
        <th>活动地点</th>
        <th>活动负责人</th>
        <th>所属区域</th>
        <th>商家名称</th>
        <th>活动方式</th>
        <th>商家优惠</th>
        <th>新C数量</th>
        <th>老C数量</th>
        <th>传单数量</th>
        <th>海报数量</th>
		<th>操作</th>
    </tr>
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($vo["activity_name"]); ?></td>
            <td><?php echo ($vo["activity_date"]); ?></td>
            <td><?php echo ($vo["activity_location"]); ?></td>
            <td><?php echo ($vo["activity_leader"]); ?></td>
            <td><?php echo ($vo["activity_area"]); ?></td>
            <td><?php echo ($vo["business_name"]); ?></td>
            <td><?php echo ($vo["activity_mode"]); ?></td>
            <td><?php echo ($vo["business_deals"]); ?></td>
            <td><?php echo ($vo["new_user_number"]); ?></td>
            <td><?php echo ($vo["old_user_number"]); ?></td>
            <td><?php echo ($vo["flyer_number"]); ?></td>
            <td><?php echo ($vo["poster_number"]); ?></td>
            <td>
                <a href="<?php echo U('Admin/Activity/edit',array('id'=>$vo['id']));?>">编辑</a>
            </td>
        </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>          
</table>
 <?php echo ($page); ?>
<!-- 引入bootstrjs部分开始 -->
<script src="/doing/Public/statics/js/jquery-1.10.2.min.js"></script>
<script src="/doing/Public/statics/js/jquery.validate.min.js"></script>
<script src="/doing/Public/statics/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script src="/doing/tpl/Public/js/base.js"></script>
<script type="text/javascript">
var start = {
    elem: '#start_date',
    format: 'YYYY-MM-DD',
    istoday: true,
    start: laydate.now(),
    choose: function(datas){
         end.min = datas; //开始日选好后，重置结束日的最小日期
         end.start = datas //将结束日的初始值设定为开始日
    }
};
var end = {
    elem: '#end_date',
    format: 'YYYY-MM-DD',
    istoday: true,
    start: laydate.now(),
    choose: function(datas){
        start.max = datas; //结束日选好后，重置开始日的最大日期
    }
};
laydate(start);
laydate(end);
</script>

<script src="/doing/Public/statics/laydate-v1.1/laydate.js"></script>
</body>
</html>
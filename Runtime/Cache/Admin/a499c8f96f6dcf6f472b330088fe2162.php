<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>编辑活动信息</title>
        <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/doing/Public/statics/bootstrap-3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/doing/Public/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="/doing/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/doing/Public/statics/css/bjy.css" />
    <link rel="stylesheet" href="/doing/tpl/Public/css/base.css" />
        <link rel="stylesheet" href="/doing/Public/statics/iCheck-1.0.2/skins/all.css">
    <script src="/doing/Public/statics/laydate-v1.1/laydate.js"></script>
</head>
<body id="xb-date">

<!-- 导航栏开始 -->
<div class="bjy-admin-nav">
    <a href="<?php echo U('Admin/Index/index');?>" target="_parent"><i class="fa fa-home"></i> 首页</a>
    &gt;
   <a href="<?php echo U('Admin/Activity/index');?>" target="right_content">活动信息列表</a>
    &gt;
    编辑
</div>
<!-- 导航栏结束 -->
<form class="form-inline" method="post" id="myForm">
<input type="hidden" name="id" value="<?php echo ($assign['id']); ?>">
    <table class="table table-striped table-bordered table-hover table-condensed">
        <tr>
        	<th><font color="red">*</font>活动名称</th>
            <td><input class="form-control" type="text" name="activity_name" value="<?php echo ($assign['activity_name']); ?>"></td>
        	<th>所属区域</th>
            <td>
            <select name="activity_area" class="form-control">
	            <?php $_result=C('ACTIVITY_AREA_CONFIG');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($key) == $assign['activity_area']): ?>selected<?php endif; ?> ><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>  
            </select>
            </td>
        </tr>
        <tr>
        	<th>活动日期</th>
            <td><input class="form-control" type="text" value="<?php echo ($assign['activity_date']); ?>" name="activity_date" onclick="laydate()"></td>
        
        	<th>活动时段</th>
            <td>
            <select name="activity_period" class="form-control">
	            <?php $_result=C('ACTIVITY_PERIOD_CONFIG');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($key) == $assign['activity_period']): ?>selected<?php endif; ?> ><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>  
            </select>
            </td>
        </tr>
        <tr>
        	<th>活动方式</th>
            <td><input class="form-control" type="text" name="activity_mode" value="<?php echo ($assign['activity_mode']); ?>"></td>
        
        	<th>活动时长</th>
            <td>
            <select name="activity_duration" class="form-control">
	            <?php $_result=C('ACTIVITY_DURATION_CONFIG');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($key) == $assign['activity_duration']): ?>selected<?php endif; ?> ><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>  
            </select>
            </td>
        </tr>
        <tr>
        	<th>商家优惠</th>
            <td><input class="form-control" type="text" name="business_deals" value="<?php echo ($assign['business_deals']); ?>"  ></td>
        	<th>活动地点</th>
            <td><input class="form-control"  type="text" name="activity_location" style="width:50%;" value="<?php echo ($assign['activity_location']); ?>" ></td>
        </tr>
        
        <tr>
        	<th>商家名称</th>
            <td><input class="form-control" type="text" name="business_name" value="<?php echo ($assign['business_name']); ?>" ></td>
        	<th>商家地址</th>
            <td><input class="form-control" type="text" name="business_address" style="width:50%;"  value="<?php echo ($assign['business_name']); ?>" ></td>
        </tr>
        <tr>
        	<th>联系人</th>
            <td><input class="form-control" type="text" name="business_contacts"  value="<?php echo ($assign['business_contacts']); ?>" ></td>
        
        	<th>联系电话</th>
            <td><input class="form-control" type="text" name="business_tel"  value="<?php echo ($assign['business_tel']); ?>" ></td>
        </tr>
        <tr>
        	<th>新C数量</th>
            <td><input class="form-control" type="text" name="new_user_number"  value="<?php echo ($assign['new_user_number']); ?>"> 个</td>
        
        	<th>老C数量</th>
            <td><input class="form-control" type="text" name="old_user_number"  value="<?php echo ($assign['old_user_number']); ?>"> 个</td>
        </tr>
        <tr>
        	<th>传单数量</th>
            <td><input class="form-control" type="text" name="flyer_number"  value="<?php echo ($assign['flyer_number']); ?>" > 张</td>
        
        	<th>海报数量</th>
            <td><input class="form-control" type="text" name="poster_number" value="<?php echo ($assign['poster_number']); ?>" > 张</td>
        </tr>
        <tr>
        	<th>兼职人数</th>
            <td><input class="form-control" type="text" name="part_number" value="<?php echo ($assign['part_number']); ?>" > 个</td>
        
        	<th>礼品数量</th>
            <td><input class="form-control" type="text" name="gift_number" value="<?php echo ($assign['gift_number']); ?>" > 份</td>
        </tr>
        <tr>
        	<th>兼职工时</th>
            <td><input class="form-control" type="text" name="part_time" value="<?php echo ($assign['part_time']); ?>" > 小时</td>
        
        	<th>人员费用</th>
            <td><input class="form-control" type="text" name="staff_costs" value="<?php echo ($assign['staff_costs']); ?>" > 元</td>
        </tr>
        <tr>
        	<th>反馈</th>
            <td colspan="3"><textarea rows="5" class="form-control" cols="100" name="feedback"><?php echo ($assign['feedback']); ?></textarea></td>
        </tr>
        
        <tr>
            <td colspan="4" style="text-align: center;">
            	<input class="btn btn-success" type="submit" value="&nbsp;&nbsp;提&nbsp;&nbsp;交&nbsp;&nbsp;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	<a class="btn btn-success" href="javascript:history.go(-1);">&nbsp;&nbsp;取&nbsp;&nbsp;消&nbsp;&nbsp;</a>
            </td>
        </tr>
    </table>
</form>
<!-- 引入bootstrjs部分开始 -->
<script src="/doing/Public/statics/js/jquery-1.10.2.min.js"></script>
<script src="/doing/Public/statics/js/jquery.validate.min.js"></script>
<script src="/doing/Public/statics/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script src="/doing/tpl/Public/js/base.js"></script>
<script src="/doing/Public/statics/iCheck-1.0.2/icheck.min.js"></script>
<script>
$(document).ready(function(){
    $('.xb-icheck').iCheck({
        checkboxClass: "icheckbox_minimal-blue",
        radioClass: "iradio_minimal-blue",
        increaseArea: "20%"
    });
});
</script>
<script src="/doing/Public/statics/laydate-v1.1/laydate.js"></script>
<script type="text/javascript">
$("#myForm").validate({ 
	rules: {
		activity_name: {
			required: true			
		}
	}, 
	messages: { 		
		activity_name: { 
			required: "必填"
		}
	} 
});	
</script>
</body>
</html>
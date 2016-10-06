<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"/>
	<title>用户组添加用户 - bjyadmin</title>
	    <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/doing/Public/statics/bootstrap-3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/doing/Public/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="/doing/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/doing/Public/statics/css/bjy.css" />
    <link rel="stylesheet" href="/doing/tpl/Public/css/base.css" />
</head>
<body>
<div class="bjy-admin-nav">
	<a href="<?php echo U('Admin/Index/index');?>" target="_parent"><i class="fa fa-home"></i> 首页</a>
	&gt;
	<a href="<?php echo U('Admin/Rule/group');?>">用户组列表</a>
	&gt;
	用户组添加用户
</div>
<table class="table table-striped table-bordered table-hover table-condensed">
	<tr>
		<th width="10%">
			搜索用户名：
		</th>
		<td>
			<form class="form-inline" action="">
				<input class="form-control" type="text" name="username" value="<?php echo ($_GET['username']); ?>">
				<input class="btn btn-success" type="submit" value="搜索">
			</form>
		</td>
	</tr>
</table>
<table class="table table-striped table-bordered table-hover table-condensed">
	<tr>
		<th width="10%">用户名</th>
		<th>操作</th>
	</tr>
	<?php if(is_array($user_data)): foreach($user_data as $key=>$v): ?><tr>
			<th><?php echo ($v['username']); ?></th>
			<td>
				<?php if(in_array($v['id'],$uids)): ?>已经是<?php echo ($group_name); ?>
				<?php else: ?>
					<a href="<?php echo U('Admin/Rule/add_user_to_group',array('uid'=>$v['id'],'group_id'=>$_GET['group_id'],'username'=>$_GET['username']));?>">设为<?php echo ($group_name); ?></a><?php endif; ?>
			</td>
		</tr><?php endforeach; endif; ?>

</table>

<!-- 引入bootstrjs部分开始 -->
<script src="/doing/Public/statics/js/jquery-1.10.2.min.js"></script>
<script src="/doing/Public/statics/js/jquery.validate.min.js"></script>
<script src="/doing/Public/statics/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script src="/doing/tpl/Public/js/base.js"></script>
</body>
</html>
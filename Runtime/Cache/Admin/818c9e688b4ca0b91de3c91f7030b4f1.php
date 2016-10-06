<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"/>
	<title>部门管理</title>
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
	部门管理
</div>
<ul id="myTab" class="nav nav-tabs">
   <li class="active">
		 <a href="#home" data-toggle="tab">部门列表</a>
   </li>
   <li>
		<a href="javascript:;" onclick="add()">添加部门</a>
	</li>
</ul>
<div id="myTabContent" class="tab-content">
   <div class="tab-pane fade in active" id="home">
		<table class="table table-striped table-bordered table-hover table-condensed">
			<tr>
				<th>部门名称</th>
				<th>操作</th>
			</tr>
			<?php if(is_array($data)): foreach($data as $key=>$v): ?><tr>
					<td><?php echo ($v['name']); ?></td>
					<td>
						<?php if(($v["id"]) != "1"): ?><a href="javascript:;" ruleId="<?php echo ($v['id']); ?>" ruleTitle="<?php echo ($v['name']); ?>" onclick="edit(this)">修改</a><?php endif; ?>
					</td>
				</tr><?php endforeach; endif; ?>
		</table>
   </div>
</div>

<!-- 添加菜单模态框开始 -->
<div class="modal fade" id="bjy-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		 <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					添加部门
				</h4>
			</div>
			<div class="modal-body">
				<form id="bjy-form" class="form-inline" action="<?php echo U('Admin/Rule/add_sector');?>" method="post">
					<table class="table table-striped table-bordered table-hover table-condensed">
						<tr>
							<th width="15%"><font color="red">*</font>部门名称：</th>
							<td>
								<input class="form-control" type="text" name="name">
							</td>
						</tr>
						<tr>
							<th></th>
							<td>
								<input class="btn btn-success" type="submit" value="添加">
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- 添加菜单模态框结束 -->

<!-- 修改菜单模态框开始 -->
<div class="modal fade" id="bjy-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		 <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					修改部门
				</h4>
			</div>
			<div class="modal-body">
				<form id="bjy-form" class="form-inline" action="<?php echo U('Admin/Rule/edit_sector');?>" method="post">
					<input type="hidden" name="id">
					<table class="table table-striped table-bordered table-hover table-condensed">
						<tr>
							<th width="15%">部门名称：</th>
							<td>
								<input class="form-control" type="text" name="name">
							</td>
						</tr>
						<tr>
							<th></th>
							<td>
								<input class="btn btn-success" type="submit" value="修改">
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- 修改菜单模态框结束 -->
<!-- 引入bootstrjs部分开始 -->
<script src="/doing/Public/statics/js/jquery-1.10.2.min.js"></script>
<script src="/doing/Public/statics/js/jquery.validate.min.js"></script>
<script src="/doing/Public/statics/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script src="/doing/tpl/Public/js/base.js"></script>
<script>
// 添加菜单
function add(){
	$("input[name='name']").val('');
	$('#bjy-add').modal('show');
}

// 修改菜单
function edit(obj){
	var ruleId=$(obj).attr('ruleId');
	var ruletitle=$(obj).attr('ruletitle');
	$("input[name='id']").val(ruleId);
	$("input[name='name']").val(ruletitle);
	$('#bjy-edit').modal('show');
}
</script>
</body>
</html>
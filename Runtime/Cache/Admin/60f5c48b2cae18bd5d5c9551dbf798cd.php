<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"/>
	<title>职务管理</title>
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
	职务管理
</div>
<ul id="myTab" class="nav nav-tabs">
   <li class="active">
		 <a href="#home" data-toggle="tab">职务列表</a>
   </li>
   <li>
		<a href="javascript:;" onclick="add()">添加职务</a>
	</li>
</ul>
<div id="myTabContent" class="tab-content">
   <div class="tab-pane fade in active" id="home">
		<table class="table table-striped table-bordered table-hover table-condensed">
			<tr>
				<th>部门名称</th>
				<th>职务名</th>
				<th>操作</th>
			</tr>
			<?php if(is_array($data)): foreach($data as $key=>$v): ?><tr>
					<td><?php echo ($v['sector']); ?></td>
					<td><?php echo ($v['title']); ?></td>
					<td>
						<?php if(($v["id"]) != "1"): ?><a href="javascript:;" ruleId="<?php echo ($v['id']); ?>" ruleTitle="<?php echo ($v['title']); ?>" ruleSector="<?php echo ($v['pid']); ?>" onclick="edit(this)">修改</a>
							<!-- <a href="javascript:if(confirm('确定删除？'))location='<?php echo U('Admin/Rule/delete_group',array('id'=>$v['id']));?>'">删除</a> | --><?php endif; ?>
						<?php if(checkAuthShow('Admin/Rule/rule_group')){ ?> |
						<a href="<?php echo U('Admin/Rule/rule_group',array('id'=>$v['id']));?>">分配权限</a>
						<?php } ?>
						<!--  |
						<a href="<?php echo U('Admin/Rule/check_user',array('group_id'=>$v['id']));?>">添加成员</a>  -->
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
					添加职务
				</h4>
			</div>
			<div class="modal-body">
				<form id="bjy-form" class="form-inline" action="<?php echo U('Admin/Rule/add_group');?>" method="post">
					<table class="table table-striped table-bordered table-hover table-condensed">
						<tr>
							<th width="15%"><font color="red">*</font>所属部门：</th>
							<td>
								<select name="pid" class="form-control">
									<?php if(is_array($sectorList)): foreach($sectorList as $key=>$vo): ?><option value="<?php echo ($key); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; ?>
								</select>
							</td>
						</tr>
						<tr>
							<th width="15%"><font color="red">*</font>职务名：</th>
							<td>
								<input class="form-control" type="text" name="title">
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
					修改职务
				</h4>
			</div>
			<div class="modal-body">
				<form id="bjy-form" class="form-inline" action="<?php echo U('Admin/Rule/edit_group');?>" method="post">
					<input type="hidden" name="id">
					<table class="table table-striped table-bordered table-hover table-condensed">
						<tr>
							<th width="15%"><font color="red">*</font>所属部门：</th>
							<td>
								<select name="pid" class="form-control">
									<?php if(is_array($sectorList)): foreach($sectorList as $key=>$vo): ?><option value="<?php echo ($key); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; ?>
								</select>
							</td>
						</tr>
						
						<tr>
							<th width="15%">职务名：</th>
							<td>
								<input class="form-control" type="text" name="title">
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
	$("input[name='title']").val('');
	$('#bjy-add').modal('show');
}

// 修改菜单
function edit(obj){
	var ruleId=$(obj).attr('ruleId');
	var ruletitle=$(obj).attr('ruletitle');
	var ruleSector=$(obj).attr('ruleSector');
	$("input[name='id']").val(ruleId);
	$("input[name='title']").val(ruletitle);
	$("select[name='pid']").val(ruleSector);
	$('#bjy-edit').modal('show');
}
</script>
</body>
</html>
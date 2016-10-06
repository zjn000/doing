<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"/>
	<title>分配权限 - bjyadmin</title>
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
	<i class="fa fa-home"></i> 首页
	&gt;
	用户组列表
	&gt;
	分配权限
</div>
<h1 class="text-center">为<span style="color:red"><?php echo ($group_data['title']); ?></span>分配权限</h1>
<form action="" method="post">
	<input type="hidden" name="id" value="<?php echo ($group_data['id']); ?>">
	<table class="table table-striped table-bordered table-hover table-condensed
	">
		<?php if(is_array($rule_data)): foreach($rule_data as $key=>$v): if(empty($v['_data'])): ?><tr class="b-group">
					<th width="10%">
						<label>
							<?php echo ($v['title']); ?>
							<input type="checkbox" name="rule_ids[]" value="<?php echo ($v['id']); ?>" <?php if(in_array($v['id'],$group_data['rules'])): ?>checked="checked"<?php endif; ?> onclick="checkAll(this)" >
						</label>
					</th>
					<td></td>
				</tr>
			<?php else: ?>
				<tr class="b-group">
					<th width="10%">
						<label>
							<?php echo ($v['title']); ?> <input type="checkbox" name="rule_ids[]" value="<?php echo ($v['id']); ?>" <?php if(in_array($v['id'],$group_data['rules'])): ?>checked="checked"<?php endif; ?> onclick="checkAll(this)">
						</label>
					</th>
					<td class="b-child">
						<?php if(is_array($v['_data'])): foreach($v['_data'] as $key=>$n): ?><table class="table table-striped table-bordered table-hover table-condensed">
								<tr class="b-group">
									<th width="10%">
										<label>
											<?php echo ($n['title']); ?> <input type="checkbox" name="rule_ids[]" value="<?php echo ($n['id']); ?>" <?php if(in_array($n['id'],$group_data['rules'])): ?>checked="checked"<?php endif; ?> onclick="checkAll(this)">
										</label>
									</th>
									<td>
										<?php if(!empty($n['_data'])): if(is_array($n['_data'])): $i = 0; $__LIST__ = $n['_data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><label>
													&emsp;<?php echo ($c['title']); ?> <input type="checkbox" name="rule_ids[]" value="<?php echo ($c['id']); ?>" <?php if(in_array($c['id'],$group_data['rules'])): ?>checked="checked"<?php endif; ?> >
												</label><?php endforeach; endif; else: echo "" ;endif; endif; ?>
									</td>
								</tr>
							</table><?php endforeach; endif; ?>
					</td>
				</tr><?php endif; endforeach; endif; ?>
		<tr>
			<th></th>
			<td>
				<input class="btn btn-success" type="submit" value="提交">
			</td>
		</tr>
	</table>
</form>
<!-- 引入bootstrjs部分开始 -->
<script src="/doing/Public/statics/js/jquery-1.10.2.min.js"></script>
<script src="/doing/Public/statics/js/jquery.validate.min.js"></script>
<script src="/doing/Public/statics/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script src="/doing/tpl/Public/js/base.js"></script>
<script>
function checkAll(obj){
    $(obj).parents('.b-group').eq(0).find("input[type='checkbox']").prop('checked', $(obj).prop('checked'));
}
</script>
</body>
</html>
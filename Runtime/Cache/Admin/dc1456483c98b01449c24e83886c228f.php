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
    <i class="fa fa-home"></i> 首页 
    &gt;
    后台管理
    &gt;
    员工列表
</div>
<ul id="myTab" class="nav nav-tabs">
   <li class="active">
         <a href="<?php echo U('Admin/Rule/admin_user_list');?>">员工列表</a>
   </li>
   <li>
        <a href="<?php echo U('Admin/Rule/add_admin');?>">添加员工</a>
    </li>
</ul>
<table class="table table-striped table-bordered table-hover table-condensed">
    <tr>
    	<th width="10%">部门名称</th>
    	<th width="10%">职务名称</th>
        <th>用户名</th>
        <th>姓名</th>
        <th>登录权限</th>
        <th>操作</th>
    </tr>
    <?php if(is_array($data)): foreach($data as $key=>$v): ?><tr>
        	<td><?php echo ($v['sector']); ?></td>
        	<td><?php echo ($v['title']); ?></td>
            <td><?php echo ($v['username']); ?></td>
            <td><?php echo ($v['nikename']); ?></td>
            <td><?php echo ($v['status']); ?></td>
            <td>
                <a href="<?php echo U('Admin/Rule/edit_admin',array('id'=>$v['id']));?>">编辑</a>
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
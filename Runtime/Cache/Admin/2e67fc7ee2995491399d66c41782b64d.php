<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>添加管理员 - bjyadmin</title>
        <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/doing/Public/statics/bootstrap-3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/doing/Public/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="/doing/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/doing/Public/statics/css/bjy.css" />
    <link rel="stylesheet" href="/doing/tpl/Public/css/base.css" />
        <link rel="stylesheet" href="/doing/Public/statics/iCheck-1.0.2/skins/all.css">
</head>
<body>

<!-- 导航栏开始 -->
<div class="bjy-admin-nav">
    <i class="fa fa-home"></i> 首页
    &gt;
    后台管理
    &gt;
    添加管理员
</div>
<!-- 导航栏结束 -->
<ul id="myTab" class="nav nav-tabs">
   <li>
         <a href="<?php echo U('Admin/Rule/admin_user_list');?>">管理员列表</a>
   </li>
   <li class="active">
        <a href="<?php echo U('Admin/Rule/add_admin');?>">添加管理员</a>
    </li>
</ul>
<form class="form-inline" method="post" id="myForm">
    <table class="table table-striped table-bordered table-hover table-condensed">
        <tr>
            <th><font color="red">*</font>管理组</th>
            <td>
            	<select name="sector" class="form-control" id="sector">
            		<option value=""></option>
            		<?php if(is_array($sectorList)): foreach($sectorList as $key=>$v): ?><option value="<?php echo ($v['id']); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
            	</select>
            
            	<select name="group_ids[]" id="group" class="form-control"></select>
            
                
            </td>
        </tr>
        <tr>
            <th><font color="red">*</font>用户名</th>
            <td>
                <input class="form-control" type="text" name="username">
            </td>
        </tr>
        <tr>
            <th><font color="red">*</font>姓名</th>
            <td>
                <input class="form-control" type="text" name="nikename">
            </td>
        </tr>
        <tr>
            <th>手机号</th>
            <td>
                <input class="form-control" type="text" name="phone" value="">
            </td>
        </tr>
        <tr>
            <th>邮箱</th>
            <td>
                <input class="form-control" type="text" name="email">
            </td>
        </tr>
        <tr>
            <th>初始密码</th>
            <td>
                <input class="form-control" type="text" name="password">
            </td>
        </tr>
        <tr>
            <th>状态</th>
            <td>
                <span class="inputword">允许登录</span>
                <input class="xb-icheck" type="radio" name="status" value="1" checked="checked">
                &emsp;
                <span class="inputword">禁止登录</span>
                <input class="xb-icheck" type="radio" name="status" value="0">
            </td>
        </tr>
        <tr>
            <th></th>
            <td>
                <input class="btn btn-success" type="submit" value="&nbsp;&nbsp;添&nbsp;&nbsp;加&nbsp;&nbsp;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
<script type="text/javascript">
$(function(){
	 $('#sector').change(function(){
         var value = $(this).val();
         $.ajax({
             url:"<?php echo U('Rule/getGroupBySectorId');?>",
             type:'post',
             data:{
                 groupid:$(this).val()
             },            
             dataType:'json',
             success:function(data){
            	 $("#group").empty();
                 var count = data.length;
                 var i = 0;
                 var b="";
                    for(i=0;i<count;i++){
                        b+="<option value='"+data[i].id+"'>"+data[i].title+"</option>";
                    }
                 $("#group").append(b);
             },
             error:function(data){
            	 alert('获取职务失败,请重试');
           	}
         })


     })

});
$("#myForm").validate({ 
	rules: {
		sector: {
			required: true			
		},
		group: { 
			required: true
		}
	}, 
	messages: { 		
		sector: { 
			required: "必选"
		},
		group: {
		    required: "必选"
		}
	} 
});	
</script>
</body>
</html>
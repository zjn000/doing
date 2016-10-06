<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>修改管理员 - bjyadmin</title>
        <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/doing/Public/statics/bootstrap-3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/doing/Public/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="/doing/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/doing/Public/statics/css/bjy.css" />
    <link rel="stylesheet" href="/doing/tpl/Public/css/base.css" />
        <link rel="stylesheet" href="/doing/Public/statics/iCheck-1.0.2/skins/all.css">
    <style type="text/css">
    	th{
    		width:45%;
    		font-size:14px;
    		text-align: right;   		
    	}
    </style>
</head>
<body>
<!-- 导航栏开始 -->
<div class="bjy-admin-nav">
    <i class="fa fa-home"></i> 首页
    &gt;
    后台管理
    &gt;
    修改密码
</div>
<!-- 导航栏结束 -->

<form class="form-inline" method="post" id="myForm">
    <table class="table table-striped table-bordered table-hover table-condensed">       
        <tr>
            <th >原密码</th>
            <td >
                <input class="form-control input-lg" type="password" name="old_pass" id="old_pass">
            </td>
        </tr>
        <tr>
            <th>新密码</th>
            <td>
                <input class="form-control input-lg" type="password" name="new_pass" id="new_pass">
            </td>
        </tr>
        <tr>
            <th>确认密码</th>
            <td>
                <input class="form-control input-lg" type="password" name="password" id="password">
            </td>           
        </tr>
        
        <tr>
            <td colspan="2" style="text-align: center;">
                <input class="btn btn-success" type="submit" value="&nbsp;修&nbsp;改&nbsp;">&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="btn btn-success" href="javascript:history.go(-1);">&nbsp;取&nbsp;消&nbsp;</a>
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
$("#myForm").validate({ 
	rules: {
		old_pass: {
			required: true			
		},
		new_pass: { 
			required: true, 
			minlength: 6 
		},		
		password: {
	    	required: true,
	    	minlength: 6,
	    	equalTo: "#new_pass"
	   	}
	}, 
	messages: { 		
		old_pass: { 
			required: "请输入原密码"
		},
		new_pass: {
		    required: "请输入新密码",
		    minlength: "密码不能小于6个字 符"
		},
		password: {
	    	required: "请输入确认密码",
	    	minlength: "确认密码不能小于6个字符",
	    	equalTo: "两次输入密码不一致"
	   }
	} 
});	
</script>
</body>
</html>
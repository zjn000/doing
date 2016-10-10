<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>修改员工</title>
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
    修改员工
</div>
<!-- 导航栏结束 -->
<ul id="myTab" class="nav nav-tabs">
   <li>
         <a href="<?php echo U('Admin/Rule/admin_user_list');?>">员工列表</a>
   </li>
   <li class="active">
        <a href="<?php echo U('Admin/Rule/add_admin');?>">修改员工</a>
    </li>
</ul>
<form class="form-inline" method="post" id="myForm">
    <input type="hidden" name="id" value="<?php echo ($user_data['id']); ?>">
    <table class="table table-striped table-bordered table-hover table-condensed">
        <tr>
            <th><font color="red">*</font>管理组</th>
            <td>
                <select name="sector" class="form-control" id="sector">
            		<?php if(is_array($sectorList)): $i = 0; $__LIST__ = $sectorList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if(($sector_id) == $vo["id"]): ?>selected<?php endif; ?>  ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            	</select>
            
            	<select name="group_ids[]" id="group" class="form-control"></select>
                
            </td>
        </tr>
        <tr>
            <th><font color="red">*</font>用户名</th>
            <td>
                <input class="form-control" type="hidden" name="username" value="<?php echo ($user_data['username']); ?>" />
                <label for="username" >&nbsp;<?php echo ($user_data['username']); ?></label>
            </td>
        </tr>
        <tr>
            <th><font color="red">*</font>姓名</th>
            <td>
                <input class="form-control" type="text" name="nikename" value="<?php echo ($user_data['nikename']); ?>">
            </td>
        </tr>
        <tr>
            <th>数据范围</th>
            <td>
            	<span class="inputword">局部</span>
                <input class="xb-icheck" type="radio" name="data_range" value="0" <?php if(($user_data['data_range']) == "0"): ?>checked="checked"<?php endif; ?> >
                &emsp;
                <span class="inputword">全局</span>
                <input class="xb-icheck" type="radio" name="data_range" value="1" <?php if(($user_data['data_range']) == "1"): ?>checked="checked"<?php endif; ?> >                               
            </td>
        </tr>
        <tr>
            <th>所属大区</th>
            <td>
                <select name="region" class="form-control">
	            	<?php $_result=C('USER_REGION_CONFIG');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($key) == $user_data['region']): ?>selected<?php endif; ?> ><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>  
            	</select>
            </td>
        </tr>
        <tr>
            <th>手机号</th>
            <td>
                <input class="form-control" type="text" name="phone" value="<?php echo ($user_data['phone']); ?>">
            </td>
        </tr>
        <tr>
            <th>邮箱</th>
            <td>
                <input class="form-control" type="text" name="email" value="<?php echo ($user_data['email']); ?>">
            </td>
        </tr>
        <tr>
            <th>初始密码</th>
            <td>
                <input class="form-control" type="text" name="password">如不改密码；留空即可
            </td>
        </tr>
        <tr>
            <th>状态</th>
            <td>
                <span class="inputword">允许登录</span>
                <input class="xb-icheck" type="radio" name="status" value="1" <?php if(($user_data['status']) == "1"): ?>checked="checked"<?php endif; ?> >
                &emsp;
                <span class="inputword">禁止登录</span>
                <input class="xb-icheck" type="radio" name="status" value="0" <?php if(($user_data['status']) == "0"): ?>checked="checked"<?php endif; ?> >
            </td>
        </tr>
        <tr>
            <th></th>
            <td>
                <input class="btn btn-success" type="submit" value="&nbsp;&nbsp;修&nbsp;&nbsp;改&nbsp;&nbsp;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
	
	$.ajax({
        url:"<?php echo U('Rule/getGroupBySectorId');?>",
        type:'post',
        data:{
            groupid:<?php echo ($sector_id); ?>
        },            
        dataType:'json',
        success:function(data){
       	 $("#group").empty();
            var count = data.length;
            var i = 0;
            var b="";
               for(i=0;i<count;i++){
            	   
            	   if(data[i].id == <?php echo ($group_id); ?>)
            	   {
            		   b+="<option value='"+data[i].id+"'  selected  >"+data[i].title+"</option>";
            	   }else{
                   		b+="<option value='"+data[i].id+"'>"+data[i].title+"</option>";
            	   }
               }
            $("#group").append(b);
        },
        error:function(data){
       	 alert('获取职务失败,请重试');
      	}
    })
	
	
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
		},
		username: { 
			required: true
		},
		nikename: { 
			required: true
		}
	}, 
	messages: { 		
		sector: { 
			required: "必选"
		},
		group: {
		    required: "必选"
		},
		username: {
		    required: "必填"
		},
		nikename: {
		    required: "必填"
		}
	} 
});
</script>
</body>
</html>
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>后台管理系统</title>
        <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/doing/Public/statics/bootstrap-3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/doing/Public/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="/doing/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/doing/Public/statics/css/bjy.css" />
    <link rel="stylesheet" href="/doing/tpl/Public/css/base.css" />
    <link rel="stylesheet" href="/doing/Public/statics/webuploader-0.1.5/xb-webuploader.css">
<script src="/doing/Public/statics/js/jquery-1.10.2.min.js"></script>
    <style type="text/css">
    .login-page {
	  background: #fff;
	  margin-top: 15%;
	}
	.login-page .login-content {
	  position: relative;
	  width: 320px;
	  margin: 0 auto;
	  text-align: center;	  
	  -moz-transition: all 550ms ease-in-out;
	  -o-transition: all 550ms ease-in-out;
	  -webkit-transition: all 550ms ease-in-out;
	  transition: all 550ms ease-in-out;
	}    
    </style>
</head>
<body class="login-page">
<div class="login-form">

		<div class="login-content">

			<div class="form-login-error">
				<h3>Invalid login</h3>
				<br />				
			</div>

			<form method="post" role="form" id="form_login">

				<div class="form-group">

					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-user"></i>
						</div>

						<input type="text" class="form-control" name="username" id="username" value="admin" placeholder="Username" autocomplete="off" />
					</div>

				</div>

				<div class="form-group">

					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-key"></i>
						</div>

						<input type="password" class="form-control" name="password" id="password" value="123456" placeholder="Password" autocomplete="off" />
					</div>

				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block btn-login">
						<i class="fa fa-sign-in"></i>
						Login In
					</button>
				</div>		
			</form>
		</div>
</div>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
<title>AVS - Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta content="" name="description" />
<meta content="" name="author" />
<!-- BEGIN CORE CSS FRAMEWORK -->
<link href="{$relative_tpl}/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="{$relative_tpl}/assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="{$relative_tpl}/assets/plugins/boostrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
<link href="{$relative_tpl}/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
<link href="{$relative_tpl}/assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
<!-- END CORE CSS FRAMEWORK -->
<!-- BEGIN CSS TEMPLATE -->
<link href="{$relative_tpl}/assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="{$relative_tpl}/assets/css/responsive.css" rel="stylesheet" type="text/css"/>
<link href="{$relative_tpl}/assets/css/custom-icon-set.css" rel="stylesheet" type="text/css"/>
<!-- END CSS TEMPLATE -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="error-body no-top lazy"  data-original="{$relative_tpl}/assets/img/background.jpg"  style="background-image: url('{$relative_tpl}/assets/img/background.jpg'); background-position: center top; background-size: 100% auto;"> 
<div class="container">
  <div class="row login-container animated fadeInUp">  
        <div class="col-md-7 col-md-offset-2 tiles white no-padding">
		<form class="animated fadeIn" name="login" id="login" method="POST" action="login.php">
		 <div class="p-t-30 p-l-30 p-r-30 p-b-20 xs-p-t-10 xs-p-l-10 xs-p-b-10"> 
          <h2 class="normal">Sign in to AVS Admin Panel</h2>
				<p class="p-b-20">Please provide your admin username and password.</p>
				<div class="row form-row">
					<div class="col-md-6 col-sm-6 ">
						<input name="username" id="username" type="text" value="{$username}" class="form-control {if $err.account}error{/if}" placeholder="Username">
					</div>
					<div class="col-md-6 col-sm-6">
						<input name="password" id="password" type="password" value="{$password}" class="form-control {if $err.account}error{/if}" placeholder="Password">
					</div>
				</div>
				<div class="row m-r-20 xs-m-l-10 xs-m-r-10">
					<div class="col-xs-12">
						{if $errors}
							<p class="p-b-10 text-danger">
								{section name=i loop=$errors}
									{$errors[i]}<br />
								{/section}
							</p>
						{elseif $messages}
							<p class="p-b-10 text-success">
								{section name=i loop=$messages}
									{$messages[i]}<br />
								{/section}
							</p>
						{/if}						
						<a id="remember_account" href="#">Trouble login in?</a>&nbsp;&nbsp;
					</div>
				</div>
		  

        </div>
		<div class="tiles grey p-t-20 p-b-20  p-l-30 p-r-30 text-black">
		  <input type="submit" name="submit_login" class="btn btn-primary btn-cons" value="Login" />
		  <span id="submit_forgot" style="display:none" >
			<input type="submit" name="submit_forgot" class="btn btn-info btn-cons" value="Remember Password" />
		  <span>
		</div>   
		</form>		
      </div>   
  </div>
</div>
<!-- END CONTAINER -->
<!-- BEGIN CORE JS FRAMEWORK-->
<script src="{$relative_tpl}/assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="{$relative_tpl}/assets/plugins/boostrapv3/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{$relative_tpl}/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
<script src="{$relative_tpl}/assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="{$relative_tpl}/assets/plugins/jquery-lazyload/jquery.lazyload.min.js" type="text/javascript"></script>
<script src="{$relative_tpl}/assets/js/admin/jquery.login.js" type="text/javascript"></script>
<!-- BEGIN CORE TEMPLATE JS -->
<!-- END CORE TEMPLATE JS -->
</body>

</html>
<!DOCTYPE html>
<html>
<head>
	<title>AVS - Admin Dashboard</title>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
    <link href="{$relative_tpl}/assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" media="screen"/>
	<link href="{$relative_tpl}/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
	<link href="{$relative_tpl}/assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css"/>
	<link href="{$relative_tpl}/assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="{$relative_tpl}/assets/plugins/boostrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
	<link href="{$relative_tpl}/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
	<link href="{$relative_tpl}/assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
	<link href="{$relative_tpl}/assets/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="{$relative_tpl}/assets/css/responsive.css" rel="stylesheet" type="text/css"/>
	<link href="{$relative_tpl}/assets/css/custom-icon-set.css" rel="stylesheet" type="text/css"/>
	
	<link href="{$relative_tpl}/assets/plugins/jquery-notifications/css/messenger.css" rel="stylesheet" type="text/css" media="screen"/>
	<link href="{$relative_tpl}/assets/plugins/jquery-notifications/css/messenger-theme-flat.css" rel="stylesheet" type="text/css" media="screen"/>
	<link href="{$relative_tpl}/assets/plugins/jquery-notifications/css/location-sel.css" rel="stylesheet" type="text/css" media="screen"/>	
	{if $active_menu == 'dashboard'}
		<link rel="stylesheet" href="{$relative_tpl}/assets/plugins/jquery-ricksaw-chart/css/rickshaw.css" type="text/css" media="screen" >
		<link rel="stylesheet" href="{$relative_tpl}/assets/plugins/jquery-morris-chart/css/morris.css" type="text/css" media="screen">
	{/if}
	{if isset($editor)}
		<link href="{$relative_tpl}/assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css">
	{/if}	
	{if $sub_menu == 'add-videos' || $sub_menu == 'add-albums' || $sub_menu == 'add-games' || $module == 'advmediaadd' || $module == 'advmediaedit' || $module == 'list' || $module == 'listalbum' || $module == 'listgame' || $module == 'list_images'}
		<link href="{$relative_tpl}/assets/css/file-box.css" rel="stylesheet" type="text/css"/>		
	{elseif $sub_menu == 'manage-albums'}
		<link href="{$relative_tpl}/assets/css/file-box.css" rel="stylesheet" type="text/css"/>			
		<link href="{$relative_tpl}/assets/css/imageareaselect/imgareaselect-animated.css" rel="stylesheet" type="text/css"/>
	{elseif $sub_menu == 'manage-games' || $sub_menu == 'manage-users' || $sub_menu == 'user-requests' || $sub_menu == 'add-users' || $module == 'logo'|| $module == 'playerlogo'}
		<link href="{$relative_tpl}/assets/css/file-box.css" rel="stylesheet" type="text/css"/>
	{/if}
	{if $sub_menu == 'player-settings' || $sub_menu == 'add-videos'}
		<link href="{$relative_tpl}/assets/plugins/boostrap-slider/css/slider.css" rel="stylesheet" type="text/css"/>	
	{/if}
</head>
<body class="">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse"> 
	<!-- BEGIN TOP NAVIGATION BAR -->
	<div class="navbar-inner">
		<!-- BEGIN NAVIGATION HEADER -->
		<div class="header-seperation"> 
			<!-- BEGIN MOBILE HEADER -->
			<ul class="nav pull-left notifcation-center" id="main-menu-toggle-wrapper" style="display:none">	
				<li class="dropdown">
					<a id="main-menu-toggle" href="#main-menu" class="">
						<div class="iconset top-menu-toggle-white"></div>
					</a>
				</li>		 
			</ul>
			<!-- END MOBILE HEADER -->
			<!-- BEGIN LOGO -->	
			<a href="index.php">
				<img src="{$relative_tpl}/assets/img/logo.png" class="logo" alt="" data-src="{$relative_tpl}/assets/img/logo.png" data-src-retina="{$relative_tpl}/assets/img/logo2x.png" width="117" height="24"/>
			</a>
			<!-- END LOGO --> 
			<!-- BEGIN LOGO NAV BUTTONS -->
			<ul class="nav pull-right notifcation-center">	
				<li class="dropdown" id="header_task_bar">
					<a href="index.php" class="dropdown-toggle active" data-toggle="">
						<div class="iconset top-home"></div>
					</a>
				</li>		        
			</ul>
			<!-- END LOGO NAV BUTTONS -->
		</div>
		<!-- END NAVIGATION HEADER -->
		<!-- BEGIN CONTENT HEADER -->
		<div class="header-quick-nav"> 
			<!-- BEGIN HEADER LEFT SIDE SECTION -->
			<div class="pull-left"> 
				<!-- BEGIN SLIM NAVIGATION TOGGLE -->
				<ul class="nav quick-section">
					<li class="quicklinks">
						<a href="#" class="" id="layout-condensed-toggle">
							<div class="iconset top-menu-toggle-dark"></div>
						</a>
					</li>
				</ul>
				<!-- END SLIM NAVIGATION TOGGLE -->			
			</div>
			<!-- END HEADER LEFT SIDE SECTION -->
			<!-- BEGIN HEADER RIGHT SIDE SECTION -->
			<div class="pull-right"> 
				<div class="chat-toggler">	
					<!-- BEGIN NOTIFICATION CENTER -->
					<a href="#" class="dropdown-toggle" id="my-task-list" data-placement="bottom" data-content="" data-toggle="dropdown" data-original-title="Notifications">
						<div class="user-details"> 
							<div class="username">
								{if $n_total > 0}<span class="badge badge-important">{$n_total}</span>&nbsp;{/if}{$admin_name}
							</div>						
						</div> 
						<div class="iconset top-down-arrow"></div>
					</a>	
					<div id="notification-list" style="display:none">
						<div style="width:300px">						
							<!-- BEGIN NOTIFICATION MESSAGE -->
							{if $n_total > 0}
								{section name=i loop=$notifications}
									{if $notifications[i].total > 0}							
										<div class="notification-messages danger">										
											<div class="message-wrapper">
												<a href="{$notifications[i].link}">
													<div class="heading">{$notifications[i].type1}: <span class="normal">{$notifications[i].type2}</span></div>
													<div class="description">{$notifications[i].total} {if $notifications[i].total != 1}requests{else}request{/if}</div>
													<div class="date pull-left">Check</div>										
												</a>
											</div>
											<div class="clearfix"></div>									
										</div>							
									{/if}
								{/section}							
							{else}
								<div class="notification-messages">										
									<div class="message-wrapper">
											<div class="heading">You are lucky!</div>
											<div class="description">There are no warnings.</div>								
									</div>
									<div class="clearfix"></div>									
								</div>								
							{/if}
							<!-- END NOTIFICATION MESSAGE -->	
						</div>				
					</div>
					<!-- END NOTIFICATION CENTER -->			
				</div>
				<!-- BEGIN HEADER NAV BUTTONS -->
				<ul class="nav quick-section">
					<!-- BEGIN SETTINGS -->
					<li class="quicklinks"> 
						<a data-toggle="dropdown" class="dropdown-toggle pull-right" href="#" id="user-options">						
							<div class="iconset top-settings-dark"></div> 	
						</a>
						<ul class="dropdown-menu pull-right" role="menu" aria-labelledby="user-options">
							<li><a href="index.php?m=admin">My Account</a></li>
							<li class="divider"></li>                
							<li><a href="logout.php"><i class="fa fa-power-off"></i>&nbsp;&nbsp;Logout</a></li>
						</ul>
					</li>
					<!-- END SETTINGS -->
				</ul>
				<!-- END HEADER NAV BUTTONS -->
			</div>
			<!-- END HEADER RIGHT SIDE SECTION -->
		</div> 
		<!-- END CONTENT HEADER --> 
	</div>
	<!-- END TOP NAVIGATION BAR --> 
</div>
<!-- END HEADER -->
	
<!-- BEGIN CONTENT -->
<div class="page-container row-fluid">
	<!-- BEGIN SIDEBAR -->
	<!-- BEGIN MENU -->
	<div class="page-sidebar" id="main-menu"> 
		  <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">
		<!-- BEGIN MINI-PROFILE -->
		<div class="user-info-wrapper">	
			<div class="profile-wrapper">
				<img src="{$relative_tpl}/assets/img/profiles/avatar.png" alt="" data-src="{$relative_tpl}/assets/img/profiles/avatar.png" data-src-retina="{$relative_tpl}/assets/img/profiles/avatar2x.png" width="65" height="65" />
			</div>
			<div class="user-info">
				<div class="greeting">Welcome</div>
				<div class="username">{$admin_name}</div>
				<div class="status text-gray"><a href="logout.php"><i class="fa fa-power-off m-r-5"></i>Logout</a></div>
			</div>
		</div>
		<!-- END MINI-PROFILE -->
		<!-- BEGIN SIDEBAR MENU -->	
		<ul>	

			<li class="start {if $active_menu == 'dashboard'}active{/if}">
				<a href="index.php">
					<i class="icon-custom-home"></i>
					<span class="title">Dashboard</span>
				</a>
			</li>
			{include file='leftmenu/settings.tpl'}
			{include file='leftmenu/videos.tpl'}
			{include file='leftmenu/albums.tpl'}
			{include file='leftmenu/blogs.tpl'}
			{include file='leftmenu/users.tpl'}
			{include file='leftmenu/channels.tpl'}
			{include file='leftmenu/notices.tpl'}
			{if $multi_server == '1'}
				{include file='leftmenu/servers.tpl'}
			{/if}
		</ul>
		<!-- END SIDEBAR MENU -->

	</div>
	</div>
	<!-- BEGIN SCROLL UP HOVER -->
	<a href="#" class="scrollup">Scroll</a>
	<!-- END SCROLL UP HOVER -->
	<!-- END MENU -->
	<!-- BEGIN SIDEBAR FOOTER WIDGET -->
	<div class="footer-widget">
		<div class="pull-left">
			Powered by <a href="https://www.avscms.com" target="_blank">AVSCMS</a>
		</div>	
		<div class="pull-right">
			<a href="logout.php"><i class="fa fa-power-off"></i></a>
		</div>
	</div>
	<!-- END SIDEBAR FOOTER WIDGET -->
	<!-- END SIDEBAR --> 
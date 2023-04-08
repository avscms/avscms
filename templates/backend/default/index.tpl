	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">  
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Dashboard</h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="col-md-12">
				<div class="row m-b-15"> 
					<div class="col-lg-4 col-md-4">
						<div class="tiles blue m-b-10">
							<div class="tiles-body">
								<div class="controller"> <a href="javascript:;" class="remove"></a> </div>				
								<div class="tiles-title text-black">VIDEOS </div>
								<div class="heading"> <a href="videos.php?m=all&all=1" class="text-white"><span class="animate-number" data-value="{$videos.total}" data-animation-duration="700">0</span></a> </div>								
								<div class="widget-stats">
									<div class="wrapper transparent"> 
										<span class="item-title">Active</span> 
										<a href="videos.php?m=all&status=1">										
											<span class="item-count animate-number semi-bold" data-value="{$videos.active}" data-animation-duration="700">0</span>
										</a>
									</div>
								</div>
								<div class="widget-stats">
									<div class="wrapper last">
										<span class="item-title">Suspended</span> 
										<a href="videos.php?m=all&status=0">
											<span class="item-count animate-number semi-bold" data-value="{$videos.suspended}" data-animation-duration="700">0</span> 
										</a>
									</div>
								</div>					
							</div>			
						</div>	
					</div>
					<div class="col-lg-4 col-md-4">
						<div class="tiles green m-b-10">
							<div class="tiles-body">
								<div class="controller"> <a href="javascript:;" class="remove"></a> </div>				
								<div class="tiles-title text-black">ALBUMS </div>
								<div class="heading"> <a href="albums.php?m=all&all=1" class="text-white"><span class="animate-number" data-value="{$albums.total}" data-animation-duration="700">0</span></a> </div>								
								<div class="widget-stats">
									<div class="wrapper transparent"> 
										<span class="item-title">Active</span> 
										<a href="albums.php?m=all&status=1">										
											<span class="item-count animate-number semi-bold" data-value="{$albums.active}" data-animation-duration="700">0</span>
										</a>
									</div>
								</div>
								<div class="widget-stats">
									<div class="wrapper last">
										<span class="item-title">Suspended</span> 
										<a href="albums.php?m=all&status=0">
											<span class="item-count animate-number semi-bold" data-value="{$albums.suspended}" data-animation-duration="700">0</span> 
										</a>
									</div>
								</div>					
							</div>			
						</div>	
					</div>
					<div class="col-lg-4 col-md-4">
						<div class="tiles purple m-b-10">
							<div class="tiles-body">
								<div class="controller"> <a href="javascript:;" class="remove"></a> </div>				
								<div class="tiles-title text-black">USERS </div>
								<div class="heading"> <a href="users.php?m=all&all=1" class="text-white"><span class="animate-number" data-value="{$users.total}" data-animation-duration="700">0</span></a> </div>								
								<div class="widget-stats">
									<div class="wrapper transparent"> 
										<span class="item-title">Active</span> 
										<a href="users.php?m=all&status=1">										
											<span class="item-count animate-number semi-bold" data-value="{$users.active}" data-animation-duration="700">0</span>
										</a>
									</div>
								</div>
								<div class="widget-stats">
									<div class="wrapper last">
										<span class="item-title">Suspended</span> 
										<a href="users.php?m=all&status=0">
											<span class="item-count animate-number semi-bold" data-value="{$users.suspended}" data-animation-duration="700">0</span> 
										</a>
									</div>
								</div>					
							</div>			
						</div>	
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="grid simple">
							<div class="grid-title no-border">
								<div class="tools"> <a href="javascript:;" class="remove"></a> </div>
							</div>
							<div class="grid-body no-border">
								<div class="row">
									<div class="col-xs-12">
										<h4>File <span class="semi-bold">Uploads</span></h4>
										<p>{$v_total} {if $v_total != 1}videos{else}video{/if}, {$a_total} {if $a_total != 1}albums{else}album{/if} have been added in the last 7 days</p>
										<div id="file-uploads"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="grid simple">
							<div class="grid-title no-border">
								<div class="tools"> <a href="javascript:;" class="remove"></a> </div>
							</div>
							<div class="grid-body no-border">
								<div class="row">
									<div class="col-xs-12">
										<h4>Member <span class="semi-bold">Registrations</span></h4>
										<p>{$m_total} new {if $m_total != 1}members{else}member{/if} in the last 7 days</p>
										<div id="member-registration"></div>
									</div>
								</div>
							</div>
						</div>
					</div>						
				</div>
				<div class="row">
					<div class="col-md-8 col-sm-6">
						<div class="tiles white m-b-25">
							<div class="tiles-body">
								<div class="controller">								
									<a href="javascript:;" class="remove"></a>									
								</div>
								<div class="tiles-title">
									NEWS
								</div>							
								<br />
								<div class="row-fluid">
									<div class="slim-scroller" data-height="249px" data-always-visible="1">
										{$news}
									</div>
								</div>
							</div>
						</div>
					</div>		  			
			
					<div class="col-md-4 col-sm-6">
						<div class="form-row">
							<div class="tiles white m-b-25">
								<div class="tiles-body">
									<div class="controller"> <a href="javascript:;" class="remove"></a> </div>
									<div class="tiles-title text-black"> SERVER LOAD </div>
									<div class="heading"> <span class="text-black"><i class="fa fa-bar-chart-o p-r-10"></i></span><span class="{if $load[0] lt 10}text-green{elseif $load[0] lt 15}text-yellow{else}text-red{/if}">{$load[0]}</span> </div>
									<div class="description text-black">
										Last 5 minutes avg: <span class="bold {if $load[1] lt 10}text-green{elseif $load[1] lt 15}text-yellow{else}text-red{/if}">{$load[1]}</span><br />
										Last 15 minutes avg: <span class="bold {if $load[2] lt 10}text-green{elseif $load[2] lt 15}text-yellow{else}text-red{/if}">{$load[2]}</span>
									</div>
								</div>
							</div>
						</div>
					<div class="form-row">			
						<div class="tiles white m-b-25">
							<div class="tiles-body">
								<div class="controller"> <a href="javascript:;" class="remove"></a> </div>
								<div class="tiles-title text-black"> VERSION INFO </div>
								<div class="heading"> <span class="text-black"><i class="fa fa-info p-r-10"></i></span><span {if $version_lva gt $version_c}class="text-red"{else}class="text-green"{/if}>{$version_c}</span> </div>
								<div class="description"><span class="text-black">Last version available: {$version_lva}</span></div>
							</div>
						</div>			  
					</div>
					</div>				
				</div>
			</div>			
			<!-- END PLACE PAGE CONTENT HERE -->
		</div>
	</div>
	<!-- END PAGE CONTAINER -->	
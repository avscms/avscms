	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">  
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Settings - <span class="semi-bold">AVSCMS Updates</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>Check <span class="semi-bold">Updates</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="update_form" method="POST" enctype="multipart/form-data" action="index.php?m=update-step1">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3 col-md-12">					
									<div class="col-xs-12 m-b-5">
										<h4>Installed Version: <span class="semi-bold">{$version_c}</span></h4>
										<h4>Official Version: <span class="semi-bold">{$official_version}</span></h4>
										<h4>{if $is_update_available}<strong style="color:green">New update is available.</strong>{else}Your script are up to date.{/if}</h4>
									</div>																	
								</div>				
							</div>
							<input type="hidden" name="update_page" class="update_page" value="step0" >
							<input type="hidden" name="from_to_version" class="from_to_version" value="{$version_c} to {$official_version}" >
							<input type="hidden" name="file_version" class="file_version" value="{$version_c}-{$official_version}.zip" >	
							<div class="form-actions">
								<div class="pull-right">
									{if $is_update_available}
									<input type="submit" name="update-step1" value="Update" class="btn btn-success btn-cons">
									{/if}
									<a href="index.php" class="btn btn-white btn-cons">Cancel</a>
								</div>
							</div>									
						</form>
					</div>
				</div>
			</div>			
			<!-- END PLACE PAGE CONTENT HERE -->
		</div>
	</div>
	<!-- END PAGE CONTAINER -->	
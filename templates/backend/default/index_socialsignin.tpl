	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">  
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Settings - <span class="semi-bold">General</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>Social <span class="semi-bold">Sign-in</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="socialsignin_settings" method="POST" action="index.php?m=socialsignin">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3 col-md-12">
									<div class="row">
										<div class="col-xs-12 m-b-5">
											<h3>Facebook <span class="semi-bold">Settings</span></h3>
										</div>									
										<div class="form-group">
											<label class="col-lg-4 control-label">Sign-in</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="fb_signin_e" type="radio" name="fb_signin" value="1" {if $fb_signin == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="fb_signin_e">Enabled</label>
													<input id="fb_signin_d" type="radio" name="fb_signin" value="0" {if $fb_signin == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="fb_signin_d">Disabled</label>
												</div>												
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">App ID</label>
											<div class="col-lg-8">
												<input type="text" name="fb_appid" value="{$fb_appid}" class="form-control {if $err.fb_appid}error{/if}">
												<span class="help">If you don't have an App ID, please visit <a href="https://developers.facebook.com/apps" target="_blank">Facebook Developers Apps page</a>, to get one.</span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="col-xs-12 m-b-5">
											<h3>Google <span class="semi-bold">Settings</span></h3>
										</div>									
										<div class="form-group">
											<label class="col-lg-4 control-label">Sign-in</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="g_signin_e" type="radio" name="g_signin" value="1" {if $g_signin == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="g_signin_e">Enabled</label>
													<input id="g_signin_d" type="radio" name="g_signin" value="0" {if $g_signin == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="g_signin_d">Disabled</label>
												</div>												
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">App ID</label>
											<div class="col-lg-8">
												<input type="text" name="g_cid" value="{$g_cid}" class="form-control {if $err.g_cid}error{/if}">
												<span class="help">If you don't have a Client ID, please visit <a href="https://console.developers.google.com/" target="_blank">Google API Console page</a>, to get one.</span>
											</div>
											<div class="clearfix"></div>
										</div>										
									</div>									
								</div>
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="submit_socialsignin" value="Save" class="btn btn-success btn-cons">
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
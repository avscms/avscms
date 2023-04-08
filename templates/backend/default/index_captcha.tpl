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
						<h4>Sign-in <span class="semi-bold">Captcha</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="captcha_settings" method="POST" action="index.php?m=captcha">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3 col-md-12">
									<div class="row">
										<div class="col-xs-12 m-b-5">
											<h3>reCAPTCHA <span class="semi-bold">Settings</span></h3>
										</div>									
										<div class="form-group">
											<label class="col-lg-4 control-label">reCAPTCHA</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="captcha_e" type="radio" name="captcha" value="1" {if $captcha == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="captcha_e">Enabled</label>
													<input id="captcha_d" type="radio" name="captcha" value="0" {if $captcha == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="captcha_d">Disabled</label>
												</div>												
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Site Key</label>
											<div class="col-lg-8">
												<input type="text" name="recaptcha_site_key" value="{$recaptcha_site_key}" class="form-control {if $err.recaptcha_site_key}error{/if}">												
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Secret Key</label>
											<div class="col-lg-8">
												<input type="text" name="recaptcha_secret_key" value="{$recaptcha_secret_key}" class="form-control {if $err.recaptcha_secret_key}error{/if}">
												<span class="help">If you don't have reCAPTCHA keys, please visit <a href="https://www.google.com/recaptcha/admin" target="_blank">Google reCAPTCHA</a> and register your domain name.</span>
											</div>
											<div class="clearfix"></div>
										</div>										
									</div>									
								</div>
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="submit_captcha" value="Save" class="btn btn-success btn-cons">
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
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
						<h4>Mail <span class="semi-bold">Configuration</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="mail_settings" method="POST" action="index.php?m=mail">						
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3 col-md-12">
									<div class="row">
										<div class="col-xs-12 m-b-5">
											<h3>Mail <span class="semi-bold">Settings</span></h3>
										</div>									
										<div class="form-group">
											<label class="col-lg-4 control-label">Mailer</label>
											<div class="col-lg-8">
												<select id="mailer" name="mailer" style="width:100%">
													<option value="mail"{if $mailer == 'mail'} selected="selected"{/if}>PHP Mail Function</option>
													<option value="sendmail"{if $mailer == 'sendmail'} selected="selected"{/if}>Sendmail</option>
													<option value="smtp"{if $mailer == 'smtp'} selected="selected"{/if}>SMTP Server</option>
												</select>
											</div>
											<div class="clearfix"></div>
										</div>
										<div id="sendmail-group" {if $mailer != 'sendmail'}style="display:none"{/if}>
											<div class="form-group">
												<label class="col-lg-4 control-label">Sendmail Path</label>
												<div class="col-lg-8">
													<input type="text" name="sendmail" value="{$sendmail}" class="form-control {if $err.sendmail}error{/if}">
												</div>
												<div class="clearfix"></div>
											</div>
										</div>
										<div id="smtp-group" {if $mailer != 'smtp'}style="display:none"{/if}>
											<div class="form-group">
												<label class="col-lg-4 control-label">SMTP Server</label>
												<div class="col-lg-8">
													<input type="text" name="smtp" value="{$smtp}" class="form-control {if $err.smtp}error{/if}">
												</div>
												<div class="clearfix"></div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 control-label">SMTP Port</label>
												<div class="col-lg-8">
													<input type="text" name="smtp_port" value="{$smtp_port}" class="form-control {if $err.smtp_port}error{/if}">
												</div>
												<div class="clearfix"></div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 control-label">SMTP Prefix</label>
												<div class="col-lg-8">
													<select id="smtp_prefix" name="smtp_prefix" style="width:100%">
														<option value="false"{if $smtp_prefix == 'false'} selected="selected"{/if}>Default</option>
														<option value="ssl"{if $smtp_prefix == 'ssl'} selected="selected"{/if}>SSL</option>
														<option value="tls"{if $smtp_prefix == 'tls'} selected="selected"{/if}>TLS</option>
														<option value="STARTTLS"{if $smtp_prefix == 'STARTTLS'} selected="selected"{/if}>STARTTLS</option>
													</select>
												</div>
												<div class="clearfix"></div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 control-label">SMTP AutoTLS</label>
												<div class="col-lg-8">
													<select id="smtp_autotls" name="smtp_autotls" style="width:100%">
														<option value="false"{if $smtp_autotls == 'false'} selected="selected"{/if}>Disabled</option>
														<option value="true"{if $smtp_autotls == 'true'} selected="selected"{/if}>Enabled</option>
													</select>
												</div>
												<div class="clearfix"></div>
											</div>	
											<div class="form-group">
												<label class="col-lg-4 control-label">SMTP Debugging</label>
												<div class="col-lg-8">
													<select id="smtp_debug" name="smtp_debug" style="width:100%">
														<option value="0"{if $smtp_debug == '0'} selected="selected"{/if}>Disabled</option>
														<option value="1"{if $smtp_debug == '1'} selected="selected"{/if}>1 (client messages)</option>
														<option value="2"{if $smtp_debug == '2'} selected="selected"{/if}>2 (client and server messages)</option>
													</select>
												</div>
												<div class="clearfix"></div>
											</div>												
											<div class="form-group">
												<label class="col-lg-4 control-label">SMTP Authentification</label>
												<div class="col-lg-8">
													<div class="radio p-t-9">
														<input id="smtp_auth_y" type="radio" name="smtp_auth" value="1" {if $smtp_auth == '1'}checked="checked"{/if} class="radio-enabled">
														<label for="smtp_auth_y">Yes</label>
														<input id="smtp_auth_n" type="radio" name="smtp_auth" value="0" {if $smtp_auth == '0'}checked="checked"{/if} class="radio-disabled">
														<label for="smtp_auth_n">No</label>
													</div>												
												</div>
												<div class="clearfix"></div>
											</div>
											<div id="smtp-a-group" {if $smtp_auth == '0'}style="display:none"{/if}>
												<div class="form-group">
													<label class="col-lg-4 control-label">SMTP Username</label>
													<div class="col-lg-8">
														<input type="text" name="smtp_username" value="{$smtp_username}" class="form-control {if $err.smtp_username}error{/if}">
													</div>
													<div class="clearfix"></div>
												</div>
												<div class="form-group">
													<label class="col-lg-4 control-label">SMTP Password</label>
													<div class="col-lg-8">
														<input type="password" name="smtp_password" value="{$smtp_password}" class="form-control {if $err.smtp_password}error{/if}">
													</div>
													<div class="clearfix"></div>
												</div>
											</div>
										</div>
									</div>									
								</div>
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="submit_mail" value="Save" class="btn btn-success btn-cons">
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
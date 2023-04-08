	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">  
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Settings - <span class="semi-bold">Security</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>Sessions</h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="session_settings" method="POST" action="index.php?m=sessions">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3 col-md-12">
									<div class="row">
										<div class="col-xs-12 m-b-5">
											<h3>Session <span class="semi-bold">Settings</span></h3>
										</div>									
										<div class="form-group">
											<label class="col-lg-4 control-label">Session Driver</label>
											<div class="col-lg-8">
												<select id="session_driver" name="session_driver" style="width:100%">
													<option value="files"{if $session_driver == 'files'} selected="selected"{/if}>Files</option>
													<option value="database"{if $session_driver == 'database'} selected="selected"{/if}>Database</option>
												</select>											
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Session Lifetime</label>
											<div class="col-lg-8">
												<input type="text" name="session_lifetime" value="{$session_lifetime}" class="form-control {if $err.session_lifetime}error{/if}">
											</div>
											<div class="clearfix"></div>
										</div>

									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="submit_sessions" value="Save" class="btn btn-success btn-cons">
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
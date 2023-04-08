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
						<h4>Bandwidth <span class="semi-bold">Management</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="bandwidth_settings" method="POST" action="index.php?m=bandwidth">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3 col-md-12">
									<div class="row">
										<div class="col-xs-12 m-b-5">
											<h3>Guest <span class="semi-bold">Restrictions</span></h3>
										</div>									
										<div class="form-group">
											<label class="col-lg-4 control-label">Guest Limit</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="guest_limit_y" type="radio" name="guest_limit" value="1" {if $guest_limit == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="guest_limit_y">Yes</label>
													<input id="guest_limit_n" type="radio" name="guest_limit" value="0" {if $guest_limit == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="guest_limit_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Guest Bandwidth</label>
											<div class="col-lg-8">
												<input name="guest_bandwidth" type="text" value="{$guest_bandwidth}" class="form-control {if $err.guest_bandwidth}error{/if}">
												<span class="help">MB</span>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="submit_bandwidth" value="Save" class="btn btn-success btn-cons">
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
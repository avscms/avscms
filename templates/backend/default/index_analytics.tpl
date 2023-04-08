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
						<h4>Google <span class="semi-bold">Analytics</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="google_analytics" method="POST" action="index.php?m=analytics">
							<div class="row">
								<div class="col-lg-8 col-lg-offset-2 col-md-12">
									<div class="row">
										<div class="col-xs-12 m-b-5">
											<h3>Google <span class="semi-bold">Analytics</span></h3>
										</div>									
										<div class="form-group">
											<label class="col-lg-4 control-label">Google Analytics Code</label>
											<div class="col-lg-8">
												<textarea name="analytics_code" rows="10" class="form-control {if $err.analytics_code}error{/if}" style="resize: vertical">{$code}</textarea>												
											</div>
											<div class="clearfix"></div>
										</div>									
									</div>									
								</div>
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="submit_analytics" value="Save" class="btn btn-success btn-cons">
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
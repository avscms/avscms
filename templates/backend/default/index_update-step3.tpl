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
					<h4>Update - <span class="semi-bold">Step 3</span></h4>
				</div>
				<div class="grid-body no-border">
					<form class="form-no-horizontal-spacing" name="update_form" method="POST" action="index.php?m=update">
						<div class="row">
							<div class="col-lg-8 col-lg-offset-2 col-md-12">					
								<div class="col-xs-12 m-b-5">
									<h4>Updating from version: {$from_to_version}</h4>
									<h4>Importing SQL files:</h4>
									<textarea id="step3_updating_text" name="step3_updating_text" rows="6" cols="85" readonly></textarea><br>
								</div>																	
							</div>				
						</div>
						<input type="hidden" name="update_page" class="update_page" value="step3" >
						<input type="hidden" name="from_to_version" class="from_to_version" value="{$from_to_version}" >
						<input type="hidden" name="file_version" class="file_version" value="{$file_version}" >								
						<div class="form-actions">
							<div class="pull-right">
								<a href="index.php?m=update&updateStatus=sucess" class="btn btn-success btn-cons nextBtnStep4">Next</a>
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
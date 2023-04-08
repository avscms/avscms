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
						<h4>Update - <span class="semi-bold">Step 1</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="update_form" method="POST" enctype="multipart/form-data" action="index.php?m=update-step2">
							<div class="row">
								<div class="col-lg-8 col-lg-offset-2 col-md-12">					
									<div class="col-xs-12 m-b-5">
										<h4>Disclaimer:</h4>
<textarea id="disclaimer_text" name="disclaimer_text" rows="6" cols="85" readonly>
1) Please BACKUP your files and database before proceeding for updating the script. 
2) We are not responsible any files missing or database corrupted in result of using this update scripts. 
3) Upon updating you might as well to lost your custom modification to your website.
4) Only proceed if you agreed to take your own responsibility.
</textarea><br>
<div>
    <label>
    <input type="checkbox" name="agreed" id="agreed" value="Y">&nbsp;I Agreed</label>
</div>

									</div>																	
								</div>				
							</div>
							<input type="hidden" name="update_page" class="update_page" value="step1" >
							<input type="hidden" name="from_to_version" class="from_to_version" value="{$from_to_version}" >
							<input type="hidden" name="file_version" class="file_version" value="{$file_version}" >							
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="update-step2" value="Next" class="btn btn-success btn-cons nextBtnStep2">
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
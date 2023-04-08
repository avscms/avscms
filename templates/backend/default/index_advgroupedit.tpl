	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">  
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Settings - <span class="semi-bold">Advertising</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>Editing Group: <span class="semi-bold">{$adv_group[0].advgrp_name}</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="edit_adv_group" method="POST" action="index.php?m=advgroupedit&AGID={$adv_group[0].advgrp_id}">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3 col-md-12">
									<div class="row">
										<div class="col-xs-12 m-b-5">
											<h3>Group <span class="semi-bold">Details</span></h3>
										</div>									
										<div class="form-group">
											<label class="col-lg-4 control-label">Width</label>
											<div class="col-lg-8">
												<input type="text" name="adv_width" value="{$adv_group[0].adv_width}" class="form-control {if $err.adv_width}error{/if}">
												<span class="help">Pixels</span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Height</label>
											<div class="col-lg-8">
												<input type="text" name="adv_height" value="{$adv_group[0].adv_height}" class="form-control {if $err.adv_height}error{/if}">
												<span class="help">Pixels</span>
											</div>
											<div class="clearfix"></div>
										</div>										
										<div class="form-group">
											<label class="col-lg-4 control-label">Rotating</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="adv_rotate_y" type="radio" name="adv_rotate" value="1" {if $adv_group[0].advgrp_rotate == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="adv_rotate_y">Yes</label>
													<input id="adv_rotate_n" type="radio" name="adv_rotate" value="0" {if $adv_group[0].advgrp_rotate == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="adv_rotate_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Status</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="adv_status_a" type="radio" name="adv_status" value="1" {if $adv_group[0].advgrp_status == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="adv_status_a">Active</label>
													<input id="adv_status_i" type="radio" name="adv_status" value="0" {if $adv_group[0].advgrp_status == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="adv_status_i">Inactive</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>							
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="edit_adv_group" value="Save" class="btn btn-success btn-cons">
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
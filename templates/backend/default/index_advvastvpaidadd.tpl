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
						<h4>Add <span class="semi-bold">In-Player Vast-Vpaid Ad</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="add_adv" method="POST" enctype="multipart/form-data" action="index.php?m=advvastvpaidadd">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3 col-md-12">					
									<div class="col-xs-12 m-b-5">
										<h3>Ad <span class="semi-bold">Details</span></h3>
									</div>									
									<div class="form-group">
										<label class="col-lg-4 control-label">Name</label>
										<div class="col-lg-8">
											<input name="adv_name" type="text" value="{$adv.name}" class="form-control {if $err.name}error{/if}">
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="form-group">
										<label class="col-lg-4 control-label">Ad Tag Url</label>
										<div class="col-lg-8">
											<input name="adv_adtagurl" type="text" value="{$adv.adtagurl}" class="form-control {if $err.adtagurl}error{/if}">
										</div>	
										<div class="clearfix"></div>
									</div>	
									<div class="form-group">
										<label class="col-lg-4 control-label">Ads Cancel Timeout</label>
										<div class="col-lg-8">
											<input name="adv_adscanceltimeout" type="number" value="{$adv.adscanceltimeout}" class="form-control {if $err.adscanceltimeout}error{/if}">
											<span class="help">ms</span>
										</div>	
										<div class="clearfix"></div>
									</div>
									<div class="form-group">
										<label class="col-lg-4 control-label">Status</label>
										<div class="col-lg-8">
											<div class="radio p-t-9">
												<input id="adv_status_a" type="radio" name="adv_status" value="1" {if $adv.status == '1'}checked="checked"{/if} class="radio-enabled">
												<label for="adv_status_a">Active</label>
												<input id="adv_status_i" type="radio" name="adv_status" value="0" {if $adv.status == '0'}checked="checked"{/if} class="radio-disabled">
												<label for="adv_status_i">Inactive</label>												
											</div>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="form-group">
										<label class="col-lg-4 control-label">Display On</label>
										<div class="col-lg-8">
											<select id="adv_device" name="adv_device" style="width:100%">
												<option value="dm"{if $adv.device == 'dm'} selected="selected"{/if}>Desktop + Mobile</option>
												<option value="d"{if $adv.device == 'd'} selected="selected"{/if}>Desktop</option>
												<option value="m"{if $adv.device == 'm'} selected="selected"{/if}>Mobile</option>												
											</select>
										</div>
										<div class="clearfix"></div>
									</div>
									
									<div class="form-group">
										<label class="col-lg-4 control-label">Show In Categories</label>	
										<div class="col-lg-8">
											<div class="checkbox check-default" style="margin-top: 9px;">	
												<input id="check_all_categories" type="checkbox">
												<label for="check_all_categories">Select / Deselect All</label>											
											</div>			
											<div style="max-height: 150px; overflow-y: auto;">
												{section name=i loop=$categories}
												<div class="checkbox check-default">														
													<input name="category_{$categories[i].CHID}" id="category_{$categories[i].CHID}" type="checkbox" value="1" {if $categories[i].checked == '1'}checked{/if}>
													<label for="category_{$categories[i].CHID}">{$categories[i].name}</label>														
												</div>														
												{/section}
											</div>
										</div>
										<div class="clearfix"></div>
									</div>
								
								</div>				
							</div>								
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="adv_add" value="Add" class="btn btn-success btn-cons">
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
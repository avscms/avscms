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
						<h4>Add <span class="semi-bold">Banner Ad</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="add_adv" method="POST" action="index.php?m=advadd">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3 col-md-12">
									<div class="row">
										{if $adv.text != ''}
										<div class="col-xs-12 m-b-5">
											<h3>Banner <span class="semi-bold">Preview</span></h3>
										</div>
										<div class="form-group">
											<div class="col-xs-12">
												{$adv.text}
											</div>
											<div class="clearfix"></div>
										</div>
										{/if}									
										<div class="col-xs-12 m-b-5">
											<h3>Banner <span class="semi-bold">Details</span></h3>
										</div>									
										<div class="form-group">
											<label class="col-lg-4 control-label">Name</label>
											<div class="col-lg-8">
												<input name="adv_name" type="text" value="{$adv.name}" class="form-control {if $err.adv_name}error{/if}">
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Group</label>
											<div class="col-lg-8">
												<select id="adv_group" name="adv_group" style="width:100%" {if $err.adv_group}class="select-error"{/if}>
												<option value="0"{if $adv.group == '0'} selected="selected"{/if}>Select Group</option>
												{section name=i loop=$advgroups}
													<option value="{$advgroups[i].advgrp_id}"{if $adv.group == $advgroups[i].advgrp_id} selected="selected"{/if}>{$advgroups[i].advgrp_name}</option>
												{/section}
												</select>
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
											<label class="col-lg-4 control-label">Code</label>
											<div class="col-lg-8">
												<textarea name="adv_text" rows="6" class="form-control {if $err.adv_text}error{/if}" style="resize: vertical">{$adv.text}</textarea>
											</div>	
											<div class="clearfix"></div>
										</div>									
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
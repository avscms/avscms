	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">  
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Settings - <span class="semi-bold">Video Conversion</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>Edit H264 Encoding<span class="semi-bold"> ID: {$encoding.id}</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="add_adv" method="POST" action="index.php?m=encodingedit&EID={$encoding.id}">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3 col-md-12">
									<div class="row">							
										<div class="col-xs-12 m-b-5">
											<h3>Encoding <span class="semi-bold">Details</span></h3>
										</div>									
										<div class="form-group">
											<label class="col-lg-4 control-label">Label</label>
											<div class="col-lg-8">
												<input name="label" type="text" value="{$encoding.label}" class="form-control {if $err.label}error{/if}">
												<span class="help">Label/Name E.g. <b>720p, HD, SD</b> (only letters and numbers are allowed [A-Za-z0-9])</span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Width</label>
											<div class="col-lg-8">
												<input name="width" type="number" min=100 max=7680 value="{$encoding.width}" class="form-control {if $err.width}error{/if}">
												<span class="help">Resolution Width E.g. <b>1280</b></span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Height</label>
											<div class="col-lg-8">
												<input name="height" type="number" min=100 max=4320 value="{$encoding.height}" class="form-control {if $err.height}error{/if}">
												<span class="help">Resolution Height E.g. <b>720</b></span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Constant Rate Factor (CRF)</label>
											<div class="col-lg-8">
												<input name="crf" type="number" min=0 max=51 value="{$encoding.crf}" class="form-control {if $err.crf}error{/if}">
												<span class="help">Range: 0-51: where 0 is lossless, 23 is default, and 51 is worst possible.</span>
											</div>
											<div class="clearfix"></div>
										</div>											
										<div class="form-group">
											<label class="col-lg-4 control-label">Preset</label>
											<div class="col-lg-8">
												<select id="preset" name="preset" style="width:100%" {if $err.preset}class="select-error"{/if}>
												{section name=i loop=$preset}
													<option value="{$preset[i]}"{if $encoding.preset == $preset[i]} selected="selected"{/if}>{$preset[i]|ucfirst}</option>
												{/section}
												</select>
												<span class="help">A slower preset will provide better compression (compression is quality per filesize).</span>												
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">IOS Compatibility</label>
											<div class="col-lg-8">
												<select id="ios" name="ios" style="width:100%" {if $err.ios}class="select-error"{/if}>
												{section name=i loop=$ios}
													<option value="{$ios[i].value}"{if $encoding.ios == $ios[i].value} selected="selected"{/if}>{$ios[i].spec}</option>
												{/section}
												</select>
												<span class="help">This disables some advanced features but provides for better compatibility. Typically you may not need this setting.</span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Format</label>
											<div class="col-lg-8">
												<input name="format" type="text" value="mp4" class="form-control" disabled>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="m-t-10"></div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Fast Start</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="faststart_e" type="radio" name="faststart" value="1" {if $encoding.faststart == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="faststart_e">Enabled</label>
													<input id="faststart_d" type="radio" name="faststart" value="0" {if $encoding.faststart == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="faststart_d">Disabled</label>												
												</div>
												<span class="help">This will move some information to the beginning of your file and allow the video to begin playing before it is completely downloaded by the viewer.</span>
											</div>
											<div class="clearfix"></div>
										</div>											
										<div class="form-group">
											<label class="col-lg-4 control-label">Copy Only</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="copyonly_e" type="radio" name="copyonly" value="1" {if $encoding.copyonly == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="copyonly_e">Enabled</label>
													<input id="copyonly_d" type="radio" name="copyonly" value="0" {if $encoding.copyonly == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="copyonly_d">Disabled</label>												
												</div>
												<span class="help">Skpi conversion if the file is already compatible with this format/resolution.</span>
											</div>
											<div class="clearfix"></div>
										</div>										
										<div class="form-group">
											<label class="col-lg-4 control-label">Status</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="status_a" type="radio" name="status" value="1" {if $encoding.status == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="status_a">Active</label>
													<input id="status_i" type="radio" name="status" value="0" {if $encoding.status == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="status_i">Inactive</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>							
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="encoding_save" value="Save" class="btn btn-success btn-cons">
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
	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">  
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Videos - <span class="semi-bold">Add Videos</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>Mass Embed <span class="semi-bold">Videos</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="embedVideo" method="POST" enctype="multipart/form-data" action="videos.php?m=membed{if $debug}&debug={$debug}{/if}">
							<div class="row">					
								{if $warnings}
									<div class="col-xs-12">
										<div class="alert alert-info">
											<button class="close" data-dismiss="alert"></button>
											No classes loaded!
										</div>
									</div>
								{else}
									<div class="col-lg-6 col-lg-offset-3 col-md-12">
										<div class="row">								
											<div class="form-group">											
												{foreach from=$sites key=domain item=website}
													<div class="col-md-4 grabber-label">{$domain}</div>
												{/foreach}
												<div class="clearfix"></div>
											</div>
											<div class="col-xs-12 m-b-5">
												<h3>Page / Video <span class="semi-bold">Details</span></h3>
											</div>											
											<div class="form-group">
												<label class="col-lg-4 control-label">Page URL</label>
												<div class="col-lg-8">
													<input class="form-control" name="url" type="text" value="{$embed.url}">
												</div>
												<div class="clearfix"></div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 control-label">Username</label>
												<div class="col-lg-8">
													<input class="form-control" name="username" type="text" value="{$embed.username}">
												</div>
												<div class="clearfix"></div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 control-label">Category</label>
												<div class="col-lg-8">
													<select id="category" name="category" style="width:100%">
														{section name=i loop=$categories}
														<option value="{$categories[i].CHID}"{if $embed.category == $categories[i].CHID} selected="selected"{/if}>{$categories[i].name|escape:'html'}</option>
														{/section}
													</select>
												</div>
												<div class="clearfix"></div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 control-label">Status</label>
												<div class="col-lg-8">
													<div class="radio p-t-9">
														<input id="status_a" type="radio" name="status" value="1" {if $embed.status == '1'}checked="checked"{/if} class="radio-enabled">
														<label for="status_a">Active</label>
														<input id="status_s" type="radio" name="status" value="0" {if $embed.status == '0'}checked="checked"{/if} class="radio-disabled">
														<label for="status_s">Suspended</label>												
													</div>
												</div>
												<div class="clearfix"></div>
											</div>
										</div>
									</div>
								{/if}
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input name="membed_videos" type="submit" value="Embed Videos" id="save_video_button" class="btn btn-success btn-cons" onClick="document.getElementById('save_video_button').value='Embedding...'";>
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
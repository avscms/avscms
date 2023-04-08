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
						<h4>Embed <span class="semi-bold">Video</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="embedVideo" method="POST" enctype="multipart/form-data" action="videos.php?m=embed">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3 col-md-12">
									<div class="row">		
										<div class="form-group">
											<label class="col-lg-4 control-label">Username</label>
											<div class="col-lg-8">
												<input class="form-control" name="username" type="text" value="{$video.username}">
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Title</label>
											<div class="col-lg-8">
												<input class="form-control" name="title" type="text" value="{$video.title|escape:'html'}">
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Description</label>
											<div class="col-lg-8">
												 <textarea class="form-control" name="description" rows="3" style="resize: vertical">{$video.description|escape:'html'}</textarea>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Category</label>
											<div class="col-lg-8">
												<select id="category" name="category" style="width:100%">
													{section name=i loop=$categories}
													<option value="{$categories[i].CHID}"{if $video.category == $categories[i].CHID} selected="selected"{/if}>{$categories[i].name|escape:'html'}</option>
													{/section}
												</select>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Tags</label>
											<div class="col-lg-8">
												 <textarea class="form-control" name="tags" rows="3" style="resize: vertical">{$video.tags|escape:'html'}</textarea>
												 <span class="help">Comma separated</span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Type</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="type_pb" type="radio" name="type" value="public" {if $video.type != 'private'}checked="checked"{/if} class="radio-enabled">
													<label for="type_pb">Public</label>
													<input id="type_pv" type="radio" name="type" value="private" {if $video.type == 'private'}checked="checked"{/if} class="radio-disabled">
													<label for="type_pv">Private</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Duration</label>
											<div class="col-lg-8">
												<input class="form-control" name="duration" type="text" value="{$video.duration}">
												<span class="help">Minutes:seconds (eg: 17:24)</span>
											</div>
											<div class="clearfix"></div>
										</div>										
										<div class="form-group">
											<label class="col-lg-4 control-label">Embed Code</label>
											<div class="col-lg-8">
												 <textarea class="form-control" name="embed_code" rows="6" style="resize: vertical">{$video.embed_code}</textarea>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Thumbnails</label>
											<div class="col-lg-8">
												<div id="get_file" class="btn btn btn-success btn-file" onclick="getFile('thumb')">Choose File(s)</div>
												<div class="file-box">
													<span id="upthumb">No file chosen</span>
													<input name="thumb[]" type="file" id="thumb" onChange="sub(this,'upthumb','nofile')" multiple accept=".gif,.jpg,.jpeg,.png" />		
													<input type="hidden" id="nofile" value="No File">
												</div>
											</div>
											<div class="clearfix"></div>
										</div>																			
									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input name="embed_video" type="submit" value="Embed Video" id="save_video_button" class="btn btn-success btn-cons" onClick="document.getElementById('save_video_button').value='Embedding...'">
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
	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">  
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Albums - <span class="semi-bold">Add Album</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>Album <span class="semi-bold">{if !$added_photos}Information{else}Photos{/if}</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="add_album" method="POST" enctype="multipart/form-data" action="albums.php?m=add">					
						{if !$added_photos}					
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3 col-md-12">
									<div class="row">		
										<div class="form-group">
											<label class="col-lg-4 control-label">Username</label>
											<div class="col-lg-8">
												<input class="form-control {if $err.username}error{/if}" name="username" type="text" value="{$album.username}">
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Name</label>
											<div class="col-lg-8">
												<input class="form-control {if $err.name}error{/if}" name="name" type="text" value="{$album.name}">
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Category</label>
											<div class="col-lg-8">
												<select id="category" name="category" style="width:100%">
													{section name=i loop=$categories}
													<option value="{$categories[i].CID}"{if $album.category == $categories[i].CID} selected="selected"{/if}>{$categories[i].name|escape:'html'}</option>
													{/section}
												</select>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Tags</label>
											<div class="col-lg-8">
												 <textarea class="form-control {if $err.tags}error{/if}" name="tags" rows="3" style="resize: vertical">{$album.tags}</textarea>
												 <span class="help">Comma separated</span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Type</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="type_pb" type="radio" name="type" value="public" {if $album.type != 'private'}checked="checked"{/if} class="radio-enabled">
													<label for="type_pb">Public</label>
													<input id="type_pv" type="radio" name="type" value="private" {if $album.type == 'private'}checked="checked"{/if} class="radio-disabled">
													<label for="type_pv">Private</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Photos</label>
											<div class="col-lg-8">
												<div id="get_file" class="btn btn btn-success btn-file" onclick="getFile('photos')">Choose File(s)</div>
												<div class="file-box">
													<span id="addphotos">No file chosen</span>
													<input name="photos[]" type="file" id="photos" onChange="sub(this,'addphotos','nofile')" multiple accept=".gif,.jpg,.jpeg,.png" />		
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
									<input name="add_album" type="submit" value="Add Album" id="add_album" class="btn btn-success btn-cons" onClick="document.getElementById('add_album').value='Uploading...'">
									<a href="index.php" class="btn btn-white btn-cons">Cancel</a>
								</div>
							</div>

						{else}
							<div class="row">						
								{section name=i loop=$added_photos}
										<div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
											<img src="{$baseurl}/media/photos/tmb/{$added_photos[i]}.jpg" class="img-responsive">
											<div class="form-group m-t-10">
												<input class="form-control" name="caption[{$added_photos[i]}]" type="text" value="" placeholder="Caption">
											</div>									
										</div>								
								{/section}
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input name="update_captions" type="submit" value="Update Captions" class="btn btn-success btn-cons">
									<a href="albums.php?m=add" class="btn btn-white btn-cons">Skip</a>
								</div>
							</div>							
						{/if}
						</form>
					</div>
				</div>
			</div>			
			<!-- END PLACE PAGE CONTENT HERE -->
		</div>
	</div>
	<!-- END PAGE CONTAINER -->	
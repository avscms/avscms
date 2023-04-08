	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">  
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Videos - <span class="semi-bold">Manage Videos</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>Editing Video: <span class="semi-bold">{$video[0].VID}</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="edit_video" method="POST" action="videos.php?m=edit&VID={$video[0].VID}">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3 col-md-12">
									<div class="row">
										<div class="col-xs-12 m-b-5">
											<h3>Video <span class="semi-bold">Information</span></h3>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Video ID</label>
											<div class="col-lg-8">
												<input type="text" name="VID" value="{$video[0].VID}" readonly="readonly" class="form-control">
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">User ID</label>
											<div class="col-lg-8">
												<input type="text" name="username" value="{$video[0].UID}" readonly="readonly" class="form-control">
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Title</label>
											<div class="col-lg-8">
												<input type="text" name="title" value="{$video[0].title}" class="form-control {if $err.title}error{/if}">
											</div>
											<div class="clearfix"></div>
										</div>									
										<div class="form-group">
											<label class="col-lg-4 control-label">Tags</label>
											<div class="col-lg-8">
												<textarea name="keyword" rows="2" class="form-control {if $err.keyword}error{/if}" style="resize: vertical">{$video[0].keyword}</textarea>
											</div>
											<div class="clearfix"></div>
										</div>						
										<div class="form-group">
											<label class="col-lg-4 control-label">Category</label>
											<div class="col-lg-8">
												<select id="channel" name="channel" style="width:100%">
													{section name=i loop=$channels}
													<option value="{$channels[i].CHID}"{if $video[0].channel == $channels[i].CHID} selected="selected"{/if}>{$channels[i].name|escape:'html'}</option>
													{/section}
												</select>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Type</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="type_public" type="radio" name="type" value="public"{if $video[0].type == 'public'} checked{/if} class="radio-enabled">
													<label for="type_public">Public</label>
													<input id="type_private" type="radio" name="type" value="private"{if $video[0].type == 'private'}checked="checked"{/if} class="radio-disabled">
													<label for="type_private">Private</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Status</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="active_a" type="radio" name="active" value="1"{if $video[0].active == '1'} checked{/if} class="radio-enabled">
													<label for="active_a">Active</label>
													<input id="active_i" type="radio" name="active" value="0"{if $video[0].active == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="active_i">Inactive</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>										
										<div class="form-group">
											<label class="col-lg-4 control-label">Featured</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="featured_y" type="radio" name="featured" value="yes"{if $video[0].featured == 'yes'} checked{/if} class="radio-enabled">
													<label for="featured_y">Yes</label>
													<input id="featured_n" type="radio" name="featured" value="no"{if $video[0].featured == 'no'}checked="checked"{/if} class="radio-disabled">
													<label for="featured_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Can be commented?</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="be_comment_y" type="radio" name="be_comment" value="yes"{if $video[0].be_comment == 'yes'} checked{/if} class="radio-enabled">
													<label for="be_comment_y">Yes</label>
													<input id="be_comment_n" type="radio" name="be_comment" value="no"{if $video[0].be_comment == 'no'}checked="checked"{/if} class="radio-disabled">
													<label for="be_comment_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Can be rated?</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="be_rated_y" type="radio" name="be_rated" value="yes"{if $video[0].be_rated == 'yes'} checked{/if} class="radio-enabled">
													<label for="be_rated_y">Yes</label>
													<input id="be_rated_n" type="radio" name="be_rated" value="no"{if $video[0].be_rated == 'no'}checked="checked"{/if} class="radio-disabled">
													<label for="be_rated_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Can be embeded?</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="embed_y" type="radio" name="embed" value="enabled"{if $video[0].embed == 'enabled'} checked{/if} class="radio-enabled">
													<label for="embed_y">Yes</label>
													<input id="embed_n" type="radio" name="embed" value="disabled"{if $video[0].embed == 'disabled'}checked="checked"{/if} class="radio-disabled">
													<label for="embed_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="col-xs-12 m-b-5">
											<h3>Advanced <span class="semi-bold">Configuration</span></h3>
										</div>
										{if $multi_server == '1'}										
											<div class="form-group">
												<label class="col-lg-4 control-label">Server</label>
												<div class="col-lg-8">
													<input name="server" type="text" value="{$video[0].server}" class="form-control {if $err.server}error{/if}">
												</div>
												<div class="clearfix"></div>
											</div>
										{/if}
										<div class="form-group">
											<label class="col-lg-4 control-label">Like Rate</label>
											<div class="col-lg-8">
												<input name="rate" type="text" value="{if $video[0].rate == 0 && $video[0].dislikes == 0}-{else}{$video[0].rate}%{/if}" readonly="readonly" class="form-control">
											</div>
											<div class="clearfix"></div>
										</div>										
										<div class="form-group">
											<label class="col-lg-4 control-label">Likes</label>
											<div class="col-lg-8">
												<input name="likes" type="text" value="{$video[0].likes}" class="form-control {if $err.likes}error{/if}">
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Dislikes</label>
											<div class="col-lg-8">
												<input name="dislikes" type="text" value="{$video[0].dislikes}" class="form-control {if $err.dislikes}error{/if}">
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Views</label>
											<div class="col-lg-8">
												<input type="text" name="viewnumber" value="{$video[0].viewnumber}" class="form-control {if $err.viewnumber}error{/if}">
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="col-xs-12 m-b-5">
											<h3>Video <span class="semi-bold">Thumb</span></h3>
											<input type="hidden" name="thumb" id="{$video[0].vkey}" value="{$video[0].thumb}">
											<div class="row m-b--10">
												{insert name=video_thumbs assign=thumbs VID=$video[0].VID vkey=$video[0].vkey thumb=$video[0].thumb}
												{$thumbs}
											</div>
										</div>										
									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="edit_video" value="Save" class="btn btn-success btn-cons">
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
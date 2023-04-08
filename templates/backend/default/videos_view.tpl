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
						<h4>View <span class="semi-bold">Video</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="view-video" method="POST" action="#">
						<div class="row video-info">
							<div class="col-xs-12 col-md-6 m-b-5">
								<h3>Video <span class="semi-bold">Information</span></h3>
								<div class="row">
									<div class="col-xs-6 m-b-5">Video ID</div>
									<div class="col-xs-6 m-b-5 semi-bold">{$video[0].VID}</div>								
								</div>
								<div class="row">
									<div class="col-xs-12">
										<div class="row-separation"></div>
									</div>	
									<div class="col-xs-6 m-b-5">Status</div>
									<div class="col-xs-6 m-b-5 semi-bold">{if $video[0].active == 1}<span class="text-success">Active</span>{else}<span class="text-danger">Inactive</span>{/if}</div>
								</div>
								<div class="row">
									<div class="col-xs-12">
										<div class="row-separation"></div>
									</div>	
									<div class="col-xs-6 m-b-5">Title</div>
									<div class="col-xs-6 m-b-5 semi-bold">{$video[0].title|escape:'html'}</div>								
								</div>
								<!--
								<div class="row">
									<div class="col-xs-12">
										<div class="row-separation"></div>
									</div>	
									<div class="col-xs-6 m-b-5">Description</div>
									<div class="col-xs-6 m-b-5 semi-bold">{$video[0].description}</div>								
								</div>								
								-->
								<div class="row">
									<div class="col-xs-12">
										<div class="row-separation"></div>
									</div>	
									<div class="col-xs-6 m-b-5">Tags</div>
									<div class="col-xs-6 m-b-5 semi-bold">{$video[0].keyword}</div>								
								</div>
								<div class="row">
									<div class="col-xs-12">
										<div class="row-separation"></div>
									</div>	
									<div class="col-xs-6 m-b-5">Category</div>
									<div class="col-xs-6 m-b-5 semi-bold">{$video[0].channel_name}</div>								
								</div>
								<div class="row">
									<div class="col-xs-12">
										<div class="row-separation"></div>
									</div>	
									<div class="col-xs-6 m-b-5">Duration</div>
									{insert name=duration assign=duration duration=$video[0].duration}																
									<div class="col-xs-6 m-b-5 semi-bold">{$duration}</div>								
								</div>
								<div class="row">
									<div class="col-xs-12">
										<div class="row-separation"></div>
									</div>	
									<div class="col-xs-6 m-b-5">Type</div>
									<div class="col-xs-6 m-b-5 semi-bold">{if $video[0].type == 'public'}<span class="text-primary">Public</span>{else}<span class="text-danger">Private</span>{/if}</div>								
								</div>
								<div class="row">
									<div class="col-xs-12">
										<div class="row-separation"></div>
									</div>	
									<div class="col-xs-6 m-b-5">Date Added</div>
									<div class="col-xs-6 m-b-5 semi-bold">{$video[0].adddate|date_format}</div>								
								</div>
								<div class="row">
									<div class="col-xs-12">
										<div class="row-separation"></div>
									</div>	
									<div class="col-xs-6 m-b-5">Like Rate</div>
									<div class="col-xs-6 m-b-5 semi-bold">{if $video[0].rate == 0 && $video[0].dislikes == 0}-{else}{$video[0].rate}%{/if}</div>
								</div>
								<div class="row">
									<div class="col-xs-12">
										<div class="row-separation"></div>
									</div>	
									<div class="col-xs-6 m-b-5">Likes</div>
									<div class="col-xs-6 m-b-5 semi-bold">{$video[0].likes}</div>
								</div>
								<div class="row">
									<div class="col-xs-12">
										<div class="row-separation"></div>
									</div>	
									<div class="col-xs-6 m-b-5">Dislikes</div>
									<div class="col-xs-6 m-b-5 semi-bold">{$video[0].dislikes}</div>
								</div>
								<div class="row">
									<div class="col-xs-12">
										<div class="row-separation"></div>
									</div>	
									<div class="col-xs-6 m-b-5">Can be commented?</div>
									<div class="col-xs-6 m-b-5 semi-bold">{if $video[0].be_comment == 'yes'}<span class="text-success">Yes</span>{else}<span class="text-danger">No</span>{/if}</div>
								</div>
								<div class="row">
									<div class="col-xs-12">
										<div class="row-separation"></div>
									</div>	
									<div class="col-xs-6 m-b-5">Can be rated?</div>
									<div class="col-xs-6 m-b-5 semi-bold">{if $video[0].be_rated == 'yes'}<span class="text-success">Yes</span>{else}<span class="text-danger">No</span>{/if}</div>
								</div>
								<div class="row">
									<div class="col-xs-12">
										<div class="row-separation"></div>
									</div>	
									<div class="col-xs-6 m-b-5">Can be embeded?</div>
									<div class="col-xs-6 m-b-5 semi-bold">{if $video[0].embed == 'enabled'}<span class="text-success">Yes</span>{else}<span class="text-danger">No</span>{/if}</div>
								</div>
								<div class="row">
									<div class="col-xs-12">
										<div class="row-separation"></div>
									</div>	
									<div class="col-xs-6 m-b-5">Views</div>
									<div class="col-xs-6 m-b-5 semi-bold">{$video[0].viewnumber}</div>
								</div>
								<div class="row">
									<div class="col-xs-12">
										<div class="row-separation"></div>
									</div>	
									<div class="col-xs-6 m-b-5">Comments</div>
									<div class="col-xs-6 m-b-5 semi-bold">{$video[0].com_num}</div>
								</div>
								<div class="row">
									<div class="col-xs-12">
										<div class="row-separation"></div>
									</div>	
									<div class="col-xs-6 m-b-5">Favorites</div>
									<div class="col-xs-6 m-b-5 semi-bold">{$video[0].fav_num}</div>
								</div>
								<div class="row">
									<div class="col-xs-12">
										<div class="row-separation"></div>
									</div>	
									<div class="col-xs-6 m-b-5">Type</div>
									<div class="col-xs-6 m-b-5 semi-bold">{if $video[0].embed_code != ''}Embeded{else}Uploaded{/if}</div>
								</div>
								{if $video[0].embed_code == ''}
									<div class="row">
										<div class="col-xs-12">
											<div class="row-separation"></div>
										</div>	
										<div class="col-xs-6 m-b-5">Original Video</div>
										<div class="col-xs-6 m-b-5 semi-bold">{$video[0].vdoname}</div>
									</div>								
									{if $video[0].flv == 1}
										<div class="row">
											<div class="col-xs-12">
												<div class="row-separation"></div>
											</div>	
											<div class="col-xs-6 m-b-5">SD</div>
											<div class="col-xs-6 m-b-5 semi-bold">{$video[0].flvdoname}</div>
										</div>
									{/if}
									{if $video[0].iphone == 1}
										<div class="row">
											<div class="col-xs-12">
												<div class="row-separation"></div>
											</div>	
											<div class="col-xs-6 m-b-5">SD / MOBILE</div>
											<div class="col-xs-6 m-b-5 semi-bold">{$video[0].ipod_filename}</div>
										</div>	
									{/if}
									{if $video[0].hd == 1}
										<div class="row">
											<div class="col-xs-12">
												<div class="row-separation"></div>
											</div>	
											<div class="col-xs-6 m-b-5">HD</div>
											<div class="col-xs-6 m-b-5 semi-bold">{$video[0].hd_filename}</div>
										</div>								
									{/if}
								{/if}
								{if $multi_server == '1'}
									<div class="row">
										<div class="col-xs-12">
											<div class="row-separation"></div>
										</div>	
										<div class="col-xs-6 m-b-5">Server</div>
										<div class="col-xs-6 m-b-5 semi-bold">{$video[0].server}</div>
									</div>
								{/if}								
							</div>
							<div class="col-xs-12 col-md-6">
								<h3>View <span class="semi-bold">Video</span></h3>
								<div class="row">
									<div class="col-lg-8 col-lg-offset-2">
										{include file='video_vplayer.tpl'}
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="row m-t-10 {if $video[0].embed_code != ''}m-b--10{/if}">
									{insert name=vvideo_thumbs assign=thumbs VID=$video[0].VID}
									{$thumbs}
								</div>
								{if $video[0].embed_code == ''}
									<div class="row">
										<div class="col-sm-4 col-sm-offset-4">
											<img src="{insert name=tmb_path vid=$video[0].VID}/default.jpg" class="img-responsive"><br>
										</div>
									</div>
								{/if}
							</div>									
						</div>
						<div class="form-actions">
							<div class="pull-right">
								<a href="videos.php?m=all&a=delete&VID={$video[0].VID}" class="btn btn-danger btn-cons" onClick="javascript:return confirm('Are you sure you want to delete this video?');">Delete</a>							
								<a href="videos.php?m=edit&VID={$video[0].VID}" class="btn btn-white btn-cons">Edit</a>								
								{if $approve == '1'}
									{if $video[0].active == '0'}
										<a href="videos.php?m=view&a=approve&VID={$video[0].VID}" onClick="javascript:return confirm('Are you sure you want to approve this video?');" class="btn btn-white btn-cons">Approve</a>
									{else}
										<a href="videos.php?m=view&a=suspend&VID={$video[0].VID}" onClick="javascript:return confirm('Are you sure you want to suspend this video?');" class="btn btn-white btn-cons">Suspend</a>
									{/if}
								{/if}
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
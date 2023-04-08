	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">  
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Settings - <span class="semi-bold">Security</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>User <span class="semi-bold">Permissions</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="user_permisions" method="POST" action="index.php?m=userpermisions">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3 col-md-12">
									<div class="row">
										<div class="col-xs-12 m-b-5">
											<h3>Visitors / <span class="semi-bold">Guests</span></h3>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Watch SD Videos</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="visitors_watch_normal_videos_y" type="radio" name="visitors_watch_normal_videos" value="1" {if $visitors_watch_normal_videos == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="visitors_watch_normal_videos_y">Yes</label>
													<input id="visitors_watch_normal_videos_n" type="radio" name="visitors_watch_normal_videos" value="0" {if $visitors_watch_normal_videos == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="visitors_watch_normal_videos_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Watch HD Videos</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="visitors_watch_hd_videos_y" type="radio" name="visitors_watch_hd_videos" value="1" {if $visitors_watch_hd_videos == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="visitors_watch_hd_videos_y">Yes</label>
													<input id="visitors_watch_hd_videos_n" type="radio" name="visitors_watch_hd_videos" value="0" {if $visitors_watch_hd_videos == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="visitors_watch_hd_videos_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">SD Downloads</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="visitors_sd_downloads_y" type="radio" name="visitors_sd_downloads" value="1" {if $visitors_sd_downloads == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="visitors_sd_downloads_y">Yes</label>
													<input id="visitors_sd_downloads_n" type="radio" name="visitors_sd_downloads" value="0" {if $visitors_sd_downloads == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="visitors_sd_downloads_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">HD Downloads</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="visitors_hd_downloads_y" type="radio" name="visitors_hd_downloads" value="1" {if $visitors_hd_downloads == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="visitors_hd_downloads_y">Yes</label>
													<input id="visitors_hd_downloads_n" type="radio" name="visitors_hd_downloads" value="0" {if $visitors_hd_downloads == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="visitors_hd_downloads_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Mobile Downloads</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="visitors_mobile_downloads_y" type="radio" name="visitors_mobile_downloads" value="1" {if $visitors_mobile_downloads == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="visitors_mobile_downloads_y">Yes</label>
													<input id="visitors_mobile_downloads_n" type="radio" name="visitors_mobile_downloads" value="0" {if $visitors_mobile_downloads == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="visitors_mobile_downloads_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">In-Player Ads</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="visitors_in_player_ads_y" type="radio" name="visitors_in_player_ads" value="1" {if $visitors_in_player_ads == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="visitors_in_player_ads_y">Show</label>
													<input id="visitors_in_player_ads_n" type="radio" name="visitors_in_player_ads" value="0" {if $visitors_in_player_ads == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="visitors_in_player_ads_n">Don't Show</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Bandwidth Limit</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="visitors_bandwidth_select_e" type="radio" name="visitors_bandwidth_select" value="1" {if $visitors_bandwidth != '-1'}checked="checked"{/if} class="radio-enabled" onclick="gbandwidth(this.id)">
													<label for="visitors_bandwidth_select_e">Enabled</label>
													<input id="visitors_bandwidth_select_d" type="radio" name="visitors_bandwidth_select" value="-1" {if $visitors_bandwidth == '-1'}checked="checked"{/if} class="radio-disabled" onclick="gbandwidth(this.id)">
													<label for="visitors_bandwidth_select_d">Disabled</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>					
										<div id="gbandw" class="form-group" style="display: {if $visitors_bandwidth == '-1'} none; {else} block; {/if}">
											<label class="col-lg-4 control-label">Bandwidth Limit</label>
											<div class="col-lg-8">
												<input type="hidden" id="gselbandw" style="display: none" value="{$visitors_bandwidth}">
												<input id='gbandwi' type="text" name="visitors_bandwidth" value="{$visitors_bandwidth}" class="form-control {if $err.visitors_bandwidth}error{/if}">
												<span class="help">MB</span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="col-xs-12 m-b-5">
											<h3>Free <span class="semi-bold">Users (Registered)</span></h3>
										</div>										
										<div class="form-group">
											<label class="col-lg-4 control-label">Watch SD Videos</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="free_watch_normal_videos_y" type="radio" name="free_watch_normal_videos" value="1" {if $free_watch_normal_videos == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="free_watch_normal_videos_y">Yes</label>
													<input id="free_watch_normal_videos_n" type="radio" name="free_watch_normal_videos" value="0" {if $free_watch_normal_videos == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="free_watch_normal_videos_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Watch HD Videos</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="free_watch_hd_videos_y" type="radio" name="free_watch_hd_videos" value="1" {if $free_watch_hd_videos == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="free_watch_hd_videos_y">Yes</label>
													<input id="free_watch_hd_videos_n" type="radio" name="free_watch_hd_videos" value="0" {if $free_watch_hd_videos == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="free_watch_hd_videos_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">SD Downloads</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="free_sd_downloads_y" type="radio" name="free_sd_downloads" value="1" {if $free_sd_downloads == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="free_sd_downloads_y">Yes</label>
													<input id="free_sd_downloads_n" type="radio" name="free_sd_downloads" value="0" {if $free_sd_downloads == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="free_sd_downloads_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">HD Downloads</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="free_hd_downloads_y" type="radio" name="free_hd_downloads" value="1" {if $free_hd_downloads == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="free_hd_downloads_y">Yes</label>
													<input id="free_hd_downloads_n" type="radio" name="free_hd_downloads" value="0" {if $free_hd_downloads == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="free_hd_downloads_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Mobile Downloads</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="free_mobile_downloads_y" type="radio" name="free_mobile_downloads" value="1" {if $free_mobile_downloads == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="free_mobile_downloads_y">Yes</label>
													<input id="free_mobile_downloads_n" type="radio" name="free_mobile_downloads" value="0" {if $free_mobile_downloads == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="free_mobile_downloads_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Upload Videos / Photos</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="free_upload_video_y" type="radio" name="free_upload_video" value="1" {if $free_upload_video == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="free_upload_video_y">Yes</label>
													<input id="free_upload_video_n" type="radio" name="free_upload_video" value="0" {if $free_upload_video == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="free_upload_video_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>										
										<div class="form-group">
											<label class="col-lg-4 control-label">Write Blogs</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="free_write_in_blog_y" type="radio" name="free_write_in_blog" value="1" {if $free_write_in_blog == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="free_write_in_blog_y">Yes</label>
													<input id="free_write_in_blog_n" type="radio" name="free_write_in_blog" value="0" {if $free_write_in_blog == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="free_write_in_blog_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>										
										<div class="form-group">
											<label class="col-lg-4 control-label">In-Player Ads</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="free_in_player_ads_y" type="radio" name="free_in_player_ads" value="1" {if $free_in_player_ads == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="free_in_player_ads_y">Show</label>
													<input id="free_in_player_ads_n" type="radio" name="free_in_player_ads" value="0" {if $free_in_player_ads == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="free_in_player_ads_n">Don't Show</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Bandwidth Limit</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="free_bandwidth_select_e" type="radio" name="free_bandwidth_select" value="1" {if $free_bandwidth != '-1'}checked="checked"{/if} class="radio-enabled" onclick="fbandwidth(this.id)">
													<label for="free_bandwidth_select_e">Enabled</label>
													<input id="free_bandwidth_select_d" type="radio" name="free_bandwidth_select" value="-1" {if $free_bandwidth == '-1'}checked="checked"{/if} class="radio-disabled" onclick="fbandwidth(this.id)">
													<label for="free_bandwidth_select_d">Disabled</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>					
										<div id="fbandw" class="form-group" style="display: {if $free_bandwidth == '-1'} none; {else} block; {/if}">
											<label class="col-lg-4 control-label">Bandwidth Limit</label>
											<div class="col-lg-8">
												<input type="hidden" id="fselbandw" style="display: none" value="{$free_bandwidth}">
												<input id='fbandwi' type="text" name="free_bandwidth" value="{$free_bandwidth}" class="form-control {if $err.free_bandwidth}error{/if}">
												<span class="help">MB</span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="col-xs-12 m-b-5">
											<h3>Premium <span class="semi-bold">Users</span></h3>
										</div>											
										<div class="form-group">
											<label class="col-lg-4 control-label">Watch SD Videos</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="premium_watch_normal_videos_y" type="radio" name="premium_watch_normal_videos" value="1" {if $premium_watch_normal_videos == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="premium_watch_normal_videos_y">Yes</label>
													<input id="premium_watch_normal_videos_n" type="radio" name="premium_watch_normal_videos" value="0" {if $premium_watch_normal_videos == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="premium_watch_normal_videos_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Watch HD Videos</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="premium_watch_hd_videos_y" type="radio" name="premium_watch_hd_videos" value="1" {if $premium_watch_hd_videos == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="premium_watch_hd_videos_y">Yes</label>
													<input id="premium_watch_hd_videos_n" type="radio" name="premium_watch_hd_videos" value="0" {if $premium_watch_hd_videos == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="premium_watch_hd_videos_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">SD Downloads</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="premium_sd_downloads_y" type="radio" name="premium_sd_downloads" value="1" {if $premium_sd_downloads == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="premium_sd_downloads_y">Yes</label>
													<input id="premium_sd_downloads_n" type="radio" name="premium_sd_downloads" value="0" {if $premium_sd_downloads == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="premium_sd_downloads_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">HD Downloads</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="premium_hd_downloads_y" type="radio" name="premium_hd_downloads" value="1" {if $premium_hd_downloads == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="premium_hd_downloads_y">Yes</label>
													<input id="premium_hd_downloads_n" type="radio" name="premium_hd_downloads" value="0" {if $premium_hd_downloads == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="premium_hd_downloads_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Mobile Downloads</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="premium_mobile_downloads_y" type="radio" name="premium_mobile_downloads" value="1" {if $premium_mobile_downloads == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="premium_mobile_downloads_y">Yes</label>
													<input id="premium_mobile_downloads_n" type="radio" name="premium_mobile_downloads" value="0" {if $premium_mobile_downloads == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="premium_mobile_downloads_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Upload Videos / Photos</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="premium_upload_video_y" type="radio" name="premium_upload_video" value="1" {if $premium_upload_video == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="premium_upload_video_y">Yes</label>
													<input id="premium_upload_video_n" type="radio" name="premium_upload_video" value="0" {if $premium_upload_video == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="premium_upload_video_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>										
										<div class="form-group">
											<label class="col-lg-4 control-label">Write Blogs</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="premium_write_in_blog_y" type="radio" name="premium_write_in_blog" value="1" {if $premium_write_in_blog == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="premium_write_in_blog_y">Yes</label>
													<input id="premium_write_in_blog_n" type="radio" name="premium_write_in_blog" value="0" {if $premium_write_in_blog == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="premium_write_in_blog_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>										
										<div class="form-group">
											<label class="col-lg-4 control-label">In-Player Ads</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="premium_in_player_ads_y" type="radio" name="premium_in_player_ads" value="1" {if $premium_in_player_ads == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="premium_in_player_ads_y">Show</label>
													<input id="premium_in_player_ads_n" type="radio" name="premium_in_player_ads" value="0" {if $premium_in_player_ads == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="premium_in_player_ads_n">Don't Show</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Bandwidth Limit</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="premium_bandwidth_select_e" type="radio" name="premium_bandwidth_select" value="1" {if $premium_bandwidth != '-1'}checked="checked"{/if} class="radio-enabled" onclick="pbandwidth(this.id)">
													<label for="premium_bandwidth_select_e">Enabled</label>
													<input id="premium_bandwidth_select_d" type="radio" name="premium_bandwidth_select" value="-1" {if $premium_bandwidth == '-1'}checked="checked"{/if} class="radio-disabled" onclick="pbandwidth(this.id)">
													<label for="premium_bandwidth_select_d">Disabled</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>					
										<div id="pbandw" class="form-group" style="display: {if $premium_bandwidth == '-1'} none; {else} block; {/if}">
											<label class="col-lg-4 control-label">Bandwidth Limit</label>
											<div class="col-lg-8">
												<input type="hidden" id="pselbandw" style="display: none" value="{$premium_bandwidth}">
												<input id='pbandwi' type="text" name="premium_bandwidth" value="{$premium_bandwidth}" class="form-control {if $err.premium_bandwidth}error{/if}">
												<span class="help">MB</span>
											</div>
											<div class="clearfix"></div>
										</div>	
									</div>
								</div>

							
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="submit_permisions_users" value="Save" class="btn btn-success btn-cons">
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
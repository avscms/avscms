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
						<h4>General <span class="semi-bold">Permissions</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="permissions_settings" method="POST" action="index.php?m=permissions">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3 col-md-12">
									<div class="col-xs-12 m-b-5">
										<h3>Permissions <span class="semi-bold">Configuration</span></h3>
									</div>								
									<div class="row">
										<div class="form-group">
											<label class="col-lg-4 control-label">User Registrations</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="user_registration_y" type="radio" name="user_registration" value="1" {if $user_registration == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="user_registration_y">Yes</label>
													<input id="user_registration_n" type="radio" name="user_registration" value="0" {if $user_registration == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="user_registration_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Email Verification</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="email_verification_y" type="radio" name="email_verification" value="1" {if $email_verification == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="email_verification_y">Yes</label>
													<input id="email_verification_n" type="radio" name="email_verification" value="0" {if $email_verification == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="email_verification_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Video Comments</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="video_comments_y" type="radio" name="video_comments" value="1" {if $video_comments == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="video_comments_y">Yes</label>
													<input id="video_comments_n" type="radio" name="video_comments" value="0" {if $video_comments == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="video_comments_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Photo Comments</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="photo_comments_y" type="radio" name="photo_comments" value="1" {if $photo_comments == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="photo_comments_y">Yes</label>
													<input id="photo_comments_n" type="radio" name="photo_comments" value="0" {if $photo_comments == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="photo_comments_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Blog Comments</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="blog_comments_y" type="radio" name="blog_comments" value="1" {if $blog_comments == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="blog_comments_y">Yes</label>
													<input id="blog_comments_n" type="radio" name="blog_comments" value="0" {if $blog_comments == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="blog_comments_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Wall Comments</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="wall_comments_y" type="radio" name="wall_comments" value="1" {if $wall_comments == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="wall_comments_y">Yes</label>
													<input id="wall_comments_n" type="radio" name="wall_comments" value="0" {if $wall_comments == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="wall_comments_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Edit Videos</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="edit_videos_y" type="radio" name="edit_videos" value="1" {if $edit_videos == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="edit_videos_y">Yes</label>
													<input id="edit_videos_n" type="radio" name="edit_videos" value="0" {if $edit_videos == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="edit_videos_n">No</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Video Watching</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="video_view_all" type="radio" name="video_view" value="all" {if $video_view == 'all'}checked="checked"{/if} class="radio-enabled">
													<label for="video_view_all">All</label>
													<input id="video_view_registered" type="radio" name="video_view" value="registered" {if $video_view == 'registered'}checked="checked"{/if} class="radio-enabled">
													<label for="video_view_registered">Members</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Video Voting</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="video_rate_user" type="radio" name="video_rate" value="user" {if $video_rate == 'user'}checked="checked"{/if} class="radio-enabled">
													<label for="video_rate_user">User</label>
													<input id="video_rate_ip" type="radio" name="video_rate" value="ip" {if $video_rate == 'ip'}checked="checked"{/if} class="radio-enabled">
													<label for="video_rate_ip">IP</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Photo Voting</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="photo_rate_user" type="radio" name="photo_rate" value="user" {if $photo_rate == 'user'}checked="checked"{/if} class="radio-enabled">
													<label for="photo_rate_user">User</label>
													<input id="photo_rate_ip" type="radio" name="photo_rate" value="ip" {if $photo_rate == 'ip'}checked="checked"{/if} class="radio-enabled">
													<label for="photo_rate_ip">IP</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Members Voting</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="user_rate_user" type="radio" name="user_rate" value="user" {if $user_rate == 'user'}checked="checked"{/if} class="radio-enabled">
													<label for="user_rate_user">User</label>
													<input id="user_rate_ip" type="radio" name="user_rate" value="ip" {if $user_rate == 'ip'}checked="checked"{/if} class="radio-enabled">
													<label for="user_rate_ip">IP</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>										
										<div class="form-group">
											<label class="col-lg-4 control-label">Comment Voting</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="comment_rate_user" type="radio" name="comment_rate" value="user" {if $comment_rate == 'user'}checked="checked"{/if} class="radio-enabled">
													<label for="comment_rate_user">User</label>
													<input id="comment_rate_ip" type="radio" name="comment_rate" value="ip" {if $comment_rate == 'ip'}checked="checked"{/if} class="radio-enabled">
													<label for="comment_rate_ip">IP</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>										
										<div class="form-group">
											<label class="col-lg-4 control-label">Private Messaging</label>
											<div class="col-lg-8">
												<select id="private_msgs" name="private_msgs" style="width:100%">
													<option value="all"{if $private_msgs == 'all'} selected="selected"{/if}>All</option>
													<option value="friends"{if $private_msgs == 'friends'} selected="selected"{/if}>Friends</option>
													<option value="disabled"{if $private_msgs == 'disabled'} selected="selected"{/if}>Disabled</option>
												</select>
											</div>
											<div class="clearfix"></div>
										</div>										
									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="submit_permissions" value="Save" class="btn btn-success btn-cons">
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
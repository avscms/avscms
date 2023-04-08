	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">  
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Settings - <span class="semi-bold">General</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>System <span class="semi-bold">Settings</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="system_settings" method="POST" action="index.php?m=main">						
							<div class="row column-seperation">
								<div class="col-md-6">
									<div class="row">
										<div class="col-xs-12 m-b-5">
											<h3>Website <span class="semi-bold">Settings</span></h3>
										</div>									
										<div class="form-group">
											<label class="col-lg-4 control-label">Site Name</label>
											<div class="col-lg-8">
												<input type="text" name="site_name" value="{$site_name}" class="form-control {if $err.site_name}error{/if}">
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="clearfix"></div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Site Title</label>
											<div class="col-lg-8">
												<input type="text" name="site_title" value="{$site_title}" class="form-control {if $err.site_title}error{/if}">
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="clearfix"></div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Meta Description</label>
											<div class="col-lg-8">
												<input type="text" name="meta_description" value="{$meta_description}" class="form-control {if $err.meta_description}error{/if}">
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="clearfix"></div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Meta Keywords</label>
											<div class="col-lg-8">
												<input type="text" name="meta_keywords" value="{$meta_keywords}" class="form-control {if $err.meta_keywords}error{/if}">
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Template</label>
											<div class="col-lg-8">
												<select id="template" name="template" style="width:100%">
													{foreach from=$templates key=k item=v}
														<option value="{$k}"{if $k == $template} selected="selected"{/if}>{$v}</option>
													{/foreach}
												</select>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Default Language</label>
											<div class="col-lg-8">
												<select id="language" name="language" style="width:100%">
													{foreach from=$languages key=k item=v}
														<option value="{$k}"{if $k == $language} selected="selected"{/if}>{$v.name}</option>
													{/foreach}
												</select>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									<table class="table-radio">
										<tbody>
											{include file='multiserversystem.tpl'}
											<tr>
												<td class="v-align-middle no-border" style="width:70%;">
													Multi Language
												</td>
												<td class="v-align-middle no-border" style="width:15%;">
													<div class="radio radio-success">
														 <input type="radio" {if $multi_language == '1'}checked="checked"{/if} value="1" name="multi_language" id="multi_language_e">
														 <label class="m-0" for="multi_language_e">Enabled</label>
													</div>												
												</td>
												<td class="v-align-middle no-border" style="width:15%;">
													<div class="radio radio-danger">
														<input type="radio" {if $multi_language == '0'}checked="checked"{/if} value="0" name="multi_language" id="multi_language_d">
														<label class="m-0" for="multi_language_d">Disabled</label>
													</div>
												</td>
											</tr>
											<tr>
												<td class="v-align-middle">
													Enter page
												</td>
												<td class="v-align-middle">
													<div class="radio radio-success">
														 <input type="radio" {if $splash == '1'}checked="checked"{/if} value="1" name="splash" id="splash_e">
														 <label class="m-0" for="splash_e">Enabled</label>
													</div>												
												</td>
												<td class="v-align-middle">
													<div class="radio radio-danger">
														<input type="radio" {if $splash == '0'}checked="checked"{/if} value="0" name="splash" id="splash_d">
														<label class="m-0" for="splash_d">Disabled</label>
													</div>
												</td>
											</tr>
											<tr>
												<td class="v-align-middle">
													Ads
												</td>
												<td class="v-align-middle">
													<div class="radio radio-success">
														 <input type="radio" {if $ads == '1'}checked="checked"{/if} value="1" name="ads" id="ads_e">
														 <label class="m-0" for="ads_e">Enabled</label>
													</div>												
												</td>
												<td class="v-align-middle">
													<div class="radio radio-danger">
														<input type="radio" {if $ads == '0'}checked="checked"{/if} value="0" name="ads" id="ads_d">
														<label class="m-0" for="ads_d">Disabled</label>
													</div>
												</td>
											</tr>
											<tr>
												<td class="v-align-middle">
													Video Downloads
												</td>
												<td class="v-align-middle">
													<div class="radio radio-success">
														 <input type="radio" {if $downloads == '1'}checked="checked"{/if} value="1" name="downloads" id="downloads_e">
														 <label class="m-0" for="downloads_e">Enabled</label>
													</div>												
												</td>
												<td class="v-align-middle">
													<div class="radio radio-danger">
														<input type="radio" {if $downloads == '0'}checked="checked"{/if} value="0" name="downloads" id="downloads_d">
														<label class="m-0" for="downloads_d">Disabled</label>
													</div>
												</td>
											</tr>
											<tr>
												<td class="v-align-middle">
													Delete Original Video
												</td>
												<td class="v-align-middle">
													<div class="radio radio-success">
														 <input type="radio" {if $del_original_video == '1'}checked="checked"{/if} value="1" name="del_original_video" id="del_original_video_e">
														 <label class="m-0" for="del_original_video_e">Enabled</label>
													</div>												
												</td>
												<td class="v-align-middle">
													<div class="radio radio-danger">
														<input type="radio" {if $del_original_video == '0'}checked="checked"{/if} value="0" name="del_original_video" id="del_original_video_d">
														<label class="m-0" for="del_original_video_d">Disabled</label>
													</div>
												</td>
											</tr>
											<tr>
												<td class="v-align-middle">
													Approve Videos
												</td>
												<td class="v-align-middle">
													<div class="radio radio-success">
														 <input type="radio" {if $approve == '1'}checked="checked"{/if} value="1" name="approve" id="approve_e">
														 <label class="m-0" for="approve_e">Enabled</label>
													</div>												
												</td>
												<td class="v-align-middle">
													<div class="radio radio-danger">
														<input type="radio" {if $approve == '0'}checked="checked"{/if} value="0" name="approve" id="approve_d">
														<label class="m-0" for="approve_d">Disabled</label>
													</div>
												</td>
											</tr>
											<tr>
												<td class="v-align-middle">
													Approve Photos
												</td>
												<td class="v-align-middle">
													<div class="radio radio-success">
														 <input type="radio" {if $approve_photos == '1'}checked="checked"{/if} value="1" name="approve_photos" id="approve_photos_e">
														 <label class="m-0" for="approve_photos_e">Enabled</label>
													</div>												
												</td>
												<td class="v-align-middle">
													<div class="radio radio-danger">
														<input type="radio" {if $approve_photos == '0'}checked="checked"{/if} value="0" name="approve_photos" id="approve_photos_d">
														<label class="m-0" for="approve_photos_d">Disabled</label>
													</div>
												</td>
											</tr>
											<tr>
												<td class="v-align-middle">
													Approve Blogs
												</td>
												<td class="v-align-middle">
													<div class="radio radio-success">
														 <input type="radio" {if $approve_blogs == '1'}checked="checked"{/if} value="1" name="approve_blogs" id="approve_blogs_e">
														 <label class="m-0" for="approve_blogs_e">Enabled</label>
													</div>												
												</td>
												<td class="v-align-middle">
													<div class="radio radio-danger">
														<input type="radio" {if $approve_blogs == '0'}checked="checked"{/if} value="0" name="approve_blogs" id="approve_blogs_d">
														<label class="m-0" for="approve_blogs_d">Disabled</label>
													</div>
												</td>
											</tr>
										</tbody>
									</table>									
								</div>
								<div class="col-md-6">
									<div class="row">
										<div class="col-xs-12 m-b-5">								
											<h3>Paging <span class="semi-bold">Settings</span></h3>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Videos Per Page</label>
											<div class="col-lg-8">
												<input type="text" name="videos_per_page" value="{$videos_per_page}" class="form-control {if $err.videos_per_page}error{/if}">
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<label class="col-lg-4 control-label">Albums Per Page</label>
											<div class="col-lg-8">
												<input type="text" name="albums_per_page" value="{$albums_per_page}" class="form-control {if $err.albums_per_page}error{/if}">
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<label class="col-lg-4 control-label">Blogs Per Page</label>
											<div class="col-lg-8">
												<input type="text" name="blogs_per_page" value="{$blogs_per_page}" class="form-control {if $err.blogs_per_page}error{/if}">
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<label class="col-lg-4 control-label">Users Per Page</label>
											<div class="col-lg-8">
												<input type="text" name="users_per_page" value="{$users_per_page}" class="form-control {if $err.users_per_page}error{/if}">
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<label class="col-lg-4 control-label">Watched Per Page</label>
											<div class="col-lg-8">
												<input type="text" name="watched_per_page" value="{$watched_per_page}" class="form-control {if $err.watched_per_page}error{/if}">
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<label class="col-lg-4 control-label">Recent Per Page</label>
											<div class="col-lg-8">
												<input type="text" name="recent_per_page" value="{$recent_per_page}" class="form-control {if $err.recent_per_page}error{/if}">
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<label class="col-lg-4 control-label">Thumbnail Size on Desktop</label>
											<div class="col-lg-8">
												<select id="max_col" name="max_col" style="width:100%">
													<option value="4"{if $max_col == 4} selected="selected"{/if}>25% - 4 columns</option>
													<option value="5"{if $max_col == 5} selected="selected"{/if}>20% - 5 columns</option>
												</select>
												<span class="help">Large devices</span>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<label class="col-lg-4 control-label">Thumbnail Size on Mobile</label>
											<div class="col-lg-8">
												<select id="min_col" name="min_col" style="width:100%">
													<option value="1"{if $min_col == 1} selected="selected"{/if}>100% - 1 column</option>
													<option value="2"{if $min_col == 2} selected="selected"{/if}>50% - 2 columns</option>
												</select>
												<span class="help">Small devices</span>												
											</div>
											<div class="clearfix"></div>
										</div>									
									</div>
								</div>
								<div class="col-md-6">
									<div class="row">
										<div class="col-xs-12 m-b-5">								
											<h3>Social <span class="semi-bold">Media</span></h3>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Facebook ID</label>
											<div class="col-lg-8">
												<input type="text" name="facebook_id" value="{$facebook_id}" class="form-control">
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Instagram ID</label>
											<div class="col-lg-8">
												<input type="text" name="instagram_id" value="{$instagram_id}" class="form-control">
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Twitter ID</label>
											<div class="col-lg-8">
												<input type="text" name="twitter_id" value="{$twitter_id}" class="form-control">
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Reddit ID</label>
											<div class="col-lg-8">
												<input type="text" name="reddit_id" value="{$reddit_id}" class="form-control">
											</div>
											<div class="clearfix"></div>
										</div>										
									</div>
								</div>								
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="submit_settings" value="Save" class="btn btn-success btn-cons">
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
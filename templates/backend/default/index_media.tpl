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
						<h4>Conversion <span class="semi-bold">Configuration</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="media_settings" method="POST" action="index.php?m=media">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3 col-md-12">
									<div class="row">
										<div class="col-xs-12 m-b-5">
											<h3>Paths <span class="semi-bold">Configuration</span></h3>
										</div>									
										<div class="form-group">
											<label class="col-lg-4 control-label">PHP CLI Path</label>
											<div class="col-lg-8 check-input">
												<input type="text" name="phppath" value="{$phppath}" class="form-control {if $err.phppath}error{/if}">
												{if $binaries.phppath == '1'}
													<i class="fa fa-check text-success check-icon"></i>
												{else}														
													<i class="fa fa-exclamation-triangle text-error check-icon"></i>
												{/if}
												{if $binaries.phppath != '1' && $binaries.phppath != ''}
													<span class="help text-warning">Path found: <b>{$binaries.phppath}</b></span>
												{/if}												
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">FFMpeg Path</label>
											<div class="col-lg-8 check-input">
												<input type="text" name="ffmpeg" value="{$ffmpeg}" class="form-control {if $err.ffmpeg}error{/if}">
												{if $binaries.ffmpeg == '1'}
													<i class="fa fa-check text-success check-icon"></i>
												{else}														
													<i class="fa fa-exclamation-triangle text-error check-icon"></i>
												{/if}
												{if $binaries.ffmpeg != '1' && $binaries.ffmpeg != ''}
													<span class="help text-warning">Path found: <b>{$binaries.ffmpeg}</b></span>
												{/if}
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">FFProbe Path</label>
											<div class="col-lg-8 check-input">
												<input type="text" name="ffprobe" value="{$ffprobe}" class="form-control {if $err.ffprobe}error{/if}">
												{if $binaries.ffprobe == '1'}
													<i class="fa fa-check text-success check-icon"></i>
												{else}														
													<i class="fa fa-exclamation-triangle text-error check-icon"></i>
												{/if}
												{if $binaries.ffprobe != '1' && $binaries.ffprobe != ''}
													<span class="help text-warning">Path found: <b>{$binaries.ffprobe}</b></span>
												{/if}
											</div>
											<div class="clearfix"></div>
										</div>				
										<div class="col-xs-12 m-b-5">
											<h3>Thumbnail <span class="semi-bold">Configuration</span></h3>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label">Thumbnail Generation Tool</label>
											<div class="col-md-8">
												<select id="thumbs_tool" name="thumbs_tool" style="width:100%">
												<!--<option value="mplayer"{if $thumbs_tool == 'mplayer'} selected="selected"{/if}>MPlayer</option>-->
													<option value="ffmpeg"{if $thumbs_tool == 'ffmpeg'} selected="selected"{/if}>FFMpeg</option>
												</select>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Thumbnail Width</label>
											<div class="col-lg-8">
												<input type="text" name="img_max_width" value="{$img_max_width}" class="form-control {if $err.img_max_width}error{/if}">
												<span class="help">Pixels</span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Thumbnail Height</label>
											<div class="col-lg-8">
												<input type="text" name="img_max_height" value="{$img_max_height}" class="form-control {if $err.img_max_height}error{/if}">
												<span class="help">Pixels</span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Thumbnail Player Width</label>
											<div class="col-lg-8">
												<input type="text" name="thumbnail_player_width" value="{$thumbnail_player_width}" class="form-control {if $err.thumbnail_player_width}error{/if}">
												<span class="help">Pixels</span>
											</div>
											<div class="clearfix"></div>
										</div>										
										<div class="form-group">
											<label class="col-lg-4 control-label">Thumbnail Player Height</label>
											<div class="col-lg-8">
												<input type="text" name="thumbnail_player_height" value="{$thumbnail_player_height}" class="form-control {if $err.thumbnail_player_height}error{/if}">
												<span class="help">Pixels</span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label"></label>
											<div class="col-lg-8">
												<div class="checkbox check-default">
													<input name="thumbnail_remove_bb" id="thumbnail_remove_bb" {if $thumbnail_remove_bb == 1}checked {/if}type="checkbox" value="1">
													<label for="thumbnail_remove_bb">Remove Black Bars</label>
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label"></label>
											<div class="col-lg-8">
												<div class="checkbox check-default">
													<input name="thumbnail_keep_ar" id="thumbnail_keep_ar" {if $thumbnail_keep_ar == 1}checked {/if}type="checkbox" value="1">
													<label for="thumbnail_keep_ar">Keep Aspect Ratio</label>
												</div>
											</div>
											<div class="clearfix"></div>
										</div>											
										<div class="col-xs-12 m-b-5">
											<h3>File <span class="semi-bold">Restrictions</span></h3>
										</div>										
										<div class="form-group">
											<label class="col-lg-4 control-label">Allowed Video Extensions</label>
											<div class="col-lg-8">
												<textarea rows="4" name="video_allowed_extensions" class="form-control {if $err.video_allowed_extensions}error{/if}" style="resize:vertical">{$video_allowed_extensions|wordwrap:48:"\n":true}</textarea>
												<span class="help">Comma separated</span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Max Upload Video Filesize</label>
											<div class="col-lg-8">
												<input type="text" name="video_max_size" value="{$video_max_size}" class="form-control {if $err.video_max_size}error{/if}">
												<span class="help">MB</span>
											</div>
											<div class="clearfix"></div>
										</div>										
										<!-- Conversion Q -->
										<div class="col-xs-12 m-b-5">
											<h3>Conversion Queue <span class="semi-bold">Configuration</span></h3>
										</div>										
										<div class="form-group">
											<label class="col-lg-4 control-label">Conversion Queue</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="conversion_q_e" type="radio" name="conversion_q" value="1" {if $conversion_q == '1'}checked="checked"{/if} class="radio-enabled">
													<label for="conversion_q_e">Enabled</label>
													<input id="conversion_q_d" type="radio" name="conversion_q" value="0" {if $conversion_q == '0'}checked="checked"{/if} class="radio-disabled">
													<label for="conversion_q_d">Disabled</label>												
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Max Simultaneous Conversions</label>
											<div class="col-lg-8">
												<input type="number" min="1" max="100" name="q_limit" value="{$q_limit}" class="form-control {if $err.q_limit}error{/if}"/>
												<span class="help">Recommended range: 1-5 / Minimum value: 1</span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Conversion Timeout Limit</label>
											<div class="col-lg-8">
												<input type="number" min="1" max="100" name="q_timeout" value="{$q_timeout}" class="form-control {if $err.q_timeout}error{/if}"/>
												<span class="help">Recommended value: 6 / Minimum value: 1 (hours)</span>
											</div>
											<div class="clearfix"></div>
										</div>										
										<!-- Conversion Q -->											
									</div>									
								</div>									
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="submit_media" value="Save" class="btn btn-success btn-cons">
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
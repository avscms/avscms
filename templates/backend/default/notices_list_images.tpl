	{include file="image_view.tpl"}
	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Notices - <span class="semi-bold">Notice Images</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->															
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>Notice <span class="semi-bold">Images</span></h4>				
					</div>
					<div class="grid-body no-border">
						<div class="row">
							<div class="col-xs-12">
								<form class="form-no-horizontal-spacing form-grey" name="add_images" method="POST" enctype="multipart/form-data" action="notices.php?m=list_images">
									<div class="row">
										<div class="col-xs-12 col-sm-6 col-md-3">
											<div class="form-group">
												<div id="get_file" class="btn btn btn-success btn-file" onclick="getFile('images')">Choose File(s)</div>
												<div class="file-box">
													<span id="upimages">Images - No file chosen</span>
													<input name="images[]" type="file" id="images" onChange="sub(this,'upimages','nofile')" multiple accept=".gif,.jpg,.jpeg,.png" />
													<input type="hidden" id="nofile" value="No File">
												</div>
											</div>
										</div>										
										<div class="col-xs-12 col-sm-6 col-md-3 col-md-offset-6">
											<div class="form-group">
												<input type="submit" name="add_images" value="Add Image(s)" class="btn btn-success btn-cons btn-icon m-0 pull-right">
												<div class="clearfix"></div>
											</div>
										</div>
									</div>			
								</form>
							</div>
						</div>
						<!-- END SEARCH FILTERS -->						
						<div class="row">
							<div class="col-xs-12">
								<div>
									{if $images}									
										<div class="s-pagination">{$paging}</div>
										{section name=i loop=$images}
											<div id="item-{$images[i].image_id}" class="item-main-container notice" style="min-height: 100px">
												<div class="item-col-left">
													<div class="item-main">
														<div class="item-thumb">
															<div class="thumb-overlay">
																<a id="view_image_{$images[i].image_id}" href="#">															
																	<img id="thumb-{$images[i].image_id}" src="{$baseurl}/images/notice_images/thumbs/{$images[i].image_id}.jpg" class="img-responsive image-thumb">
																</a>
																<div class="item-id">
																	<b>ID</b> {$images[i].image_id}
																</div>
																<div id="image-loading-{$images[i].image_id}" class="thumbnails-loading" style="display: none"><i class="loader"></i></div>
															</div>												
														</div>
													</div>
												</div>
												<div class="item-col-right">
													<div class="item-details">
														<div class="row">						
															<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
																<div class="d-label m-b-5">Link</div>
																<input id="link-{$images[i].image_id}" type="text" value="{$baseurl}/images/notice_images/{$images[i].image_id}.jpg" class="form-control" disabled>
																<a id="copy-link-{$images[i].image_id}" href="#" class="btn btn-success btn-small btn-copy">Copy to Clipboard</a>
															</div>
															<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
																<div class="d-label">Add Date</div>
																{$images[i].addtime|date_format}
															</div>
														</div>
													</div>
												</div>
												<div class="clearfix"></div>
												<div class="item-actions">																									
													<div class="btn-group">
														<div class="btn-group">
															<a id="delete__image_{$images[i].image_id}" class="btn btn-success btn-rounded" data-toggle="dropdown" href="#" alt="Delete" title="Delete"><i class="fa fa-trash-o"></i></a>
															<ul class="dropdown-menu">
																<li><a id="delete_image_{$images[i].image_id}" href="#">Delete</a></li>
															</ul>
														</div>
													</div>
												
												</div>												
											</div>
										{/section}
										<div class="s-pagination">{$paging}</div>
									{else}
									<div class="row">
										<div class="col-xs-12">
											<div class="alert alert-info">
												<button class="close" data-dismiss="alert"></button>
												No Images Found
											</div>
										</div>
									</div>
									{/if}	
								</div>
							
							</div>
						</div>
					</div>
				</div>
			</div>			
			<!-- END PLACE PAGE CONTENT HERE -->
		</div>
	</div>
	<!-- END PAGE CONTAINER -->	
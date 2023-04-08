	{include file="album_edit.tpl"}
	{include file="album_cover.tpl"}
	{include file="album_view.tpl"}	
	{include file="comments.tpl"}
	{include file="album_add_photos.tpl"}
	{include file="photo_edit.tpl"}	
	{include file="photo_view.tpl"}
	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Albums - <span class="semi-bold">Requests / Flagged</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->															
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>Search <span class="semi-bold">Filters</span></h4>
					</div>
					<div class="grid-body no-border">
						<div class="row">
							<div class="col-xs-12">
								<form class="form-no-horizontal-spacing search-filters" name="search_albums" method="POST" action="albums.php?m={$module}">
									<div class="filters">
									<div class="row">
										<div class="filter col-xs-12 col-sm-6 col-md-6">
											<div class="form-group">
												<input type="text"  id="filter_flagger" name="flagger" value="{$option.flagger}" class="form-control {if $option.flagger}filter-active{/if}" placeholder="Flagger">
												<i id="filter_remove_flagger" class="fa fa-times remove-filter" {if !$option.flagger}style="display:none"{/if}></i>
											</div>										
										</div>
									</div>
									<input id="sort" name="sort" type="hidden" value={$option.sort}>
									<input id="order" name="order" type="hidden" value={$option.order}>
									<input id="display" name="display" type="hidden" value={$option.display}>

									<div class="pull-left">
										<div class="btn-group"> <a class="btn dropdown-toggle btn-demo-space" data-toggle="dropdown" href="#">Order by <span id="sort_items">{if $option.sort == 'f.add_date'}Date{else}ID{/if}</span> <span class="caret"></span> </a>
											<ul class="dropdown-menu">
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'ID'; document.getElementById('sort').value = 'p.PID'" >ID</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Date'; document.getElementById('sort').value = 'f.add_date'" >Date</a></li>												
											</ul>
										</div>									
										<div class="btn-group"> <a class="btn dropdown-toggle btn-demo-space" data-toggle="dropdown" href="#"><span id="order_items">{if $option.order == 'ASC'}Ascending{else}Descending{/if}</span> <span class="caret"></span> </a>
											<ul class="dropdown-menu">
												<li><a href="#" onClick="document.getElementById('order_items').innerText = 'Ascending'; document.getElementById('order').value = 'ASC'" >Ascending</a></li>
												<li><a href="#" onClick="document.getElementById('order_items').innerText = 'Descending'; document.getElementById('order').value = 'DESC'" >Descending</a></li>
											</ul>
										</div>									
										<div class="btn-group"> <a class="btn dropdown-toggle btn-demo-space" data-toggle="dropdown" href="#"><span id="display_items">{$option.display}</span> <span class="caret"></span> </a>
											<ul class="dropdown-menu">
												<li><a href="#" onClick="document.getElementById('display_items').innerText = '10'; document.getElementById('display').value = '10'" >10</a></li>
												<li><a href="#" onClick="document.getElementById('display_items').innerText = '20'; document.getElementById('display').value = '20'" >20</a></li>
												<li><a href="#" onClick="document.getElementById('display_items').innerText = '30'; document.getElementById('display').value = '30'" >30</a></li>
												<li><a href="#" onClick="document.getElementById('display_items').innerText = '40'; document.getElementById('display').value = '40'" >40</a></li>
												<li><a href="#" onClick="document.getElementById('display_items').innerText = '50'; document.getElementById('display').value = '50'" >50</a></li>
												<li><a href="#" onClick="document.getElementById('display_items').innerText = '100'; document.getElementById('display').value = '100'" >100</a></li>
												<li><a href="#" onClick="document.getElementById('display_items').innerText = '200'; document.getElementById('display').value = '200'" >200</a></li>
											</ul>
										</div>
									</div>
									<div class="pull-right">
										<button type="button" id="reset_search" name="reset_search" class="btn btn-white btn-cons btn-icon"><i class="fa fa-times"></i></button>									
										<button type="submit" name="search_flags" class="btn btn-success btn-cons btn-icon m-r-0"><i class="fa fa-search"></i></button>									
									</div>
									<div class="clearfix"></div>
								</div>									
							</form>
						</div>
						<!-- END SEARCH FILTERS -->						
						<div class="form-row">
							<div class="col-xs-12">
								<div>
									 {if $photos}
										<form class="form-no-horizontal-spacing" name="photo_select" method="post" id="photo_select" action="">
											<div>
												<input type="submit" name="delete_selected_photos" value="Delete" class="btn btn-danger btn-cons" onClick="javascript:return confirm('Are you sure you want to delete all selected photos?');">
												<input type="submit" name="suspend_selected_photos" value="Suspend" class="btn btn-white btn-cons" onClick="javascript:return confirm('Are you sure you want to suspend all selected photos?');">
												<input type="submit" name="approve_selected_photos" value="Approve" class="btn btn-white btn-cons" onClick="javascript:return confirm('Are you sure you want to approve all selected photos?');">
												<input type="submit" name="unflag_selected_photos" value="Unflag" class="btn btn-white btn-cons" onClick="javascript:return confirm('Are you sure you want to unflag all selected photos?');">												
											</div>									 
											<div class="s-pagination">{$paging}</div>
											<div class="checkbox check-default">
												<input id="check_all_albums" name="check_all_albums" type="checkbox">
												<label for="check_all_albums" style="margin: 0 0 15px 10px !important;">Select All</label>
												<code class="text-info hidden-xs hidden-sm pull-right">Use CHECK -> SHIFT + CHECK to select multiple photos.</code>
											</div>											
											{section name=i loop=$photos}
												<div id="photo-item-{$photos[i].PID}" class="item-main-container album">
													<div class="item-col-left">
														<div class="item-main">
															<div class="item-select" unselectable="on" onselectstart="return false;" onmousedown="return false;">
																<div class="checkbox check-default">
																	<input name="photo_id_checkbox_{$photos[i].PID}" id="photo_checkbox_{$photos[i].PID}" type="checkbox" class="select-multiple">
																	<label for="photo_checkbox_{$photos[i].PID}" style="margin: 0 0 15px 0 !important;"></label>
																</div>												
															</div>														
															<div class="item-thumb">
																<div class="thumb-overlay">														
																	<a id="view_photo_{$photos[i].PID}" href="#">
																		<img src="{$baseurl}/media/photos/tmb/{$photos[i].PID}.jpg" class="img-responsive">
																	</a>
																	<div class="item-id">
																		<b>ID</b> {$photos[i].PID}
																	</div>
																	<div id="photo-loading-{$photos[i].PID}" class="thumbnails-loading" style="display: none"><i class="loader"></i></div>
																</div>												
															</div>
														</div>
													</div>
													<div class="item-col-right">
														<div class="item-details">
															<div class="item-title">
																<span id="photo-caption-{$photos[i].PID}">{$photos[i].caption|escape:'html'}</span>
															</div>
															<div class="row">						
																<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
																	<div class="d-label">Flagger</div>
																	{insert name=uid_to_name assign=uname uid=$photos[i].UID}
																	<a href="users.php?m=all&all=1&UID={$photos[i].UID}" class="text-warning">{$uname}</a>													
																</div>															
																<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
																	<div class="d-label">Status</div>
																	<span id="photo-status-{$photos[i].PID}">
																		{if $photos[i].status == 1}
																			<span class="text-green" alt="Active" title="Active">Active</span>
																		{else}
																			<span class="text-red" alt="Inactive" title="Inactive">Inactive</span>
																		{/if}
																	</span>
																</div>
																<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
																	<div class="d-label">Date</div>
																	{$photos[i].add_date|date_format}													
																</div>
																<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
																	<div class="d-label">Reason</div>
																	<div class="text-red text-ellipsis">
																		<b>{$photos[i].reason}{if $photos[i].message}:{/if}</b>
																		{if $photos[i].message}
																			<span alt="{$photos[i].message|escape:'html'|nl2br}" title="{$photos[i].message|escape:'html'|nl2br}">
																				{$photos[i].message|escape:'html'|nl2br}
																			</span>
																		{/if}
																	</div>																
																</div>
															</div>
														</div>
													</div>
													<div class="clearfix"></div>
													<div class="item-actions">																									
														<div class="btn-group">
															<div class="btn-group">
																<a id="delete__photo_{$photos[i].PID}" class="btn btn-success" data-toggle="dropdown" href="#" alt="Delete" title="Delete">
																<i class="fa fa-trash-o"></i></a>				
																<ul class="dropdown-menu">					
																	<li><a id="delete_photo_{$photos[i].PID}" href="#">Delete</a></li>
																</ul>
															</div>
															<a id="edit_photo_{$photos[i].PID}" class="btn btn-success" href="#" alt="Edit" title="Edit"><i class="fa fa-pencil"></i></a>			
															{if $photos[i].status == 1}
																<a id="status_photo_{$photos[i].PID}" class="btn btn-success" href="#" alt="Suspend" title="Suspend" data-processing="0" data-status="1"><i class="fa fa-times"></i></a>
															{else}
																<a id="status_photo_{$photos[i].PID}" class="btn btn-success" href="#" alt="Activate" title="Activate" data-processing="0" data-status="0"><i class="fa fa-check"></i></a>
															{/if}
															<div class="btn-group">
																<a id="unflag__photo_{$photos[i].PID}" class="btn btn-success" data-toggle="dropdown" href="#" alt="Unflag" title="Unflag"><i class="fa fa-flag-o"></i></a>
																<ul class="dropdown-menu">
																	<li><a id="unflag_photo_{$photos[i].FID}_{$photos[i].PID}" href="#">Unflag</a></li>
																</ul>
															</div>														
														</div>												
													</div>												
												</div>
											{/section}
											<div class="s-pagination">{$paging}</div>
										</form>
									{else}
										<div class="alert alert-info">
											<button class="close" data-dismiss="alert"></button>
											No Photos Found
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
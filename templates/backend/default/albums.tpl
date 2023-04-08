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
				<h3>Albums - <span class="semi-bold">Manage Albums</span></h3>
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
											<div class="filter col-xs-12 col-sm-6 col-md-4">
												<div class="form-group">
													<input type="text" id="filter_username" name="username" value="{$option.username}" class="form-control {if $option.username}filter-active{/if}" placeholder="Username">
													<i id="filter_remove_username" class="fa fa-times remove-filter" {if !$option.username}style="display:none"{/if}></i>
												</div>
											</div>
											<div class="filter col-xs-12 col-sm-6 col-md-4">
												<div class="form-group">
													<input type="text"  id="filter_name" name="name" value="{$option.name}" class="form-control {if $option.name}filter-active{/if}" placeholder="Name">
													<i id="filter_remove_name" class="fa fa-times remove-filter" {if !$option.name}style="display:none"{/if}></i>
												</div>										
											</div>
											<div class="filter col-xs-12 col-sm-6 col-md-4">
												<div class="form-group">
													<input type="text"  id="filter_tags" name="tags" value="{$option.tags}" class="form-control {if $option.tags}filter-active{/if}" placeholder="Tag">
													<i id="filter_remove_tags" class="fa fa-times remove-filter" {if !$option.tags}style="display:none"{/if}></i>
												</div>										
											</div>
											<div class="filter col-xs-12 col-sm-6 col-md-4">
												<div class="form-group">
													<select id="filter_category" name="category" style="width:100%">
														<option value="">Category</option>
														{section name=i loop=$categories}
														<option value="{$categories[i].CID}"{if $categories[i].CID == $option.category } selected="selected"{/if}>{$categories[i].name}</option>
														{/section}
													</select>  												
												</div>
											</div>
											<div class="filter col-xs-12 col-sm-6 col-md-4">
												<div class="form-group">
													<select id="filter_status" name="status" style="width:100%">
														<option value="">Status</option>
														<option value="1"{if $option.status == '1'} selected="selected"{/if}>Active</option>
														<option value="0"{if $option.status == '0'} selected="selected"{/if}>Inactive</option>
													</select>												
												</div>
											</div>
											<div class="filter col-xs-12 col-sm-6 col-md-4">
												<div class="form-group">
													<select id="filter_type" name="type" style="width:100%">
														<option value="">Type</option>
														<option value="public"{if $option.type == 'public'} selected="selected"{/if}>Public</option>
														<option value="private"{if $option.type == 'private'} selected="selected"{/if}>Private</option>
													</select>												
												</div>
											</div>										
										</div>
									</div>
									<input id="sort" name="sort" type="hidden" value={$option.sort}>
									<input id="order" name="order" type="hidden" value={$option.order}>
									<input id="display" name="display" type="hidden" value={$option.display}>

									<div class="pull-left">
										<div class="btn-group"> <a class="btn dropdown-toggle btn-demo-space" data-toggle="dropdown" href="#">Order by <span id="sort_items">{if $option.sort == 'a.name'}Name{elseif $option.sort == 'a.type'}Type{elseif $option.sort == 'a.total_photos'}Photos{elseif $option.sort == 'a.adddate'}Date{elseif $option.sort == 'a.total_views'}Views{elseif $option.sort == 'a.total_favorites'}Favorites{elseif $option.sort == 'a.total_comments'}Comments{else}ID{/if}</span> <span class="caret"></span> </a>
											<ul class="dropdown-menu">
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'ID'; document.getElementById('sort').value = 'a.AID'" >ID</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Name'; document.getElementById('sort').value = 'a.name'" >Name</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Type'; document.getElementById('sort').value = 'a.type'" >Type</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Photos'; document.getElementById('sort').value = 'a.total_photos'" >Photos</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Date'; document.getElementById('sort').value = 'a.adddate'" >Date</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Views'; document.getElementById('sort').value = 'a.total_views'" >Views</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Favorites'; document.getElementById('sort').value = 'a.total_favorites'" >Favorites</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Comments'; document.getElementById('sort').value = 'a.total_comments'" >Comments</a></li>											
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
										<button type="submit" name="search_albums" class="btn btn-success btn-cons btn-icon m-r-0"><i class="fa fa-search"></i></button>									
									</div>
									<div class="clearfix"></div>
								</form>
							</div>
						</div>
						<!-- END SEARCH FILTERS -->
						<div class="row">
							<div class="col-xs-12">
								<div>
									 {if $total_albums >= 1}
										<form class="form-no-horizontal-spacing" name="album_select" method="post" id="album_select" action="">
										<div>
											<input type="submit" name="delete_selected_albums" value="Delete" class="btn btn-danger btn-cons" onClick="javascript:return confirm('Are you sure you want to delete all selected albums?');">
											<input type="submit" name="suspend_selected_albums" value="Suspend" class="btn btn-white btn-cons" onClick="javascript:return confirm('Are you sure you want to suspend all selected albums?');">
											<input type="submit" name="approve_selected_albums" value="Approve" class="btn btn-white btn-cons" onClick="javascript:return confirm('Are you sure you want to approve all selected albums?');">
										</div>
										<div class="s-pagination">{$paging}</div>
										<div class="checkbox check-default">
											<input id="check_all_albums" name="check_all_albums" type="checkbox">
											<label for="check_all_albums" style="margin: 0 0 15px 10px !important;">Select All</label>
											<code class="text-info hidden-xs hidden-sm pull-right">Use CHECK -> SHIFT + CHECK to select multiple albums.</code>
										</div>
										{section name=i loop=$albums}
											<div id="item-{$albums[i].AID}" class="item-main-container album">
												<div class="item-col-left">
													<div class="item-main">
														<div class="item-select" unselectable="on" onselectstart="return false;" onmousedown="return false;">
															<div class="checkbox check-default">
																<input name="album_id_checkbox_{$albums[i].AID}" id="album_checkbox_{$albums[i].AID}" type="checkbox" class="select-multiple">
																<label for="album_checkbox_{$albums[i].AID}" style="margin: 0 0 15px 0 !important;"></label>
															</div>												
														</div>
														<div class="item-thumb">
															<div class="thumb-overlay">														
																<a id="view_album_{$albums[i].AID}" href="#">
																	<img id="thumb-{$albums[i].AID}" src="{$baseurl}/media/albums/{$albums[i].AID}.jpg" class="img-responsive">
																</a>
																<div class="item-id">
																	<b>ID</b> {$albums[i].AID}
																</div>
																<div class="item-duration-hd">
																	<i class="fa fa-camera"></i> <span id="album-total-photos-{$albums[i].AID}">{$albums[i].total_photos}</span>
																</div>
																<div id="private-{$albums[i].AID}">
																	{if $albums[i].type == 'private'}<div class="item-private">PRIVATE</div>{/if}
																</div>
																<div id="photos-loading-{$albums[i].AID}" class="thumbnails-loading" style="display: none"><i class="loader"></i></div>
															</div>												
														</div>
													</div>
												</div>
												<div class="item-col-right">
													<div class="item-details">
														<div class="item-title">
															<a id="view_album_{$albums[i].AID}_" href="#"><span id="name-{$albums[i].AID}">{$albums[i].name|escape:'html'}</span></a>
														</div>
														<div class="row">						
															<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
																<div class="d-label">User</div>
																<a href="users.php?m=all&all=1&UID={$albums[i].UID}" class="text-info">{$albums[i].username}</a>															
															</div>
															<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
																<div class="d-label">Status</div>
																<span id="status-{$albums[i].AID}">
																	{if $albums[i].status == 1}
																		<span class="text-green" alt="Active" title="Active">Active</span>
																	{else}
																		<span class="text-red" alt="Inactive" title="Inactive">Inactive</span>
																	{/if}
																</span>
															</div>
															<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
																<div class="d-label">Date</div>
																{$albums[i].adddate|date_format}													
															</div>
															<div class="col-xs-4 col-sm-4 col-md-1 col-lg-1">
																<div class="d-label"><i class="fa fa-comments"></i></div>
																<span id="comments_Album_{$albums[i].AID}" class="text-muted">{$albums[i].total_comments}</span>
															</div>
															<div class="col-xs-4 col-sm-4 col-md-1 col-lg-1">
																<div class="d-label"><i class="fa fa-eye"></i></div>
																<span id="views-{$albums[i].AID}">{$albums[i].total_views}</span>
															</div>
															<div class="col-xs-4 col-sm-4 col-md-1 col-lg-1">
																<div class="d-label"><i class="fa fa-star"></i></div>
																{$albums[i].total_favorites}
															</div>
														</div>
													</div>
												</div>
												<div class="clearfix"></div>
												<div class="item-actions">																									
													<div class="btn-group">
														<div class="btn-group">
															<a id="delete__album_{$albums[i].AID}" class="btn btn-success" data-toggle="dropdown" href="#" alt="Delete" title="Delete"><i class="fa fa-trash-o"></i></a>
															<ul class="dropdown-menu">
																<li><a id="delete_album_{$albums[i].AID}" href="#">Delete</a></li>
															</ul>
														</div>
														<a id="edit_album_{$albums[i].AID}" class="btn btn-success" href="#" alt="Edit" title="Edit"><i class="fa fa-pencil"></i></a>
														<a id="addphotos_album_{$albums[i].AID}" class="btn btn-success" href="#" alt="Add Photos" title="Add Photos"><i class="fa fa-plus"></i></a>
														<a id="cover_album_{$albums[i].AID}" class="btn btn-success" href="#" alt="Cover" title="Cover"><i class="fa fa-picture-o"></i></a>
														{if $albums[i].status == '1'}
															<a id="status_album_{$albums[i].AID}" class="btn btn-success" href="#" alt="Suspend" title="Suspend" data-processing="0" data-status="1"><i class="fa fa-times"></i></a>
														{else}
															<a id="status_album_{$albums[i].AID}" class="btn btn-success" href="#" alt="Activate" title="Activate" data-processing="0" data-status="0"><i class="fa fa-check"></i></a>
														{/if}																	
													</div>
												
												</div>												
											</div>
										{/section}
										<div class="s-pagination">{$paging}</div>										
										</form>
									{else}
										<div class="alert alert-info">
											<button class="close" data-dismiss="alert"></button>
											No Albums Found
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
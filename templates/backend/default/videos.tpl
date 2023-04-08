	{include file="video_view.tpl"}	
	{include file="video_edit.tpl"}
	{include file="video_thumbnails.tpl"}		
	{include file="comments.tpl"}	
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
						<h4>Search <span class="semi-bold">Filters</span></h4>
					</div>
					<div class="grid-body no-border">
						<div class="row">
							<div class="col-xs-12">
								<form class="form-no-horizontal-spacing search-filters" name="search_videos" method="POST" action="videos.php?m={$module}">
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
													<input type="text"  id="filter_title" name="title" value="{$option.title}" class="form-control {if $option.title}filter-active{/if}" placeholder="Title">
													<i id="filter_remove_title" class="fa fa-times remove-filter" {if !$option.title}style="display:none"{/if}></i>
												</div>										
											</div>
											<!--
											<div class="filter col-xs-12 col-sm-6 col-md-4">
												<div class="form-group">
													<input type="text"  id="filter_description" name="description" value="{$option.description}" class="form-control {if $option.description}filter-active{/if}" placeholder="Description">
													<i id="filter_remove_description" class="fa fa-times remove-filter" {if !$option.description}style="display:none"{/if}></i>
												</div>										
											</div>
											-->
											<div class="filter col-xs-12 col-sm-6 col-md-4">
												<div class="form-group">
													<input type="text"  id="filter_keyword" name="keyword" value="{$option.keyword}" class="form-control {if $option.keyword}filter-active{/if}" placeholder="Tag">
													<i id="filter_remove_keyword" class="fa fa-times remove-filter" {if !$option.keyword}style="display:none"{/if}></i>
												</div>										
											</div>
											<div class="filter col-xs-12 col-sm-6 col-md-4">
												<div class="form-group">
													<select id="filter_channel" name="channel" style="width:100%">
														<option value="">Category</option>
														{section name=i loop=$channels}
														<option value="{$channels[i].CHID}"{if $channels[i].CHID == $option.channel } selected="selected"{/if}>{$channels[i].name}</option>
														{/section}
													</select>  												
												</div>
											</div>
											<div class="filter col-xs-12 col-sm-6 col-md-4">
												<div class="form-group">
													<select id="filter_active" name="active" style="width:100%">
														<option value="">Status</option>
														<option value="1"{if $option.active == '1'} selected="selected"{/if}>Active</option>
														<option value="0"{if $option.active == '0'} selected="selected"{/if}>Inactive</option>
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
										<div class="btn-group"> <a class="btn dropdown-toggle btn-demo-space" data-toggle="dropdown" href="#">Order by <span id="sort_items">{if $option.sort == 'v.title'}Title{elseif $option.sort == 'v.type'}Type{elseif $option.sort == 'v.duration'}Duration{elseif $option.sort == 'v.addtime'}Date{elseif $option.sort == 'v.viewnumber'}Views{elseif $option.sort == 'v.fav_num'}Favorites{elseif $option.sort == 'v.com_num'}Comments{else}ID{/if}</span> <span class="caret"></span> </a>
											<ul class="dropdown-menu">
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'ID'; document.getElementById('sort').value = 'v.VID'" >ID</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Title'; document.getElementById('sort').value = 'v.title'" >Title</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Type'; document.getElementById('sort').value = 'v.type'" >Type</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Duration'; document.getElementById('sort').value = 'v.duration'" >Duration</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Date'; document.getElementById('sort').value = 'v.addtime'" >Date</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Views'; document.getElementById('sort').value = 'v.viewnumber'" >Views</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Favorites'; document.getElementById('sort').value = 'v.fav_num'" >Favorites</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Comments'; document.getElementById('sort').value = 'v.com_num'" >Comments</a></li>											
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
										<button type="submit" name="search_videos" class="btn btn-success btn-cons btn-icon m-r-0"><i class="fa fa-search"></i></button>									
									</div>
									<div class="clearfix"></div>
								</form>
							</div>
						</div>
						<!-- END SEARCH FILTERS -->
						<div class="row">
							<div class="col-xs-12">
								<div>
									{if $total_videos >= 1}
										<form class="form-no-horizontal-spacing" name="video_select" method="post" id="video_select" action="">
										<div>
											<input type="submit" name="delete_selected_videos" value="Delete" class="btn btn-danger btn-cons" onClick="javascript:return confirm('Are you sure you want to delete all selected videos?');">
											<input type="submit" name="suspend_selected_videos" value="Suspend" class="btn btn-white btn-cons" onClick="javascript:return confirm('Are you sure you want to suspend all selected videos?');">
											<input type="submit" name="approve_selected_videos" value="Approve" class="btn btn-white btn-cons" onClick="javascript:return confirm('Are you sure you want to approve all selected videos?');">
										</div>
										<div class="s-pagination">{$paging}</div>
										<div class="checkbox check-default">											
											<input id="check_all_videos" name="check_all_videos" type="checkbox">
											<label for="check_all_videos" style="margin: 0 0 15px 10px !important;">Select All</label>
											<code class="text-info hidden-xs hidden-sm pull-right">Use CHECK -> SHIFT + CHECK to select multiple videos.</code>
										</div>
											
										{section name=i loop=$videos}
											<div id="item-{$videos[i].VID}" class="item-main-container">
												<div class="item-col-left">
													<div class="item-main">
														<div class="item-select" unselectable="on" onselectstart="return false;" onmousedown="return false;">
															<div class="checkbox check-default">
																<input name="video_id_checkbox_{$videos[i].VID}" id="video_checkbox_{$videos[i].VID}" type="checkbox" class="select-multiple">
																<label for="video_checkbox_{$videos[i].VID}" style="margin: 0 0 15px 0 !important;"></label>
															</div>												
														</div>
														<div class="item-thumb">
															<div class="thumb-overlay">														
																<a id="view_video_{$videos[i].VID}" href="#">
																	<img id="thumb-{$videos[i].VID}" src="{insert name=thumb_adm vid=$videos[i].VID thumb=$videos[i].thumb}" class="img-responsive">
																</a>
																<div class="item-id">
																	<b>ID</b> {$videos[i].VID}
																</div>
																<div class="item-duration-hd">																
																	{insert name=duration assign=duration duration=$videos[i].duration}
																	{if $videos[i].hd==1}<b>HD</b> {/if}<span id="duration-{$videos[i].VID}">{$duration}</span>
																</div>
																<div id="private-{$videos[i].VID}">
																	{if $videos[i].type == 'private'}<div class="item-private">PRIVATE</div>{/if}															
																</div>
															</div>												
														</div>
													</div>
												</div>
												<div class="item-col-right">
													<div class="item-details">
														<div class="item-title">
															<a id="view_video_{$videos[i].VID}_" href="#"><span id="title-{$videos[i].VID}">{$videos[i].title|escape:'html'}</span></a>
														</div>
														<div class="row">						
															<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
																<div class="d-label">User</div>
																<a href="users.php?m=all&all=1&UID={$videos[i].UID}" class="text-info">{$videos[i].username}</a>															
															</div>
															<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
																<div class="d-label">Status</div>
																<span id="status-{$videos[i].VID}">
																	{if $videos[i].active == 1}
																		<span class="text-green" alt="Active" title="Active">Active</span>
																	{else}
																		<span class="text-red" alt="Inactive" title="Inactive">Inactive</span>
																	{/if}
																</span>
															</div>
															<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
																<div class="d-label">
																	Formats
																	{if $multi_server == '1' && $videos[i].embed_code == ''}
																		{if $videos[i].server != ''}
																			&nbsp;/&nbsp;<span class="text-info">Remote Server</span> 
																		{else}
																			&nbsp;/&nbsp;<span class="text-info">Local Server</span>
																		{/if}
																	{/if}																	
																</div>
																{if $videos[i].lformats==''}																
																	{if $videos[i].embed_code!=''}
																		EMBEDDED
																	{else}
																		{if $videos[i].flv==1}SD {/if}
																		{if $videos[i].iphone==1}{if $videos[i].flv!=1}SD-{/if}MOBILE {/if}
																		{if $videos[i].hd==1}HD {/if}
																	{/if}
																{else}
																	{$videos[i].lformats}
																{/if}
															</div>
															<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
																<div class="d-label">Date</div>
																{$videos[i].adddate|date_format}													
															</div>
															<div class="col-xs-6 col-sm-2 col-md-1 col-lg-1">
																<div class="d-label"><i class="fa fa-comments"></i></div>
																{if $videos[i].com_num > 0}
																	<a id="comments_Video_{$videos[i].VID}" href="#" class="text-info">{$videos[i].com_num}</a>
																{else}
																	<span class="text-muted">{$videos[i].com_num}</span>
																{/if}
															</div>
															<div class="col-xs-6 col-sm-2 col-md-1 col-lg-1 hidden-sm hidden-md">
																<div class="d-label"><i class="fa fa-eye"></i></div>
																<span id="views-{$videos[i].VID}">{$videos[i].viewnumber}</span>
															</div>
															<div class="col-xs-6 col-sm-2 col-md-1 col-lg-1 hidden-sm hidden-md hidden-xs">
																<div class="d-label"><i class="fa fa-star"></i></div>
																{$videos[i].fav_num}														
															</div>
														</div>
													</div>
												</div>
												<div class="clearfix"></div>
												<div class="item-actions">																									
													<div class="btn-group">
														<div class="btn-group">
															<a id="delete__video_{$videos[i].VID}" class="btn btn-success" data-toggle="dropdown" href="#" alt="Delete" title="Delete"><i class="fa fa-trash-o"></i></a>
															<ul class="dropdown-menu">
																<li><a id="delete_video_{$videos[i].VID}" href="#">Delete</a></li>
															</ul>
														</div>
														<a id="edit_video_{$videos[i].VID}" class="btn btn-success" href="#" alt="Edit" title="Edit"><i class="fa fa-pencil"></i></a>

															<div class="btn-group">
																<a id="thumb__video_{$videos[i].VID}" class="btn btn-success" data-toggle="dropdown" href="#" alt="Thumbanils" title="Thumbanils"><i class="fa fa-picture-o"></i></a>
																<ul class="dropdown-menu">
																{if $videos[i].embed_code == ''}																	
																	<li><a id="thumb_video_{$videos[i].VID}" href="#" data-processing="0">Regenerate</a></li>
																{/if}																		
																	<li><a id="thumbadv_video_{$videos[i].VID}" href="#" data-type="{if $videos[i].embed_code == ''}uploaded{else}embedded{/if}">Advanced</a></li>
																</ul>
															</div>
															{if $videos[i].embed_code == ''}																	
															<a id="duration_video_{$videos[i].VID}" class="btn btn-success" href="#" alt="Duration" title="Duration" data-processing="0"><i class="fa fa-clock-o"></i></a>
															{/if}

														{if $videos[i].active == '1'}
															<a id="status_video_{$videos[i].VID}" class="btn btn-success" href="#" alt="Suspend" title="Suspend" data-processing="0" data-status="1"><i class="fa fa-times"></i></a>
														{else}
															<a id="status_video_{$videos[i].VID}" class="btn btn-success" href="#" alt="Activate" title="Activate" data-processing="0" data-status="0"><i class="fa fa-check"></i></a>
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
										No Videos Found
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
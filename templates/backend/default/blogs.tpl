	{include file="blog_edit.tpl"}
	{include file="comments.tpl"}	
	{include file="blog_view.tpl"}
	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Blogs - <span class="semi-bold">Manage Blogs</span></h3>
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
								<form class="form-no-horizontal-spacing search-filters" name="search_blogs" method="POST" action="blogs.php?m=all">
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
											<div class="filter col-xs-12 col-sm-6 col-md-4">
												<div class="form-group">
													<input type="text"  id="filter_content" name="content" value="{$option.content}" class="form-control {if $option.content}filter-active{/if}" placeholder="Content">
													<i id="filter_remove_content" class="fa fa-times remove-filter" {if !$option.content}style="display:none"{/if}></i>
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
										</div>
									</div>
									<input id="sort" name="sort" type="hidden" value={$option.sort}>
									<input id="order" name="order" type="hidden" value={$option.order}>
									<input id="display" name="display" type="hidden" value={$option.display}>

									<div class="pull-left">
										<div class="btn-group"> <a class="btn dropdown-toggle btn-demo-space" data-toggle="dropdown" href="#">Order by <span id="sort_items">{if $option.sort == 'b.title'}Title{elseif $option.sort == 'b.content'}Content{elseif $option.sort == 'b.adddate'}Date{elseif $option.sort == 'b.total_views'}Views{elseif $option.sort == 'b.total_comments'}Comments{else}ID{/if}</span> <span class="caret"></span> </a>
											<ul class="dropdown-menu">
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'ID'; document.getElementById('sort').value = 'b.BID'" >ID</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Title'; document.getElementById('sort').value = 'b.title'" >Title</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Content'; document.getElementById('sort').value = 'b.content'" >Content</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Date'; document.getElementById('sort').value = 'b.adddate'" >Date</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Views'; document.getElementById('sort').value = 'b.total_views'" >Views</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Comments'; document.getElementById('sort').value = 'b.total_comments'" >Comments</a></li>
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
										<button type="submit" name="search_blogs" class="btn btn-success btn-cons btn-icon m-r-0"><i class="fa fa-search"></i></button>									
									</div>
									<div class="clearfix"></div>
								</form>
							</div>
						</div>
						<!-- END SEARCH FILTERS -->
						<div class="row">
							<div class="col-xs-12">
								<div>
									 {if $total_blogs >= 1}
										<form class="form-no-horizontal-spacing" name="blog_select" method="post" id="blog_select" action="">
										<div>
											<input type="submit" name="delete_selected_blogs" value="Delete" class="btn btn-danger btn-cons" onClick="javascript:return confirm('Are you sure you want to delete all selected blogs?');">
											<input type="submit" name="suspend_selected_blogs" value="Suspend" class="btn btn-white btn-cons" onClick="javascript:return confirm('Are you sure you want to suspend all selected blogs?');">
											<input type="submit" name="approve_selected_blogs" value="Approve" class="btn btn-white btn-cons" onClick="javascript:return confirm('Are you sure you want to approve all selected blogs?');">
										</div>
										<div class="s-pagination">{$paging}</div>
										<div class="checkbox check-default">
											<input id="check_all_blogs" name="check_all_blogs" type="checkbox" id="blog_check_all">
											<label for="check_all_blogs" style="margin: 0 0 15px 10px !important;">Select All</label>
											<code class="text-info hidden-xs hidden-sm pull-right">Use CHECK -> SHIFT + CHECK to select multiple blogs.</code>
										</div>
										{section name=i loop=$blogs}
											<div id="item-{$blogs[i].BID}" class="item-main-container small-thumb">
												<div class="item-col-left">
													<div class="item-main">
														<div class="item-select" unselectable="on" onselectstart="return false;" onmousedown="return false;">
															<div class="checkbox check-default">
																<input name="blog_id_checkbox_{$blogs[i].BID}" id="blog_checkbox_{$blogs[i].BID}" type="checkbox" class="select-multiple">
																<label for="blog_checkbox_{$blogs[i].BID}" style="margin: 0 0 15px 0 !important;"></label>
															</div>												
														</div>
														<div class="item-thumb">
															<div class="thumb-overlay">														
																<a id="view_blog_{$blogs[i].BID}" href="#">
																	<img id="thumb-{$blogs[i].BID}" src="{$baseurl}/templates/backend/default/assets/img/blog.png" class="img-responsive">
																</a>
																<div class="item-id">
																	<b>ID</b> {$blogs[i].BID}
																</div>
																<div id="private-{$blogs[i].BID}">
																	{if $blogs[i].content == 'private'}<div class="item-private">PRIVATE</div>{/if}
																</div>
																<div id="photos-loading-{$blogs[i].BID}" class="thumbnails-loading" style="display: none"><i class="loader"></i></div>
															</div>												
														</div>
													</div>
												</div>
												<div class="item-col-right">
													<div class="item-details">
														<div class="item-title">
															<a id="view_blog_{$blogs[i].BID}_" href="#"><span id="title-{$blogs[i].BID}">{$blogs[i].title|escape:'html'}</span></a>
														</div>
														<div class="row">						
															<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
																<div class="d-label">User</div>
																<a href="users.php?m=all&all=1&UID={$blogs[i].UID}" class="text-info">{$blogs[i].username}</a>															
															</div>
															<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
																<div class="d-label">Status</div>
																<span id="status-{$blogs[i].BID}">
																	{if $blogs[i].status == 1}
																		<span class="text-green" alt="Active" title="Active">Active</span>
																	{else}
																		<span class="text-red" alt="Inactive" title="Inactive">Inactive</span>
																	{/if}
																</span>
															</div>
															<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
																<div class="d-label">Date</div>
																{$blogs[i].adddate|date_format}													
															</div>
															<div class="col-xs-4 col-sm-4 col-md-1 col-lg-1">
																<div class="d-label"><i class="fa fa-comments"></i></div>
																{if $blogs[i].total_comments > 0}
																	<a id="comments_Blog_{$blogs[i].BID}" href="#" class="text-info">{$blogs[i].total_comments}</a>
																{else}
																	<span class="text-muted">{$blogs[i].total_comments}</span>
																{/if}																
															</div>
															<div class="col-xs-4 col-sm-4 col-md-1 col-lg-1">
																<div class="d-label"><i class="fa fa-eye"></i></div>
																<span id="views-{$blogs[i].BID}">{$blogs[i].total_views}</span>
															</div>
															<div class="col-xs-4 col-sm-4 col-md-1 col-lg-1">
																<div class="d-label"><i class="fa fa-link"></i></div>
																{$blogs[i].total_links}
															</div>
														</div>
													</div>
												</div>
												<div class="clearfix"></div>
												<div class="item-actions">																									
													<div class="btn-group">
														<div class="btn-group">
															<a id="delete__blog_{$blogs[i].BID}" class="btn btn-success" data-toggle="dropdown" href="#" alt="Delete" title="Delete"><i class="fa fa-trash-o"></i></a>
															<ul class="dropdown-menu">
																<li><a id="delete_blog_{$blogs[i].BID}" href="#">Delete</a></li>
															</ul>
														</div>
														<a id="edit_blog_{$blogs[i].BID}" class="btn btn-success" href="#" alt="Edit" title="Edit"><i class="fa fa-pencil"></i></a>
														{if $blogs[i].status == '1'}
															<a id="status_blog_{$blogs[i].BID}" class="btn btn-success" href="#" alt="Suspend" title="Suspend" data-processing="0" data-status="1"><i class="fa fa-times"></i></a>
														{else}
															<a id="status_blog_{$blogs[i].BID}" class="btn btn-success" href="#" alt="Activate" title="Activate" data-processing="0" data-status="0"><i class="fa fa-check"></i></a>
														{/if}																	
													</div>
												
												</div>												
											</div>
										{/section}
											

										<div class="s-pagination">{$paging}</div>										
										</form>
									{else}
									<div class="row">
										<div class="col-xs-12">
											<div class="alert alert-info">
												<button class="close" data-dismiss="alert"></button>
												No Blogs Found
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
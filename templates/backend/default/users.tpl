	{include file="user_edit.tpl"}
	{include file="user_thumbnail.tpl"}
	{include file="comments.tpl"}	
	{include file="user_view.tpl"}
	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Users - <span class="semi-bold">Manage Users</span></h3>
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
								<form class="form-no-horizontal-spacing search-filters" name="search_users" method="POST" action="users.php?m={$module}">
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
													<input type="text"  id="filter_name" name="name" value="{$option.name}" class="form-control {if $option.name}filter-active{/if}" placeholder="First Name or Last Name">
													<i id="filter_remove_name" class="fa fa-times remove-filter" {if !$option.name}style="display:none"{/if}></i>
												</div>										
											</div>
											<div class="filter col-xs-12 col-sm-6 col-md-4">
												<div class="form-group">
													<input type="text"  id="filter_country" name="country" value="{$option.country}" class="form-control {if $option.country}filter-active{/if}" placeholder="Country">
													<i id="filter_remove_country" class="fa fa-times remove-filter" {if !$option.country}style="display:none"{/if}></i>
												</div>										
											</div>
											<div class="filter col-xs-12 col-sm-6 col-md-4">
												<div class="form-group">
													<select id="filter_gender" name="gender" style="width:100%">
														<option value="">Gender</option>
														<option value="male"{if $option.gender == 'male'} selected="selected"{/if}>Male</option>
														<option value="female"{if $option.gender == 'female'} selected="selected"{/if}>Female</option>
													</select>												
												</div>
											</div>											
											<div class="filter col-xs-12 col-sm-6 col-md-4">
												<div class="form-group">
													<select id="filter_status" name="status" style="width:100%">
														<option value="">Status</option>
														<option value="Active"{if $option.status == 'Active'} selected="selected"{/if}>Active</option>
														<option value="Inactive"{if $option.status == 'Inactive'} selected="selected"{/if}>Inactive</option>
													</select>												
												</div>
											</div>
											<div class="filter col-xs-12 col-sm-6 col-md-4">
												<div class="form-group">
													<select id="filter_emailverified" name="emailverified" style="width:100%">
														<option value="">Email Confirmation</option>
														<option value="yes"{if $option.emailverified == 'yes'} selected="selected"{/if}>Verified</option>
														<option value="no"{if $option.emailverified == 'no'} selected="selected"{/if}>Not Verified</option>
													</select>												
												</div>
											</div>
											<div class="filter col-xs-12 col-sm-6 col-md-4">
												<div class="form-group">
													<select id="filter_premium" name="premium" style="width:100%">
														<option value="">Type</option>
														<option value="0"{if $option.premium == '0'} selected="selected"{/if}>Free</option>														
														<option value="1"{if $option.premium == '1'} selected="selected"{/if}>Premium</option>
													</select>												
												</div>
											</div>											
										</div>
									</div>
									<input id="sort" name="sort" type="hidden" value={$option.sort}>
									<input id="order" name="order" type="hidden" value={$option.order}>
									<input id="display" name="display" type="hidden" value={$option.display}>

									<div class="pull-left">
										<div class="btn-group"> <a class="btn dropdown-toggle btn-demo-space" data-toggle="dropdown" href="#">Order by <span id="sort_items">{if $option.sort == 'username'}Username{elseif $option.sort == 'email'}Email{elseif $option.sort == 'addtime'}Join Date{elseif $option.sort == 'logintime'}Last Login{elseif $option.sort == 'country'}Country{elseif $option.sort == 'profile_viewed'}Profile Views{else}ID{/if}</span> <span class="caret"></span> </a>
											<ul class="dropdown-menu">
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'ID'; document.getElementById('sort').value = 'UID'" >ID</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Username'; document.getElementById('sort').value = 'username'" >Username</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Email'; document.getElementById('sort').value = 'email'" >Email</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Join Date'; document.getElementById('sort').value = 'addtime'" >Join Date</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Last Login'; document.getElementById('sort').value = 'logintime'" >Last Login</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Country'; document.getElementById('sort').value = 'country'" >Country</a></li>																			
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Profile Views'; document.getElementById('sort').value = 'profile_viewed'" >Profile Views</a></li>									
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
										<button type="submit" name="search_users" class="btn btn-success btn-cons btn-icon m-r-0"><i class="fa fa-search"></i></button>									
									</div>
									<div class="clearfix"></div>
								</form>
							</div>
						</div>
						<!-- END SEARCH FILTERS -->
						<div class="row">
							<div class="col-xs-12">
								<div>
									 {if $total_users >= 1}
										<form class="form-no-horizontal-spacing" name="user_select" method="post" id="user_select" action="">
										<div>
											<input type="submit" name="delete_selected_users" value="Delete" class="btn btn-danger btn-cons" onClick="javascript:return confirm('Are you sure you want to delete all selected users?');">
											<input type="submit" name="suspend_selected_users" value="Suspend" class="btn btn-white btn-cons" onClick="javascript:return confirm('Are you sure you want to suspend all selected users?');">
											<input type="submit" name="approve_selected_users" value="Approve" class="btn btn-white btn-cons" onClick="javascript:return confirm('Are you sure you want to approve all selected users?');">
										</div>
										<div class="s-pagination">{$paging}</div>										
										<div class="checkbox check-default">
											<input id="check_all_users" name="check_all_users" type="checkbox" id="user_check_all">
											<label for="check_all_users" style="margin: 0 0 15px 10px !important;">Select All</label>
											<code class="text-info hidden-xs hidden-sm pull-right">Use CHECK -> SHIFT + CHECK to select multiple users.</code>
										</div>
										{section name=i loop=$users}
											<div id="item-{$users[i].UID}" class="item-main-container small-thumb">
												<div class="item-col-left">
													<div class="item-main">
														<div class="item-select" unselectable="on" onselectstart="return false;" onmousedown="return false;">
															<div class="checkbox check-default">
																<input name="user_id_checkbox_{$users[i].UID}" id="user_checkbox_{$users[i].UID}" type="checkbox" class="select-multiple">
																<label for="user_checkbox_{$users[i].UID}" style="margin: 0 0 15px 0 !important;"></label>
															</div>												
														</div>
														<div class="item-thumb">
															<div class="thumb-overlay">														
																<a id="view_user_{$users[i].UID}" href="#">
																	<img id="thumb-{$users[i].UID}" src="{$baseurl}/media/users/{if $users[i].photo == ''}nopic-{$users[i].gender}.gif{else}{$users[i].photo}{/if}" class="img-responsive">
																</a>
																<div class="item-id">
																	<b>ID</b> {$users[i].UID}
																</div>
																<div class="item-flag">
																	{if $users[i].country != ''}
																		<img id="flag-{$users[i].UID}" src="{$baseurl}/templates/backend/default/assets/img/flags/{$users[i].country|replace:' ':'-'|replace:'\'':''}.png"  onError="this.src='{$baseurl}/templates/backend/default/assets/img/flags/NoCountry.png'" title="{$users[i].country}">
																	{else}
																		<img id="flag-{$users[i].UID}" src="{$baseurl}/templates/backend/default/assets/img/flags/NoCountry.png">
																	{/if}														
																</div>
																<div id="premium-{$users[i].UID}">
																	{if $users[i].premium == '1'}<div class="item-premium" title="Premium Account">P</div>{/if}
																</div>
																<div id="photos-loading-{$users[i].UID}" class="thumbnails-loading" style="display: none"><i class="loader"></i></div>
															</div>												
														</div>
													</div>
												</div>
												<div class="item-col-right">
													<div class="item-details">
														<div class="item-title">
															<a id="view_user_{$users[i].UID}_" href="#" class="text-info">{$users[i].username}</a>
														</div>
														<div class="row">						
															<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
																<div class="d-label">Status</div>
																<span id="status-{$users[i].UID}">
																	{if $users[i].account_status == 'Active'}
																		<span class="text-green" alt="Active" title="Active">Active</span>
																	{else}
																		<span class="text-red" alt="Inactive" title="Inactive">Inactive</span>
																	{/if}
																</span>
															</div>
															<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
																<div class="d-label">Join Date</div>
																{$users[i].addtime|date_format}
															</div>
															<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
																<div class="d-label">Last Login</div>
																{$users[i].logintime|date_format}									
															</div>
															<div class="col-xs-4 col-sm-4 col-md-1 col-lg-1">																
																<div class="d-label"><i class="fa fa-comments" title="Wall Comments"></i></div>
																{insert name=comment_count assign=total_comments UID=$users[i].UID}
																{if $total_comments > 0}
																	<a id="comments_User_{$users[i].UID}" href="#" class="text-info">{$total_comments}</a>
																{else}
																	<span class="text-muted">{$total_comments}</span>
																{/if}																
															</div>
															<div class="col-xs-4 col-sm-4 col-md-1 col-lg-1">
																<div class="d-label"><i class="fa fa-eye" title="Profile Views"></i></div>
																<span id="views-{$users[i].UID}">{$users[i].profile_viewed}</span>
															</div>
															<div class="col-xs-4 col-sm-4 col-md-1 col-lg-1">
																{insert name=video_count assign=vdo UID=$users[i].UID}
																<div class="d-label"><i class="fa fa-video-camera" title="Owned Videos"></i></div>
																{if $vdo > 0}
																	<a id="videos_User_{$users[i].UID}" href="videos.php?m=all&UID={$users[i].UID}" class="text-info">{$vdo}</a>
																{else}
																	<span class="text-muted">{$vdo}</span>
																{/if}
															</div>
														</div>
													</div>
												</div>
												<div class="clearfix"></div>
												<div class="item-actions">																									
													<div class="btn-group">
														<div class="btn-group">
															<a id="delete__user_{$users[i].UID}" class="btn btn-success" data-toggle="dropdown" href="#" alt="Delete" title="Delete"><i class="fa fa-trash-o"></i></a>
															<ul class="dropdown-menu">
																<li><a id="delete_user_{$users[i].UID}" href="#">Delete</a></li>
															</ul>
														</div>
														<a id="edit_user_{$users[i].UID}" class="btn btn-success" href="#" alt="Edit" title="Edit"><i class="fa fa-pencil"></i></a>
														<a id="thumb_user_{$users[i].UID}" class="btn btn-success" href="#" alt="Thumbnail" title="Thumbnail"><i class="fa fa-picture-o"></i></a>
														{if $users[i].account_status == 'Active'}
															<a id="status_user_{$users[i].UID}" class="btn btn-success" href="#" alt="Suspend" title="Suspend" data-processing="0" data-status="1"><i class="fa fa-times"></i></a>
														{else}
															<a id="status_user_{$users[i].UID}" class="btn btn-success" href="#" alt="Activate" title="Activate" data-processing="0" data-status="0"><i class="fa fa-check"></i></a>
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
												No Users Found
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
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
						<h4>Bans <span class="semi-bold"></span></h4>
					</div>
					<div class="grid-body no-border">
						<div class="row">
							<div class="col-xs-12">
								<form class="form-no-horizontal-spacing form-grey" name="add_ban" method="POST" action="index.php?m=bans&a=add">
									<div class="row">
										<div class="col-xs-12 col-sm-6 col-md-4">
											<div class="form-group">
												<input type="text" name="add_ip" value="{$ban_ip}" class="form-control {if $err.add_ip}error{/if}" placeholder="IP">
											</div>
										</div>
										<div class="col-xs-12 col-sm-6 col-md-8">
											<div class="form-group">
												<input type="submit" name="add_ban" value="Add Ban" class="btn btn-success btn-cons btn-icon m-0 pull-right">
												<div class="clearfix"></div>
											</div>
										</div>
									</div>			
								</form>
								<form class="form-no-horizontal-spacing search-filters" name="search_bans" method="POST" action="index.php?m=bans">
									<div class="filters">
										<div class="row">
											<div class="filter col-xs-12 col-sm-6 col-md-4">
												<div class="form-group">
													<input type="text" id="filter_ip" name="ip" value="{$option.ip}" class="form-control {if $option.ip}filter-active{/if}" placeholder="IP">
													<i id="filter_remove_ip" class="fa fa-times remove-filter" {if !$option.ip}style="display:none"{/if}></i>
												</div>
											</div>										
										</div>
									</div>
									<input id="sort" name="sort" type="hidden" value={$option.sort}>
									<input id="order" name="order" type="hidden" value={$option.order}>
									<input id="display" name="display" type="hidden" value={$option.display}>

									<div class="pull-left">
										<div class="btn-group"> <a class="btn dropdown-toggle btn-demo-space" data-toggle="dropdown" href="#">Order by <span id="sort_items">{if $option.sort == 'ban_ip'}IP{elseif $option.sort == 'ban_date'}Ban Date{else}ID{/if}</span> <span class="caret"></span> </a>
											<ul class="dropdown-menu">
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'ID'; document.getElementById('sort').value = 'ban_id'" >ID</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'IP'; document.getElementById('sort').value = 'ban_ip'" >IP</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Ban Date'; document.getElementById('sort').value = 'ban_date'" >Ban Date</a></li>

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
										<button type="submit" name="search_bans" class="btn btn-success btn-cons btn-icon m-r-0"><i class="fa fa-search"></i></button>									
									</div>
									<div class="clearfix"></div>
								</form>	
							</div>
						</div>
						<!-- END SEARCH FILTERS -->
						<div class="row">
							<div class="col-xs-12">
								<div>
									{if $total_bans >= 1}
										<div class="s-pagination">{$paging}</div>
										<table class="table no-more-tables m-0">
											<thead>
												<tr>
													<th style="width:5%">ID</th>
													<th>IP</th>
													<th>USERNAME</th>
													<th>DATE</th>												
													<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
												{section name=i loop=$bans}
												{insert name=user_byip assign=uname ip=$bans[i].ban_ip}
												<tr>
													<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">{$bans[i].ban_id}</td>
													<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">{$bans[i].ban_ip}</td>
													<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
														{if $uname.UID} 
															<a href="users.php?m=all&all=1&UID={$uname.UID}" class="text-info">{$uname.username}</a>
														{else}
															<span class="text-danger">{$uname.username}</span>
														{/if}
													</td>
													<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">{$bans[i].ban_date}</td>												
													<td class="action {if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
														<div>
															<a class="btn btn-danger btn-xs btn-mini" href="index.php?m=bans{if $page !=''}&page={$page}{/if}&a=delete&BID={$bans[i].ban_id}" onClick="javascript:return confirm('Are you sure you want to remove this ban?');">REMOVE</a>
														</div>
													</td>									
												</tr>
												{/section}
											</tbody>											
										</table>										
										<div class="s-pagination">{$paging}</div>
									{else}
									<div class="row">
										<div class="col-xs-12">
											<div class="alert alert-info">
												<button class="close" data-dismiss="alert"></button>
												No Bans Found
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
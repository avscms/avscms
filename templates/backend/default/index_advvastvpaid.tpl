	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Settings - <span class="semi-bold">Advertising</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->															
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>In-Player Vast-Vpaid <span class="semi-bold">Ads</span></h4>
					</div>
					<div class="grid-body no-border">
						<div class="row">
							<div class="col-xs-12">
								<form class="form-no-horizontal-spacing search-filters" name="search_advertise" method="POST" action="index.php?m=advvastvpaid">
									<input id="sort" name="sort" type="hidden" value={$option.sort}>
									<input id="order" name="order" type="hidden" value={$option.order}>
									<input id="display" name="display" type="hidden" value={$option.display}>
									<div class="pull-left">
										<div class="btn-group"> <a class="btn dropdown-toggle btn-demo-space" data-toggle="dropdown" href="#">Order by <span id="sort_items">{if $option.sort == 'name'}Name{elseif $option.sort == 'views'}Views{elseif $option.sort == 'clicks'}Clicks{elseif $option.sort == 'status'}Status{else}ID{/if}</span> <span class="caret"></span> </a>
											<ul class="dropdown-menu">
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'ID'; document.getElementById('sort').value = 'id'" >ID</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Name'; document.getElementById('sort').value = 'name'" >Name</a></li>											
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Views'; document.getElementById('sort').value = 'views'" >Views</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Clicks'; document.getElementById('sort').value = 'clicks'" >Clicks</a></li>												
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Status'; document.getElementById('sort').value = 'status'" >Status</a></li>
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
										<button type="submit" name="search_vast_vpaid" class="btn btn-success btn-cons btn-icon m-r-0"><i class="fa fa-search"></i></button>									
									</div>
									<div class="clearfix"></div>
								</form>	
							</div>
						</div>
						<!-- END SEARCH FILTERS -->
						<div class="row">
							<div class="col-xs-12">
								<div>
									{if $advs_total >= 1}
										<div class="s-pagination">{$paging}</div>									
										<table class="table no-more-tables m-0">
											<thead>
												<tr>
													<th style="width:5%">ID</th>
													<th>NAME</th>
													<th>DEVICE</th>
													<th>VIEWS</th>
													<th>CLICKS</th>
													<th>CLICK RATE</th>
													<th>STATUS</th>												
													<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
												{section name=i loop=$advs}					
												<tr>
													<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
														{$advs[i].id}
													</td>
													<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
														<a href="index.php?m=advvastvpaidedit&AID={$advs[i].id}">{$advs[i].name|escape:'html'}</a>
													</td>
													<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
														<a href="{$advs[i].adv_url}" target="_blank">{if $advs[i].device == 'd'}Desktop{elseif $advs[i].device == 'm'}Mobile{else}All{/if}</a>
													</td>													
													<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
														{$advs[i].views}
													</td>													
													<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
														{$advs[i].clicks}
													</td>													
													<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
														{math equation="(( z * x ) / z )" x=$advs[i].views y=$advs[i].clicks z=100 format="%.2f"}%
													</td>													
													<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
														{if $advs[i].status == '1'}<span class="text-success">Active</span>{else}<span class="text-danger">Inactive</span>{/if}
													</td>
													<td class="action {if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
														<div>
															<a class="btn btn-success btn-xs btn-mini" href="index.php?m=advvastvpaidedit&AID={$advs[i].id}">EDIT</a>
															{if $advs[i].status == '1'}
																<a class="btn btn-danger btn-xs btn-mini" href="index.php?m=advvastvpaid{if $page !=''}&page={$page}{/if}&a=suspend&AID={$advs[i].id}" onClick="javascript:return confirm('Are you sure you want to suspend this advertising?');">SUSPEND</a>
															{else}
																<a class="btn btn-success btn-xs btn-mini" href="index.php?m=advvastvpaid{if $page !=''}&page={$page}{/if}&a=activate&AID={$advs[i].id}" onClick="javascript:return confirm('Are you sure you want to activate this advertising?');">ACTIVATE</a>
															{/if}
															<a class="btn btn-danger btn-xs btn-mini" href="index.php?m=advvastvpaid{if $page !=''}&page={$page}{/if}&a=delete&AID={$advs[i].id}" onClick="javascript:return confirm('Are you sure you want to delete this advertising?');">DELETE</a>															
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
												No Vast-Vpaid Ads Found
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
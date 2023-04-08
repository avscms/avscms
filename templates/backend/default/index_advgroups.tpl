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
						<h4>Ad <span class="semi-bold">Zones</span></h4>
					</div>
					<div class="grid-body no-border">
						<div class="row">
							<div class="col-xs-12">
								<form class="form-no-horizontal-spacing search-filters" name="search_advertise" method="POST" action="index.php?m=advgroups">
									<input id="sort" name="sort" type="hidden" value={$option.sort}>
									<input id="order" name="order" type="hidden" value={$option.order}>
									<div class="pull-left">
										<div class="btn-group"> <a class="btn dropdown-toggle btn-demo-space" data-toggle="dropdown" href="#">Order by <span id="sort_items">{if $option.sort == 'advgrp_name'}Name{elseif $option.sort == 'advgrp_status'}Status{else}ID{/if}</span> <span class="caret"></span> </a>
											<ul class="dropdown-menu">
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'ID'; document.getElementById('sort').value = 'advgrp_id'" >ID</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Name'; document.getElementById('sort').value = 'advgrp_name'" >Name</a></li>
												<li><a href="#" onClick="document.getElementById('sort_items').innerText = 'Status'; document.getElementById('sort').value = 'advgrp_status'" >Status</a></li>

											</ul>
										</div>									
										<div class="btn-group"> <a class="btn dropdown-toggle btn-demo-space" data-toggle="dropdown" href="#"><span id="order_items">{if $option.order == 'ASC'}Ascending{else}Descending{/if}</span> <span class="caret"></span> </a>
											<ul class="dropdown-menu">
												<li><a href="#" onClick="document.getElementById('order_items').innerText = 'Ascending'; document.getElementById('order').value = 'ASC'" >Ascending</a></li>
												<li><a href="#" onClick="document.getElementById('order_items').innerText = 'Descending'; document.getElementById('order').value = 'DESC'" >Descending</a></li>
											</ul>
										</div>									
									</div>
									<div class="pull-right">
										<button type="button" id="reset_search" name="reset_search" class="btn btn-white btn-cons btn-icon"><i class="fa fa-times"></i></button>									
										<button type="submit" name="search_advertise" class="btn btn-success btn-cons btn-icon m-r-0"><i class="fa fa-search"></i></button>									
									</div>
									<div class="clearfix"></div>
								</form>	
							</div>
						</div>
						<!-- END SEARCH FILTERS -->
						<div class="row">
							<div class="col-xs-12">
								<div>
									{if $advgroups}
										<table class="table no-more-tables m-0">
											<thead>
												<tr>
													<th style="width:5%">ID</th>
													<th>NAME</th>
													<th>SIZE</th>
													<th>ROTATE</th>
													<th>STATUS</th>												
													<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
												{section name=i loop=$advgroups}					
												<tr>
													<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">{$advgroups[i].advgrp_id}</td>
													<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
														<a href="index.php?m=advgroupedit&AGID={$advgroups[i].advgrp_id}">{$advgroups[i].advgrp_name}</a>
													</td>
													<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
														{$advgroups[i].adv_width}x{$advgroups[i].adv_height}
													</td>
													<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
														{if $advgroups[i].advgrp_rotate == '1'}Yes{else}No{/if}
													</td>
													<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
														{if $advgroups[i].advgrp_status == '1'}<span class="text-success">Active</span>{else}<span class="text-danger">Inactive</span>{/if}
													</td>													
													<td class="action {if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
														<div>
															<a class="btn btn-success btn-xs btn-mini" href="index.php?m=advgroupedit&AGID={$advgroups[i].advgrp_id}">EDIT</a>
															{if $advgroups[i].advgrp_status == '1'}
															<a class="btn btn-danger btn-xs btn-mini" href="index.php?m=advgroups&a=suspend&AGID={$advgroups[i].advgrp_id}">SUSPEND</a>
															{else}
															<a class="btn btn-success btn-xs btn-mini" href="index.php?m=advgroups&a=activate&AGID={$advgroups[i].advgrp_id}">ACTIVATE</a>
															{/if}															
														</div>
													</td>									
												</tr>
												{/section}
											</tbody>											
										</table>										
									{else}
									<div class="row">
										<div class="col-xs-12">
											<div class="alert alert-info">
												<button class="close" data-dismiss="alert"></button>
												No Groups Found
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
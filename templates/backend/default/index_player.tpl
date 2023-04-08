	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">  
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Settings - <span class="semi-bold">Player Profiles</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>Player <span class="semi-bold">Profiles</span></h4>
					</div>
					<div class="grid-body no-border">
						<div class="row">
							<div class="col-xs-12">
								<h3>All <span class="semi-bold">Profiles</span></h3>
								{if $profiles}
									<table class="table no-more-tables m-0">
										<thead>
											<tr>
												<th>NAME</th>
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody>
											{section name=i loop=$profiles}
											<tr>
												<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">{$profiles[i].profile}</td>
												<td class="action {if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
													<div>
														<a class="btn btn-success btn-xs btn-mini" href="index.php?m=playeredit&PID={$profiles[i].id}">EDIT</a>
													</div>
												</td>
											</tr>
											{/section}
										</tbody>											
									</table>										
								{else}
									<div class="alert alert-info">
										<button class="close" data-dismiss="alert"></button>
										No Profiles Available
									</div>								
								{/if}
							</div>
						</div>
					</div>
				</div>
			</div>			
			<!-- END PLACE PAGE CONTENT HERE -->
		</div>
	</div>
	<!-- END PAGE CONTAINER -->	
	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Videos - <span class="semi-bold">Conversion Queue</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->	

			<div class="col-md-12">
				<ul class="nav nav-tabs" id="tab-01">
					<li class="{if (($total_queue_fp == 0) && ($total_queue_sp == 0)) || ($total_queue_fp > 0)}active{/if}"><a href="#tab1"><b>1st</b> Pass {if $total_queue_fp > 0}&nbsp;<i class="fas fa-circle-notch fa-spin text-info" alt="Converting" title="Converting"></i>{/if}</a></li>
					<li class="{if ($total_queue_sp > 0) && ($total_queue_fp == 0)}active{/if}"><a href="#tab2"><b>2nd</b> Pass {if $total_queue_sp > 0}&nbsp;<i class="fas fa-circle-notch fa-spin text-info" alt="Converting" title="Converting"></i>{/if}</a></li>
				</ul>
				<div class="tab-content m-0">
					<div class="tab-pane {if (($total_queue_fp == 0) && ($total_queue_sp == 0)) || ($total_queue_fp > 0)}active{/if}" id="tab1">	
						<div class="col-12">
							<h4>Videos in queue / <b>Converting first format only (highest quality)</b></h4>
							{if $total_queue_fp > 0}
								<table class="table no-more-tables m-0">
									<thead>
										<tr>
											<th>ID</th>
											<th>USER</th>
											<th>SOURCE</th>
											<th>TITLE</th>
											<th>STATUS</th>
											<th>STARTED AGO</th>
											<th>UPLOADED</th>
											<th>ACTION</th>
										</tr>
									</thead>
									<tbody>
										{foreach from=$queue_fp item=q_fp name=ad_block}					
										<tr>										
											{insert name=uid_to_username assign=username uid=$q_fp.UID}
											<td class="{if $smarty.foreach.ad_block.iteration mod 2 == 1}grey{else}white{/if}">{$q_fp.VID}</td>
											<td class="{if $smarty.foreach.ad_block.iteration mod 2 == 1}grey{else}white{/if}"><a href="users.php?m=all&all=1&UID={$q_fp.UID}">{$username}</a></td>
											<td class="{if $smarty.foreach.ad_block.iteration mod 2 == 1}grey{else}white{/if}">{$q_fp.video_name}</td>
											<td class="{if $smarty.foreach.ad_block.iteration mod 2 == 1}grey{else}white{/if}"><span alt="{$q_fp.title}" title="{$q_fp.title}">{$q_fp.title|escape|truncate:20}</span></td>
											<td class="{if $smarty.foreach.ad_block.iteration mod 2 == 1}grey{else}white{/if}">{if $q_fp.status == '1'}<i class="fas fa-circle-notch fa-spin text-info" alt="Converting" title="Converting"></i>{else}<i class="fas fa-hourglass-half" alt="Waiting" title="Waiting"></i>{/if}</td>
											<td class="{if $smarty.foreach.ad_block.iteration mod 2 == 1}grey{else}white{/if}">{$q_fp.start|queue}</td>
											<td class="{if $smarty.foreach.ad_block.iteration mod 2 == 1}grey{else}white{/if}">{$q_fp.addtime|date_format:"%b %d, %Y %I:%M %p"}</td>
											<td class="action {if $smarty.foreach.ad_block.iteration mod 2 == 1}grey{else}white{/if}">			
												<a class="btn btn-danger btn-small" href="videos.php?m=queue&a=delete&VID={$q_fp.VID}" onClick="javascript:return confirm('Are you sure you want to delete this video from queue?');" title="Remove from queue" style="margin: 1px 5px 1px 0;">REMOVE FROM Q</a><a class="btn btn-danger btn-small" href="videos.php?m=queue&a=vdelete&VID={$q_fp.VID}" onClick="javascript:return confirm('Are you sure you want to delete this video and remove it from queue?');" title="Remove from queue" style="margin: 1px 5px 1px 0;">DELETE VIDEO</a>
											</td>
										</tr>
										{/foreach}
									</tbody>
								</table>
							{else}
								<div class="alert alert-info">
									<button class="close" data-dismiss="alert"></button>
									No videos found.
								</div>
							{/if}						
						</div>				
						<div class="clearfix"></div>					
					</div>
					<div class="tab-pane {if ($total_queue_sp > 0) && ($total_queue_fp == 0)}active{/if}" id="tab2">
						<h4>Videos in queue / <b>Converting remaining formats</b></h4>
						{if $total_queue_sp > 0}
							<table class="table no-more-tables m-0">
								<thead>
									<tr>
										<th>ID</th>
										<th>USER</th>
										<th>SOURCE</th>
										<th>TITLE</th>
										<th>STATUS</th>
										<th>STARTED AGO</th>
										<th>UPLOADED</th>
										<th>ACTION</th>
									</tr>
								</thead>
								<tbody>
									{foreach from=$queue_sp item=q_sp name=ad_block}					
									<tr>
										{insert name=uid_to_username assign=username uid=$q_sp.UID}
										<td class="{if $smarty.foreach.ad_block.iteration mod 2 == 1}grey{else}white{/if}">{$q_sp.VID}</td>
										<td class="{if $smarty.foreach.ad_block.iteration mod 2 == 1}grey{else}white{/if}"><a href="users.php?m=all&all=1&UID={$q_sp.UID}">{$username}</a></td>
										<td class="{if $smarty.foreach.ad_block.iteration mod 2 == 1}grey{else}white{/if}">{$q_sp.video_name}</td>
										<td class="{if $smarty.foreach.ad_block.iteration mod 2 == 1}grey{else}white{/if}"><span alt="{$q_sp.title}" title="{$q_sp.title}">{$q_sp.title|escape|truncate:20}</span></td>
										<td class="{if $smarty.foreach.ad_block.iteration mod 2 == 1}grey{else}white{/if}">{if $q_sp.status == '1'}<i class="fas fa-circle-notch fa-spin text-info" alt="Converting" title="Converting"></i>{else}<i class="fas fa-hourglass-half" alt="Waiting" title="Waiting"></i>{/if}</td>
										<td class="{if $smarty.foreach.ad_block.iteration mod 2 == 1}grey{else}white{/if}">{$q_sp.start|queue}</td>
										<td class="{if $smarty.foreach.ad_block.iteration mod 2 == 1}grey{else}white{/if}">{$q_sp.addtime|date_format:"%b %d, %Y %I:%M %p"}</td>
										<td class="action {if $smarty.foreach.ad_block.iteration mod 2 == 1}grey{else}white{/if}">			
											<a class="btn btn-danger btn-small" href="videos.php?m=queue&a=delete&VID2={$q_sp.VID}" onClick="javascript:return confirm('Are you sure you want to delete this video from queue?');" title="Remove from queue" style="margin: 1px 5px 1px 0;">REMOVE FROM Q</a><a class="btn btn-danger btn-small" href="videos.php?m=queue&a=vdelete&VID2={$q_sp.VID}" onClick="javascript:return confirm('Are you sure you want to delete this video and remove it from queue?');" title="Remove from queue" style="margin: 1px 5px 1px 0;">DELETE VIDEO</a>
										</td>
									</tr>
									{/foreach}
								</tbody>
							</table>
						{else}
							<div class="row">
								<div class="col-xs-12">
									<div class="alert alert-info">
										<button class="close" data-dismiss="alert"></button>
										No videos found.
									</div>
								</div>
							</div>
						{/if}
						<div class="clearfix"></div>
					</div>
				</div>			
			</div>			
			<!-- END PLACE PAGE CONTENT HERE -->
		</div>
	</div>
	<!-- END PAGE CONTAINER -->	
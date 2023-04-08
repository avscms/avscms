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
						{insert name=get_video_title assign=video_title VID=$VID}
						<h4>Video {$VID}: <span class="semi-bold">{$video_title|escape:'html'}</span></h4>
					</div>
					<div class="grid-body no-border">
						<div class="row">
							<div class="col-xs-12">							
								<h3>All <span class="semi-bold">Comments</span></h3>
								{if $comments}
									<div class="s-pagination">{$paging}</div>								
									<table class="table no-more-tables m-0">
										<thead>
											<tr>
												<th style="width:5%">ID</th>
												<th>COMMENT</th>
												<th>USER</th>
												<th>DATE</th>
												<th>ACTIONS</th>
											</tr>
										</thead>
										<tbody>
											{section name=i loop=$comments}
											<tr>
												<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
													{$comments[i].CID}
												</td>
												<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
													{$comments[i].comment|escape:'html'|nl2br}
												</td>
												<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
													<a href="users.php?m=view&UID={$comments[i].UID}" class="text-info">{$comments[i].username}</a>
												</td>
												<td class="action {if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
													{$comments[i].addtime|date_format}
												</td>
												<td class="action {if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
													<a class="btn btn-success btn-xs btn-mini" href="videos.php?m=commentedit&VID={$VID}&COMID={$comments[i].CID}">EDIT</a>
													<a class="btn btn-danger btn-xs btn-mini" href="videos.php?m=comments&a=delete&VID={$VID}&COMID={$comments[i].CID}" onClick="javascript:return confirm('Are you sure you want to delete this comment?');">DELETE</a>
												</td>
											</tr>
											{/section}
										</tbody>											
									</table>
									<div class="s-pagination">{$paging}</div>
								{else}
									<div class="alert alert-info">
										<button class="close" data-dismiss="alert"></button>
										No Comments Available
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
	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">  
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Blogs - <span class="semi-bold">Requests / Spam</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>Blog <span class="semi-bold">Comments</span></h4>						
					</div>				
					<div class="grid-body no-border">
						<div class="row">
							<div class="col-xs-12">
								{if $total_spam >= 1 && $comments}
									<div class="s-pagination">{$paging}</div>
									<table class="table no-more-tables m-0">
										<thead>
											<tr>
												<th>ID</th>
												<th>COMMENT</th>
												<th>USER</th>
												<th>REPORTER</th>
												<th>REPORT DATE</th>
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
												<span class="text-danger">{$comments[i].comment|nl2br}</span>
											</td>
											<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
												<a href="users.php?m=view&UID={$comments[i].UID}" class="text-info">{$comments[i].username}</a>
											</td>
											<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
												{insert name=uid_to_name assign=uname uid=$comments[i].RID}
												<a href="users.php?m=view&UID={$comments[i].RID}" class="text-warning">{$uname}</a>
											</td>
											<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
												{$comments[i].add_time|date_format}
											</td>
											<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">												
												<a class="btn btn-success btn-xs btn-mini" href="blogs.php?m=commentedit&VID={$VID}&COMID={$comments[i].CID}">EDIT</a>
												<a class="btn btn-danger btn-xs btn-mini" href="blogs.php?m=spam{if $page !=''}&page={$page}{/if}&a=delete&CID={$comments[i].CID}" onClick="javascript:return confirm('Are you sure you want to delete this comment?');">DELETE</a>
												<a class="btn btn-warning btn-xs btn-mini" href="blogs.php?m=spam{if $page !=''}&page={$page}{/if}&a=unspam&SID={$comments[i].spam_id}" onClick="javascript:return confirm('Are you sure you want to unspam this comment?');">UNSPAM</a><br>
											</td>
										</tr>
										{/section}
										</tbody>
									</table>
									<div class="s-pagination">{$paging}</div>										
								{else}
									<div class="alert alert-info">
										<button class="close" data-dismiss="alert"></button>
										No Spam Reported
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
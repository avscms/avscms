	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">  
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Settings - <span class="semi-bold">Email Templates</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>Email <span class="semi-bold">Templates</span></h4>
					</div>
					<div class="grid-body no-border">
						<div class="row">
							<div class="col-xs-12">
								<h3>All <span class="semi-bold">Templates</span></h3>
								{if $emails}
									<table class="table no-more-tables m-0">
										<thead>
											<tr>
												<th style="width:5%">ID</th>
												<th>SUBJECT</th>
												<th>COMMENTS</th>
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody>
											{section name=i loop=$emails}
											<tr>
												<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">{$emails[i].email_id}</td>
												<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">{$emails[i].email_subject}</td>
												<td class="{if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">{$emails[i].comment}</td>
												<td class="action {if $smarty.section.i.index mod 2 == 0}grey{else}white{/if}">
													<div>
													<a class="btn btn-success btn-xs btn-mini" href="index.php?m=emailedit&EID={$emails[i].email_id}">EDIT</a>
													<a class="btn btn-danger btn-xs btn-mini" href="index.php?m=emails&a=delete&EID={$emails[i].email_id}" onClick="javascript:return confirm('Are you sure you want to delete this email?');">DELETE</a>
													</div>
												</td>									
											</tr>
											{/section}
										</tbody>											
									</table>										
								{else}
									<div class="alert alert-info">
										<button class="close" data-dismiss="alert"></button>
										No Emails Available
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
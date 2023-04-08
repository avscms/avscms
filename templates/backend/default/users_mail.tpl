	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">  
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Users - <span class="semi-bold">Emails</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>Email <span class="semi-bold">User</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="email_user" method="POST" action="users.php?m=mail">						
							<h3>Email <span class="semi-bold">Details</span></h3>
							<div class="row">
								<div class="form-group">
									{if $specific}		
										<input name="username" type="hidden" value="{$username}">									
										<label class="col-lg-3 control-label">To</label>					
										<div class="col-lg-9">
											<input type="text" id="email" name="email" value="{$email}" class="form-control {if $err.email}error{/if}">
										</div>
										<div class="clearfix"></div>									
									{else}
										<label class="col-lg-3 control-label">Username</label>					
										<div class="col-lg-9">
											<input type="text" id="username" name="username" value="{$username}" class="form-control {if $err.username}error{/if}" list="suggestions" autocomplete="off" >
											<datalist id="suggestions"></datalist>												
										</div>
									{/if}
									<div class="clearfix"></div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Subject</label>					
									<div class="col-lg-9">
										<input type="text" id="subject" name="subject" value="{$subject}" class="form-control {if $err.subject}error{/if}">											
									</div>
									<div class="clearfix"></div>
								</div>								
								<div class="form-group m-0">
									<div class="col-xs-12">
										<textarea name="email-content" id="email-content" rows='30' style="width:100%" class="{if $err.message}error{/if}">{$message}</textarea>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="send_email" value="Send" class="btn btn-success btn-cons">
									<a href="index.php" class="btn btn-white btn-cons">Cancel</a>
								</div>
							</div>							
						</form>
					</div>
				</div>
			</div>			
			<!-- END PLACE PAGE CONTENT HERE -->
		</div>
	</div>
	<!-- END PAGE CONTAINER -->	
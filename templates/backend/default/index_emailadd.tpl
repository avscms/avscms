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
						<h4>New <span class="semi-bold">Email Template</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="add_email" method="POST" action="index.php?m=emailadd">
							<div class="row">
								<div class="col-md-5 col-lg-4 col-xs-12">
									<h3>Variables: <span class="semi-bold">Email Subject</span></h3>
									<p>Click on any variable to insert it into your template.</p>
									<div class="row">
										<div class="col-lg-6">
											<div class="p-b-5">
												<button type="button" onClick="insertAtCaret('subject','{literal}{$sender_name}{/literal}')" class="btn btn-white btn-sm btn-small">Sender Name: {literal}{$sender_name}{/literal}</button>
											</div>
											<div class="p-b-5">
												<button type="button" onClick="insertAtCaret('subject','{literal}{$username}{/literal}')" class="btn btn-white btn-sm btn-small">Sender Username: {literal}{$username}{/literal}</button>
											</div>											
											<div class="p-b-5">
												<button type="button" onClick="insertAtCaret('subject','{literal}{$site_name}{/literal}')" class="btn btn-white btn-sm btn-small">Website Name: {literal}{$site_name}{/literal}</button>
											</div>
											<div class="p-b-5">
												<button type="button" onClick="insertAtCaret('subject','{literal}{$site_title}{/literal}')" class="btn btn-white btn-sm btn-small">Website Title: {literal}{$site_title}{/literal}</button>
											</div>
										</div>										
									</div>
								</div>
								<div class="col-md-7 col-lg-8 col-xs-12">
									<h3>Variables: <span class="semi-bold">Email Details</span></h3>
									<p>Click on any variable to insert it into your template.</p>
									<div class="row">
										<div class="col-lg-6">
											<div class="p-b-5">
												<button type="button" onClick="insertAtCaret('content','{literal}{$sender_name}{/literal}')" class="btn btn-white btn-sm btn-small">Sender Name: {literal}{$sender_name}{/literal}</button>
											</div>
											<div class="p-b-5">
												<button type="button" onClick="insertAtCaret('content','{literal}{$message}{/literal}')"  class="btn btn-white btn-sm btn-small">Sender Message: {literal}{$message}{/literal}</button>
											</div>
											<div class="p-b-5">
												<button type="button" onClick="insertAtCaret('content','{literal}{$username}{/literal}')"  class="btn btn-white btn-sm btn-small">Sender Username: {literal}{$username}{/literal}</button>
											</div>
											<div class="p-b-5">
												<button type="button" onClick="insertAtCaret('content','{literal}{$site_name}{/literal}')" class="btn btn-white btn-sm btn-small">Website Name: {literal}{$site_name}{/literal}</button>
											</div>
											<div class="p-b-5">
												<button type="button" onClick="insertAtCaret('content','{literal}{$site_title}{/literal}')" class="btn btn-white btn-sm btn-small">Website Title: {literal}{$site_title}{/literal}</button>
											</div>
											<div class="p-b-5">
												<button type="button" onClick="insertAtCaret('content','{literal}{$receiver_name}{/literal}')" class="btn btn-white btn-sm btn-small">Receiver Name: {literal}{$receiver_name}{/literal}</button>
											</div>
											<div class="p-b-5">
												<button type="button" onClick="insertAtCaret('content','{literal}{$receiver}{/literal}')"  class="btn btn-white btn-sm btn-small">Receiver Username: {literal}{$receiver}{/literal}</button>
											</div>																					
										</div>
										<div class="col-lg-6">
											<div class="p-b-5">
												<button type="button" onClick="insertAtCaret('content','{literal}{$video_link}{/literal}')" class="btn btn-white btn-sm btn-small">Video Link: {literal}{$video_link}{/literal}</button>
											</div>
											<div class="p-b-5">
												<button type="button" onClick="insertAtCaret('content','{literal}{$album_link}{/literal}')" class="btn btn-white btn-sm btn-small">Album Link: {literal}{$album_link}{/literal}</button>
											</div>
											<div class="p-b-5">
												<button type="button" onClick="insertAtCaret('content','{literal}{$game_link}{/literal}')" class="btn btn-white btn-sm btn-small">Game Link: {literal}{$game_link}{/literal}</button>
											</div>
											<div class="p-b-5">
												<button type="button" onClick="insertAtCaret('content','{literal}{$uid}{/literal}')"  class="btn btn-white btn-sm btn-small">User Id: {literal}{$uid}{/literal}</button>
											</div>
											<div class="p-b-5">
												<button type="button" onClick="insertAtCaret('content','{literal}{$code}{/literal}')"  class="btn btn-white btn-sm btn-small">Code: {literal}{$code}{/literal}</button>
											</div>
											<div class="p-b-5">
												<button type="button" onClick="insertAtCaret('content','{literal}{$baseurl}{/literal}')"  class="btn btn-white btn-sm btn-small">Base URL: {literal}{$baseurl}{/literal}</button>
											</div>
											<div class="p-b-5">
												<button type="button" onClick="insertAtCaret('content','{literal}{$password}{/literal}')"  class="btn btn-white btn-sm btn-small">Password: {literal}{$password}{/literal}</button>
											</div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="col-x-12 m-t-20">
									<div class="form-group">
										<label class="col-lg-3 control-label">Email Id</label>
										<div class="col-lg-9">
											<input type="text" name="email_id" value="{$email.email_id}" class="form-control {if $err.email_id}error{/if}">
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Email File</label>
										<div class="col-lg-9">
											<input type="text" name="email_file" value="{$email.email_file}" class="form-control {if $err.email_file}error{/if}">
											<span class="help">Extension must be <b>.tpl</b></span>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Subject</label>
										<div class="col-lg-9">
											<input type="text" id="subject" name="subject" value="{$email.email_subject}" class="form-control {if $err.email_subject}error{/if}">
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Content</label>
										<div class="col-lg-9">
											<textarea id="content" name="content" rows="12" class="form-control {if $err.content}error{/if}" style="resize: vertical">{$email.content}</textarea>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Comments</label>
										<div class="col-lg-9">
											<input type="text" name="comment" value="{$email.comment}" class="form-control {if $err.comment}error{/if}">
											<span class="help">For <b>Admin</b></span>
										</div>
										<div class="clearfix"></div>
									</div>									
								</div>								
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="add_email" value="Add Email" class="btn btn-success btn-cons">
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
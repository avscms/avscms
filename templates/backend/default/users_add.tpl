	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">  
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Users - <span class="semi-bold">Add User</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>User <span class="semi-bold">Information</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="add_user" method="POST" enctype="multipart/form-data" action="users.php?m=add">				
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3 col-md-12">
									<div class="row">		
										<div class="form-group">
											<label class="col-lg-4 control-label">Username</label>
											<div class="col-lg-8">
												<input name="username" type="text" value="{$user.username}" class="form-control {if $err.username}error{/if}">
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Email</label>
											<div class="col-lg-8">
												<input name="email" type="text" value="{$user.email}" class="form-control {if $err.email}error{/if}">
											</div>
											<div class="clearfix"></div>
										</div>										
										<div class="form-group">
											<label class="col-lg-4 control-label">Password</label>
											<div class="col-lg-8">
												<input name="password" type="password" class="form-control {if $err.password}error{/if}">
												<span class="help">Leave blank to generate a random password.</span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Confirm Password</label>
											<div class="col-lg-8">
												<input name="password_confirm" type="password" class="form-control {if $err.password_confirm}error{/if}">
											</div>
											<div class="clearfix"></div>
										</div>										
										<div class="form-group">
											<label class="col-lg-4 control-label">Verified Email</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="emailverified_y" type="radio" name="emailverified" value="yes" {if $user.emailverified != 'no'}checked="checked"{/if} class="radio-enabled">
													<label for="emailverified_y">Yes</label>
													<input id="emailverified_n" type="radio" name="emailverified" value="no" {if $user.emailverified == 'no'}checked="checked"{/if} class="radio-disabled">
													<label for="emailverified_n">No</label>							
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Status</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="account_status_a" type="radio" name="account_status" value="Active" {if $user.account_status != 'Inactive'}checked="checked"{/if} class="radio-enabled">
													<label for="account_status_a">Active</label>
													<input id="account_status_i" type="radio" name="account_status" value="Inactive" {if $user.account_status == 'Inactive'}checked="checked"{/if} class="radio-disabled">
													<label for="account_status_i">Inactive</label>							
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Gender</label>
											<div class="col-lg-8">
												<div class="radio p-t-9">
													<input id="gender_m" type="radio" name="gender" value="Male" {if $user.gender != 'Female'}checked="checked"{/if} class="radio-enabled">
													<label for="gender_m">Male</label>
													<input id="gender_f" type="radio" name="gender" value="Female" {if $user.gender == 'Female'}checked="checked"{/if} class="radio-enabled">
													<label for="gender_f">Female</label>							
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">First Name</label>
											<div class="col-lg-8">
												<input name="fname" type="text" value="{$user.fname}" class="form-control">
												<span class="help">Optional</span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Last Name</label>
											<div class="col-lg-8">
												<input name="lname" type="text" value="{$user.lname}" class="form-control">
												<span class="help">Optional</span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Avatar</label>
											<div class="col-lg-8">
												<div id="get_file" class="btn btn btn-success btn-file" onclick="getFile('user_thumb')">Choose File</div>
												<div class="file-box">
													<span id="addthumb">No file chosen</span>
													<input name="user_thumb" type="file" id="user_thumb" onChange="sub(this,'addthumb','nofile')" accept=".gif,.jpg,.jpeg,.png" />		
													<input type="hidden" id="nofile" value="No File">
												</div>
												<span class="help">Optional</span>												
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input name="add_user" type="submit" value="Add User" id="add_user" class="btn btn-success btn-cons" onClick="document.getElementById('add_user').value='Uploading...'">
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
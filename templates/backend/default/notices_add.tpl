	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">  
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Notices - <span class="semi-bold">Add Notice</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>Add <span class="semi-bold">Notice</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="email_user" method="POST" action="notices.php?m=add">
							<h3>Notice <span class="semi-bold">Details</span></h3>
							<div class="row">
								<div class="form-group">
									<label class="col-lg-3 control-label">Username</label>					
									<div class="col-lg-9">
										<input type="text" id="username" name="username" value="{$notice.username}" class="form-control {if $err.username}error{/if}" list="suggestions" autocomplete="off" >
										<datalist id="suggestions"></datalist>												
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Title</label>					
									<div class="col-lg-9">
										<input type="text" id="title" name="title" value="{$notice.title}" class="form-control {if $err.title}error{/if}">										
									</div>
									<div class="clearfix"></div>
								</div>								
								<div class="form-group">
									<label class="col-lg-3 control-label">Category</label>
									<div class="col-lg-9">
										<select id="category" name="category" style="width:100%">
											{section name=i loop=$categories}											
											<option value="{$categories[i].category_id}"{if $categories[i].category_id == $notice.category} selected="selected"{/if}>{$categories[i].name|escape:'html'}</option>
											{/section}
										</select>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Status</label>
									<div class="col-lg-9">
										<div class="radio p-t-9">
											<input id="status_a" type="radio" name="status" value="1" {if $notice.status == '1'}checked="checked"{/if} class="radio-enabled">
											<label for="status_a">Active</label>
											<input id="status_s" type="radio" name="status" value="0" {if $notice.status == '0'}checked="checked"{/if} class="radio-disabled">
											<label for="status_s">Suspended</label>												
										</div>
									</div>
									<div class="clearfix"></div>
								</div>								
								<div class="form-group m-0">
									<div class="col-xs-12">
										<textarea name="notice-content" id="notice-content" rows='30' style="width:100%" class="{if $err.message}error{/if}">{$notice.content}</textarea>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="add_notice" value="Add Notice" class="btn btn-success btn-cons">
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
	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">  
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Albums - <span class="semi-bold">Requests / Spam</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>Editing: <span class="semi-bold">Comment {$COMID}</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="edit_comment" method="POST" action="albums.php?m=commentedit&COMID={$COMID}">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3 col-md-12">
									<div class="row">
										<div class="col-xs-12 m-b-5">
											<h3>Text <span class="semi-bold">Comment</span></h3>
										</div>
								
										<div class="form-group">
											<label class="col-lg-4 control-label">Comment</label>
											<div class="col-lg-8">
												<textarea name="comment" rows="8" class="form-control {if $err.comment}error{/if}" style="resize: vertical">{$comment}</textarea>
											</div>
											<div class="clearfix"></div>
										</div>						

									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="edit_comment" value="Save" class="btn btn-success btn-cons">
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
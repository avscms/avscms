<div class="modal fade" id="photo-editModal" tabindex="-1" role="dialog" aria-labelledby="photo-editModalLabel" aria-hidden="true" style="display: none;">
<div id="photo-editModalDialog" class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 id="photo-editModalLabel" class="semi-bold">Photo <span id="photo-edit-id-span"></span>: Edit</h4>
		</div>
		<div class="modal-body">		
			<div class="row form-row">									
				<input id="photo-edit-id" name="photo-edit-id" type="hidden" value=""/>
				<label class="col-lg-3 control-label">Caption</label>
				<div class="col-lg-9">
					<input id="photo-edit-caption" name="photo-edit-caption" type="text" value="" class="form-control">
				</div>
				<div class="clearfix"></div>
				<label class="col-lg-3 control-label">Status</label>
				<div class="col-lg-9">
					<div class="radio p-t-9">
						<input id="photo-edit-status_a" type="radio" name="photo-edit-status" value="1" class="radio-enabled">
						<label for="photo-edit-status_a">Active</label>
						<input id="photo-edit-status_i" type="radio" name="photo-edit-status" value="0" class="radio-disabled">
						<label for="photo-edit-status_i">Inactive</label>												
					</div>
				</div>
				<div class="clearfix"></div>
				<label class="col-lg-3 control-label">Likes</label>
				<div class="col-lg-9">
					<input id="photo-edit-likes" name="photo-edit-likes" type="text" value="" class="form-control">
				</div>
				<div class="clearfix"></div>

				<label class="col-lg-3 control-label">Dislikes</label>
				<div class="col-lg-9">
					<input id="photo-edit-dislikes" name="photo-edit-dislikes" type="text" value="" class="form-control">
				</div>
				<div class="clearfix"></div>

				<label class="col-lg-3 control-label">Views</label>
				<div class="col-lg-9">
					<input id="photo-edit-viewnumber" name="photo-edit-viewnumber" type="text" value="" class="form-control">
				</div>
				<div class="clearfix"></div>
			
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
			<button type="button" id="photo-edit-reset" class="btn btn-white btn-icon">Reset</button>
			<button type="button" id="photo-edit-save" class="btn btn-success">Save</button>
		</div>
	</div>
 
</div>
 
</div>	
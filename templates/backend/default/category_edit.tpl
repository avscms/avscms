<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" style="display: none;">
	<div id="editModalDialog" class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 id="editModalLabel" class="semi-bold"><span id="edit-type-span-1"></span> Category <span id="edit-id-span"></span>: Edit</h4>
			</div>
			<div class="modal-body">		
				<div class="row form-row">									
					<input id="edit-id" name="edit-id" type="hidden" value=""/>
					<input id="edit-type" name="edit-type" type="hidden" value=""/>
					<label class="col-lg-3 control-label">Name</label>
					<div class="col-lg-9">
						<input id="edit-name" name="edit-name" type="text" value="" class="form-control">
					</div>
					<div class="clearfix"></div>
					<div id="edit-slug-container">
						<label class="col-lg-3 control-label">Slug</label>
						<div class="col-lg-9">
							<input id="edit-slug" name="edit-slug" type="text" value="" class="form-control m-0">
							<span class="help">Leave blank for auto generate the slug</span>
						</div>
						<div class="clearfix"></div>
					</div>
					<div id="edit-status-container" style="display: none">
						<label class="col-lg-3 control-label">Status</label>
						<div class="col-lg-9">
							<div class="radio p-t-9">
								<input id="edit-status_a" type="radio" name="edit-status" value="1" class="radio-enabled">
								<label for="edit-status_a">Active</label>
								<input id="edit-status_i" type="radio" name="edit-status" value="0" class="radio-disabled">
								<label for="edit-status_i">Inactive</label>												
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="m-b-20"></div>
					<label class="col-lg-3 control-label"></label>
					<div class="col-lg-9">
						<div class="checkbox check-default">
							<input name="edit-update-counter" id="edit-update-counter" type="checkbox" value="1">
							<label for="edit-update-counter">Update Counter</label>
						</div>
					</div>						
					<div class="clearfix"></div>					
					<div class="m-b-10"></div>				
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				<button type="button" id="edit-reset" class="btn btn-white btn-icon">Reset</button>
				<button type="button" id="edit-save" class="btn btn-success">Save</button>
			</div>
		</div>
	</div>
</div>	
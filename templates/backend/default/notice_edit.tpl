<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" style="display: none;">
<div id="editModalDialog" class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 id="editModalLabel" class="semi-bold">Notice <span id="edit-id-span"></span>: Edit</h4>
		</div>
		<div class="modal-body">		
			<div class="row form-row">									
				<input id="edit-id" name="edit-id" type="hidden" value=""/>
				<label class="col-lg-3 control-label">Title</label>
				<div class="col-lg-9">
					<input id="edit-title" name="edit-title" type="text" value="" class="form-control">
				</div>
				<div class="clearfix"></div>
				<label class="col-lg-3 control-label">Content</label>
				<div class="col-lg-9">
					<textarea id="edit-content" name="edit-content" rows="6" class="form-control" style="resize: vertical"></textarea>
				</div>
				<div class="clearfix"></div>				
				<label class="col-lg-3 control-label">Category</label>
				<div class="col-lg-9">
					<select id="edit-category" name="edit-category" style="width:100%">
						{section name=i loop=$categories}
						<option value="{$categories[i].category_id}">{$categories[i].name|escape:'html'}</option>
						{/section}
					</select>
				</div>								
				<div class="clearfix"></div>
				<div class="m-t-10"></div>				
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
				<label class="col-lg-3 control-label">Views</label>
				<div class="col-lg-9">
					<input id="edit-viewnumber" name="edit-viewnumber" type="text" value="" class="form-control">
				</div>
				<div class="clearfix"></div>
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
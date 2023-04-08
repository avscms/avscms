<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" style="display: none;">
<div id="editModalDialog" class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 id="editModalLabel" class="semi-bold">Video <span id="edit-id-span"></span>: Edit</h4>
		</div>
		<div class="modal-body">		
			<div class="row form-row">									
				<input id="edit-id" name="edit-id" type="hidden" value=""/>
				<label class="col-lg-3 control-label">Title</label>
				<div class="col-lg-9">
					<input id="edit-title" name="edit-title" type="text" value="" class="form-control">
				</div>
				<div class="clearfix"></div>
				<label class="col-lg-3 control-label">Description</label>
				<div class="col-lg-9">
					<textarea id="edit-description" name="edit-description" rows="2" class="form-control" style="resize: vertical"></textarea>
				</div>
				<div class="clearfix"></div>
				<label class="col-lg-3 control-label">Tags</label>
				<div class="col-lg-9">
					<textarea id="edit-tags" name="edit-tags" rows="2" class="form-control" style="resize: vertical"></textarea>
				</div>
				<div class="clearfix"></div>
				<label class="col-lg-3 control-label">Category</label>
				<div class="col-lg-9">
					<select id="edit-category" name="edit-category" style="width:100%">
						{section name=i loop=$channels}
						<option value="{$channels[i].CHID}">{$channels[i].name|escape:'html'}</option>
						{/section}
					</select>
				</div>
				<div class="clearfix"></div>
				<div class="m-t-10"></div>				
				<label class="col-lg-3 control-label">Type</label>
				<div class="col-lg-9">
					<div class="radio p-t-9">
						<input id="edit-type_public" type="radio" name="edit-type" value="public" class="radio-enabled">
						<label for="edit-type_public">Public</label>
						<input id="edit-type_private" type="radio" name="edit-type" value="private" class="radio-disabled">
						<label for="edit-type_private">Private</label>												
					</div>
				</div>
				<div class="clearfix"></div>
				<label class="col-lg-3 control-label">Status</label>
				<div class="col-lg-9">
					<div class="radio p-t-9">
						<input id="edit-active_a" type="radio" name="edit-active" value="1" class="radio-enabled">
						<label for="edit-active_a">Active</label>
						<input id="edit-active_i" type="radio" name="edit-active" value="0" class="radio-disabled">
						<label for="edit-active_i">Inactive</label>												
					</div>
				</div>
				<div class="clearfix"></div>
				<label class="col-lg-3 control-label">Featured</label>
				<div class="col-lg-9">
					<div class="radio p-t-9">
						<input id="edit-featured_y" type="radio" name="edit-featured" value="yes" class="radio-enabled">
						<label for="edit-featured_y">Yes</label>
						<input id="edit-featured_n" type="radio" name="edit-featured" value="no" class="radio-disabled">
						<label for="edit-featured_n">No</label>												
					</div>
				</div>
				<div class="clearfix"></div>
				<label class="col-lg-3 control-label">Can be commented?</label>
				<div class="col-lg-9">
					<div class="radio p-t-9">
						<input id="edit-be_comment_y" type="radio" name="edit-be_comment" value="yes" class="radio-enabled">
						<label for="edit-be_comment_y">Yes</label>
						<input id="edit-be_comment_n" type="radio" name="edit-be_comment" value="no" class="radio-disabled">
						<label for="edit-be_comment_n">No</label>												
					</div>
				</div>
				<div class="clearfix"></div>
				<label class="col-lg-3 control-label">Can be rated?</label>
				<div class="col-lg-9">
					<div class="radio p-t-9">
						<input id="edit-be-rated-y" type="radio" name="edit-be_rated" value="yes" class="radio-enabled">
						<label for="edit-be-rated-y">Yes</label>
						<input id="edit-be-rated-n" type="radio" name="edit-be_rated" value="no" class="radio-disabled">
						<label for="edit-be-rated-n">No</label>												
					</div>
				</div>
				<div class="clearfix"></div>
				<label class="col-lg-3 control-label">Can be embeded?</label>
				<div class="col-lg-9">
					<div class="radio p-t-9">
						<input id="edit-embed_y" type="radio" name="edit-embed" value="enabled" class="radio-enabled">
						<label for="edit-embed_y">Yes</label>
						<input id="edit-embed_n" type="radio" name="edit-embed" value="disabled" class="radio-disabled">
						<label for="edit-embed_n">No</label>												
					</div>
				</div>
				<div class="clearfix"></div>
				{if $multi_server == '1'}										
					<label class="col-lg-3 control-label">Server</label>
						<div class="col-lg-9">
							<input id="edit-server" name="edit-server" type="text" value="" class="form-control">
						</div>
					<div class="clearfix"></div>
				{/if}
				<label class="col-lg-3 control-label">Likes</label>
				<div class="col-lg-9">
					<input id="edit-likes" name="edit-likes" type="text" value="" class="form-control {if $err.likes}error{/if}">
				</div>
				<div class="clearfix"></div>

				<label class="col-lg-3 control-label">Dislikes</label>
				<div class="col-lg-9">
					<input id="edit-dislikes" name="edit-dislikes" type="text" value="" class="form-control {if $err.dislikes}error{/if}">
				</div>
				<div class="clearfix"></div>

				<label class="col-lg-3 control-label">Views</label>
				<div class="col-lg-9">
					<input id="edit-viewnumber" name="edit-viewnumber" type="text" value="" class="form-control {if $err.viewnumber}error{/if}">
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
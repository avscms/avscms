<div class="modal fade" id="add-photosModal" tabindex="-1" role="dialog" aria-labelledby="add-photosModalLabel" aria-hidden="true" style="display: none;">
	<div id="add-photosModalDialog" class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 id="add-photosModalLabel" class="semi-bold">Album <span id="add-photos-id-span"></span>: Add Photos</h4>
			</div>
			<form action="upload_photos.php" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" >
			<div class="modal-body">
				<div class="row form-row thumb-row">
					<input id="album-add-id" name="album-add-id" type="hidden" value=""/>
					<div id="photos-add-container"></div>
					<div id="photos-added-loading" class="thumbnails-loading" style="display: none">
						<i class="loader"></i>
					</div>
				</div>
			</div>				
			<div class="modal-body">
				<div class="row">
					<div class="form-group m-l-5 m-r-5">
						<label class="col-lg-4 control-label">Photos</label>
						<div class="col-lg-8">
							<div id="get_file" class="btn btn btn-success btn-file" onclick="getFile('addphotos')">Choose File(s)</div>
							<div class="file-box">
								<span id="upaddphotos">No file chosen</span>
								<input name="addphotos[]" type="file" id="addphotos" onChange="sub(this,'upaddphotos','nofile')" multiple accept=".gif,.jpg,.jpeg,.png" />		
								<input type="hidden" id="nofile" value="No File">
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>				
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				<div class="pull-right">
					<button type="button" id="add-photos-update" class="btn btn-white btn-icon">Update Captions</button>
					<button type="submit" id="add-photos-upload" class="btn btn-success">Upload</button>
				</div>		
			</div>
			</form>
		</div>
	</div>
</div>	
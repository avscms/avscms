<div class="modal fade" id="category-thumbnailModal" tabindex="-1" role="dialog" aria-labelledby="category-thumbnailModalLabel" aria-hidden="true" style="display: none;">
	<div id="category-thumbnailModalDialog" class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 id="category-thumbnailModalLabel" class="semi-bold">Category <span id="category-thumbnail-id-span"></span>: Thumbnail</h4>
			</div>
			<form action="upload_category_thumbnail.php" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" >
			<div class="modal-body">
				<div class="row form-row">
					<input id="category-thumbnail-id" name="category-thumbnail-id" type="hidden" value=""/>
					<input id="category-thumbnail-type" name="category-thumbnail-type" type="hidden" value=""/>
					<div id="category-thumbnail-container"></div>
					<div id="category-thumbnail-loading" class="thumbnails-loading" style="display: none">
						<i class="loader"></i>
					</div>
				</div>
			</div>				
			<div class="modal-body">		
				<div class="row">			
					<div class="form-group m-l-5 m-r-5">
						<label class="col-lg-4 control-label">Thumbnail</label>
						<div class="col-lg-8">
							<div id="get_file" class="btn btn btn-success btn-file" onclick="getFile('addthumb')">Choose File</div>
							<div class="file-box">
								<span id="upaddthumb">No file chosen</span>
								<input name="addthumb" type="file" id="addthumb" onChange="sub(this,'upaddthumb','nofile')" accept=".gif,.jpg,.jpeg,.png" />		
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
					<button type="submit" id="category-thumbnail-upload" class="btn btn-success">Update</button>
				</div>		
			</div>
			</form>
		</div>
	</div>
</div>	
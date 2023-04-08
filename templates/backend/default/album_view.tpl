<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true" style="display: none;">
	<div id="viewModalDialog" class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 id="viewModalLabel" class="semi-bold">Album <span id="view-id-span"></span>: View</h4>
			</div>
			<div class="modal-body">
				<div class="row form-row thumb-row">
					<input id="view-id" name="view-id" type="hidden" value=""/>			
					<div id="photos-container"></div>
					<div id="photos-container-rel" style="display: none"></div>
					<div class="clearfix"></div>
					<div id="photos-loading" class="thumbnails-loading" style="display: none"><i class="loader"></i></div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				<div class="pull-right">
					<a class="btn btn-danger" data-toggle="dropdown" href="#" alt="Delete" title="Delete">Delete Album</a>				
					<ul class="dropdown-menu">
						<li><a id="view_del_album" data-id="" href="#">Confirm Delete</a></li>
					</ul>					
				</div>		
			</div>	
		</div>
	</div>
</div>	
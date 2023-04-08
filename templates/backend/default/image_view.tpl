<div class="modal fade" id="image-viewModal" tabindex="-1" role="dialog" aria-labelledby="image-viewModalLabel" aria-hidden="true" style="display: none;">
	<div id="image-viewModalDialog" class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 id="image-viewModalLabel" class="semi-bold">Image <span id="image-view-id-span"></span>: View</h4>
			</div>
			<div class="modal-body">		
				<div class="row">									
					<input id="image-view-id" name="image-view-id" type="hidden" value=""/>
					<div id="image-view-title-container" class="col-xs-12 overflow-hidden"><h3 class="semi-bold"><center><span id="image-view-title"></span></center></h3></div>
					<div id="image-view-container" class="col-xs-12">
						<center>
							<img id="image-view-img" src="" class="img-responsive-mw"/>
						</center>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				<div class="pull-right">
					<button type="button" id="image-view-copy-link" data-id="" class="btn btn-success">Copy Image Link</button>
					<a class="btn btn-danger" data-toggle="dropdown" href="#" alt="Delete" title="Delete">Delete Image</a>
					<ul class="dropdown-menu">
						<li><a id="view_del_image" data-id="" href="#">Confirm Delete</a></li>
					</ul>
				</div>
			</div>
		</div>	 
	</div>
</div>	
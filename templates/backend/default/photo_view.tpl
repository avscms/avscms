<div class="modal fade" id="photo-viewModal" tabindex="-1" role="dialog" aria-labelledby="photo-viewModalLabel" aria-hidden="true" style="display: none;">
	<div id="photo-viewModalDialog" class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 id="photo-viewModalLabel" class="semi-bold">Photo <span id="photo-view-id-span"></span>: View</h4>
			</div>
			<div class="modal-body">		
				<div class="row">									
					<input id="photo-view-id" name="photo-view-id" type="hidden" value=""/>
					<div id="photo-view-title-container" class="col-xs-12 overflow-hidden"><h3 class="semi-bold"><center><span id="photo-view-title"></span></center></h3></div>
					<div id="photo-view-container" class="col-xs-12">
						<center>
							<img id="photo-view-img" src="" class="img-responsive-mw"/>
						</center>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				<div class="pull-right">
					<a class="btn btn-danger" data-toggle="dropdown" href="#" alt="Delete" title="Delete">Delete Photo</a>
					<ul class="dropdown-menu">
						<li><a id="view_del_photo" data-id="" href="#">Confirm Delete</a></li>
					</ul>
				</div>
			</div>
		</div>	 
	</div>
</div>	
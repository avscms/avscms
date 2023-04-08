<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true" style="display: none;">
	<div id="viewModalDialog" class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 id="viewModalLabel" class="semi-bold">Blog <span id="view-id-span"></span>: View</h4>
			</div>
			<div class="modal-body">		
				<div class="row">									
					<input id="view-id" name="view-id" type="hidden" value=""/>
					<div class="col-xs-12 overflow-hidden"><h3 class="semi-bold"><center><span id="view-title"></span></center></h3></div>
					<div class="col-xs-12">
						<div class="video-wrapper">
							<iframe id="view-blog-container" src="" frameborder="0" scrolling="no" allowfullscreen></iframe>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				<div class="pull-right">
					<a class="btn btn-danger" data-toggle="dropdown" href="#" alt="Delete" title="Delete">Delete</a>				
					<ul class="dropdown-menu">
						<li><a id="view_del_blog" data-id="" href="#">Confirm Delete</a></li>
					</ul>
				</div>
			</div>
		</div>	 
	</div>
</div>	
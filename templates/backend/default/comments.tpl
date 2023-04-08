<div class="modal fade" id="commentsModal" tabindex="-1" role="dialog" aria-labelledby="commentsModalLabel" aria-hidden="true" style="display: none;">
	<div id="commentsModalDialog" class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 id="commentsModalLabel" class="semi-bold"><span id="comments-type-span"></span> <span id="comments-id-span"></span>: Comments</h4>
			</div>
			<div class="modal-body">
				<div class="row form-row thumb-row">
					<input id="comments-id" name="comments-id" type="hidden" value=""/>			
					<div id="comments-container"></div>
					<div id="comments-container-rel" style="display: none"></div>
					<div class="clearfix"></div>
					<div id="comments-loading" class="thumbnails-loading" style="display: none"><i class="loader"></i></div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-xs-12">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>		
					</div>
				</div>			
			</div>	
		</div>
	</div>
</div>	
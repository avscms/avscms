<div class="modal fade" id="coverModal" tabindex="-1" role="dialog" aria-labelledby="coverModalLabel" aria-hidden="true" style="display: none;">
<div id="coverModalDialog" class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 id="coverModalLabel" class="semi-bold">Album <span id="cover-id-span"></span>: Cover</h4>
		</div>
		<div class="modal-body">
		
			<input id="x1" type="hidden" value="0" />
			<input id="y1" type="hidden" value="0" />
			<input id="x2" type="hidden" value="400" />
			<input id="y2" type="hidden" value="400" />
			<input id="width" type="hidden" value="400" />
			<input id="height" type="hidden" value="400" />
			<input id="cover-photo-id" type="hidden" value="" />
		
			<h4><span id="cover-step-span">Select Cover</span></h4>		
			<div class="row form-row thumb-row">
				<input id="cover-id" name="cover-id" type="hidden" value=""/>			
				<input id="thumbnails-start" name="thumbnails-start" type="hidden" value=""/>
				<input id="thumbnails-default" name="thumbnails-default" type="hidden" value=""/>				
				<input id="thumbnails-processing" name="thumbnails-processing" type="hidden" value="0"/>
				<div id="thumbnails-container"></div>
				<div id="thumbnails-container-rel" style="display: none"></div>
				<div class="clearfix"></div>
				<div id="thumbnails-loading" class="thumbnails-loading" style="display: none"><i class="loader"></i></div>
			</div>
		</div>
		<div class="modal-footer">
			<div id="cover-pagination" class="row">
				<div id="cover-pagination-container">			
					<div class="col-xs-12 m-b-10">
						<div class="pull-left">
							<button type="button" id="cover-np-prev" class="btn btn-white btn-icon"><i class="fa fa-arrow-left"></i></button>					
						</div>
						<div class="pull-right">
							<button type="button" id="cover-np-next" class="btn btn-white btn-icon"><i class="fa fa-arrow-right"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>	
					<button type="button" id="cover-np-back" class="btn btn-white btn-icon">Back</button>
					<button type="button" id="cover-save" class="btn btn-success">Save</button>				
				</div>
			</div>			
		</div>
				
	</div>
 
</div>
 
</div>	
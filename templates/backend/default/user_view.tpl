<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true" style="display: none;">
	<div id="viewModalDialog" class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 id="viewModalLabel" class="semi-bold">User <span id="view-id-span"></span>: View</h4>
			</div>
			<div class="modal-body" style="padding :10px!important">
				<div class="row">
					<input id="view-id" name="view-id" type="hidden" value=""/>
					<div class="col-md-3 col-sm-3">
						<div class="user-profile-pic">	
							<img id="view-profile-pic" src="">
						</div>
					</div>
					<div class="col-md-9 col-sm-9">
						<div class="user-description-container">
						<h4 id="view-username" class="semi-bold no-margin"></h4>
						<h6 id="view-name" class="no-margin"></h6>
						<br>
						<p id="view-website-container"><i class="fa fa-globe"></i><span id="view-website"><span></p>
						<p><i class="fa fa-envelope"></i><a id="view-send-email" href=""><span id="view-email"><span></a></p>
						<p id="view-bdate-container"><i class="fa fa-birthday-cake"></i><span id="view-bdate"><span></p>
						</div>
					</div>
					<div class="clearfix"></div>			
				</div>
				<ul class="nav nav-tabs m-t-15" id="tab-01">
					<li class="active"><a href="#view-tab1">Basic</a></li>
					<li><a id="view-advanced-tab" href="#view-tab2">Advanced</a></li>
				</ul>
				<div class="tab-content m-0">
					<div class="tab-pane active" id="view-tab1">
						<div class="row">
							<div class="col-xs-12">
								<div id="view-basic-info-container" class="info-container">							
								</div>
							</div>
							<div class="clearfix"></div>				
						</div>
					</div>
					<div class="tab-pane" id="view-tab2">
						<div class="row">									
							<div class="col-xs-12">			
								<div id="view-advanced-info-container" class="info-container">							
								</div>
							</div>				
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				<div class="pull-right">
					<a class="btn btn-danger" data-toggle="dropdown" href="#" alt="Delete" title="Delete">Delete</a>				
					<ul class="dropdown-menu">
						<li><a id="view_del_user" data-id="" href="#">Confirm Delete</a></li>
					</ul>
				</div>
			</div>
		</div>	 
	</div>
</div>	
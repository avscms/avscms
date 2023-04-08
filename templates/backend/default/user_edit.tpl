<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" style="display: none;">
<div id="editModalDialog" class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 id="editModalLabel" class="semi-bold">User <span id="edit-id-span"></span>: Edit</h4>
		</div>
		<div class="modal-body" style="padding: 10px!important">	

		<ul class="nav nav-tabs" id="tab-01">
			<li class="active"><a href="#tab1">Account</a></li>
			<li><a href="#tab2">Personal</a></li>
			<li><a href="#tab3">Location</a></li>
			<li><a href="#tab4">Profile</a></li>
		</ul>

		<div class="tab-content m-0">
			<div class="tab-pane active" id="tab1">
				<div class="row form-row">									
					<input id="edit-id" name="edit-id" type="hidden" value=""/>
					<label class="col-lg-3 control-label">Username</label>
					<div class="col-lg-9">
						<input id="edit-username" name="edit-username" type="text" value="" class="form-control" disabled>
					</div>
					<div class="clearfix"></div>				
					<label class="col-lg-3 control-label">Email Address</label>
					<div class="col-lg-9">
						<input id="edit-email" name="edit-email" type="text" value="" class="form-control">
					</div>
					<div class="m-t-10"></div>				
					<label class="col-lg-3 control-label">Verified Email</label>
					<div class="col-lg-9">
						<div class="radio p-t-9">
							<input id="edit-emailverified_yes" type="radio" name="edit-emailverified" value="yes" class="radio-enabled">
							<label for="edit-emailverified_yes">Yes</label>
							<input id="edit-emailverified_no" type="radio" name="edit-emailverified" value="no" class="radio-disabled">
							<label for="edit-emailverified_no">No</label>
						</div>
					</div>				
					<div class="clearfix"></div>
					<label class="col-lg-3 control-label">Status</label>
					<div class="col-lg-9">
						<div class="radio p-t-9">
							<input id="edit-status_a" type="radio" name="edit-status" value="Active" class="radio-enabled">
							<label for="edit-status_a">Active</label>
							<input id="edit-status_i" type="radio" name="edit-status" value="Inactive" class="radio-disabled">
							<label for="edit-status_i">Inactive</label>												
						</div>
					</div>					
					<div class="clearfix"></div>
					<label class="col-lg-3 control-label">Type</label>
					<div class="col-lg-9">
						<div class="radio p-t-9">
							<input id="edit-premium_free" type="radio" name="edit-premium" value="0" class="radio-enabled">
							<label for="edit-premium_free">Free</label>
							<input id="edit-premium_premium" type="radio" name="edit-premium" value="1" class="radio-enabled">
							<label for="edit-premium_premium">Premium</label>												
						</div>
					</div>
					<div class="clearfix"></div>			
					<div class="m-t-10"></div>
					<label class="col-lg-3 control-label">Likes</label>
					<div class="col-lg-9">
						<input id="edit-likes" name="edit-likes" type="text" value="" class="form-control">
					</div>
					<div class="clearfix"></div>
					<label class="col-lg-3 control-label">Dislikes</label>
					<div class="col-lg-9">
						<input id="edit-dislikes" name="edit-dislikes" type="text" value="" class="form-control">
					</div>					
					<div class="clearfix"></div>
					<div class="m-t-10"></div>
					<label class="col-lg-3 control-label">Profile Views</label>
					<div class="col-lg-9">
						<input id="edit-viewnumber" name="edit-viewnumber" type="text" value="" class="form-control">
					</div>
					<div class="clearfix"></div>
					<label class="col-lg-3 control-label">Video Views</label>
					<div class="col-lg-9">
						<input id="edit-video_viewed" name="edit-video_viewed" type="text" value="" class="form-control">
					</div>
					<div class="clearfix"></div>
					<label class="col-lg-3 control-label">Watched Videos</label>
					<div class="col-lg-9">
						<input id="edit-watched_video" name="edit-watched_video" type="text" value="" class="form-control">
					</div>					
					<div class="clearfix"></div>
					<div class="m-t-10"></div>
					<label class="col-lg-3 control-label">Password</label>
					<div class="col-lg-9">
						<input id="edit-password" name="edit-password" type="password" value="" class="form-control">
					</div>					
					<div class="clearfix"></div>
					<label class="col-lg-3 control-label">Confirm Password</label>
					<div class="col-lg-9">
						<input id="edit-password_confirm" name="edit-password_confirm" type="password" value="" class="form-control">
					</div>					
					<div class="clearfix"></div>					
				</div>
			</div>
			<div class="tab-pane" id="tab2">
				<div class="row form-row">									
					<label class="col-lg-3 control-label">First Name</label>
					<div class="col-lg-9">
						<input id="edit-fname" name="edit-fname" type="text" value="" class="form-control">
					</div>
					<div class="clearfix"></div>				
					<label class="col-lg-3 control-label">Last Name</label>
					<div class="col-lg-9">
						<input id="edit-lname" name="edit-lname" type="text" value="" class="form-control">
					</div>
					<div class="m-t-10"></div>				
					<label class="col-lg-3 control-label">Gender</label>
					<div class="col-lg-9">
						<div class="radio p-t-9">
							<input id="edit-gender_male" type="radio" name="edit-gender" value="Male" class="radio-enabled">
							<label for="edit-gender_male">Male</label>
							<input id="edit-gender_female" type="radio" name="edit-gender" value="Female" class="radio-enabled">
							<label for="edit-gender_female">Female</label>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="m-t-10"></div>						
					<label class="col-lg-3 control-label">Relationship</label>
					<div class="col-lg-9">
						<select name="edit-relationship" id="edit-relationship" style="width:100%">
							<option value="">Not Specified</option>
							<option value="Single">Single</option>
							<option value="Open">Open</option>
							<option value="Taken">Taken</option>
						</select>
					</div>
					<div class="clearfix"></div>
					<div class="m-t-10"></div>
					<label class="col-lg-3 control-label">Interested</label>
					<div class="col-lg-9">
						<select name="edit-interested" id="edit-interested" style="width:100%">
							<option value="">Not Specified</option>
							<option value="Guys">Interested in Men</option>
							<option value="Girls">Interested in Women</option>
							<option value="Guys + Girls">Interested in Both</option>
						</select>
					</div>
					<div class="clearfix"></div>					
				</div>
			</div>
			<div class="tab-pane" id="tab3">
				<div class="row form-row">									
					<label class="col-lg-3 control-label">Hometown</label>
					<div class="col-lg-9">
						<input id="edit-town" name="edit-town" type="text" value="" class="form-control">
					</div>
					<div class="clearfix"></div>
					<label class="col-lg-3 control-label">City</label>
					<div class="col-lg-9">
						<input id="edit-city" name="edit-city" type="text" value="" class="form-control">
					</div>
					<div class="clearfix"></div>
					<label class="col-lg-3 control-label">Country</label>
					<div class="col-lg-9">
						<select name="edit-country" id="edit-country" style="width:100%">
							<option value="">Select Country</option>
							{section name=i loop=$countries}
							<option value="{$countries[i]}">{$countries[i]}</option>
							{/section}
						</select>
					</div>
					<div class="clearfix"></div>					
					
				</div>
			</div>
			<div class="tab-pane" id="tab4">
				<div class="row form-row">									
					<label class="col-lg-3 control-label">Website</label>
					<div class="col-lg-9">
						<input id="edit-website" name="edit-website" type="text" value="" class="form-control">
					</div>
					<div class="clearfix"></div>
					<label class="col-lg-3 control-label">About Me</label>
					<div class="col-lg-9">
						<textarea id="edit-aboutme" name="edit-aboutme" rows="2" class="form-control" style="resize: vertical"></textarea>
					</div>
					<div class="clearfix"></div>
					
					<label class="col-lg-3 control-label">Occupation</label>
					<div class="col-lg-9">
						<textarea id="edit-occupation" name="edit-occupation" rows="2" class="form-control" style="resize: vertical"></textarea>
					</div>
					<div class="clearfix"></div>

					<label class="col-lg-3 control-label">Company</label>
					<div class="col-lg-9">
						<textarea id="edit-company" name="edit-company" rows="2" class="form-control" style="resize: vertical"></textarea>
					</div>
					<div class="clearfix"></div>

					<label class="col-lg-3 control-label">School</label>
					<div class="col-lg-9">
						<textarea id="edit-school" name="edit-school" rows="2" class="form-control" style="resize: vertical"></textarea>
					</div>
					<div class="clearfix"></div>

					<label class="col-lg-3 control-label">Here For</label>
					<div class="col-lg-9">
						<textarea id="edit-interest_hobby" name="edit-interest_hobby" rows="2" class="form-control" style="resize: vertical"></textarea>
					</div>
					<div class="clearfix"></div>

					<label class="col-lg-3 control-label">Favorite Sex Categories</label>
					<div class="col-lg-9">
						<textarea id="edit-fav_movie_show" name="edit-fav_movie_show" rows="2" class="form-control" style="resize: vertical"></textarea>
					</div>
					<div class="clearfix"></div>

					<label class="col-lg-3 control-label">Ideal Sex Partner</label>
					<div class="col-lg-9">
						<textarea id="edit-fav_music" name="edit-fav_music" rows="2" class="form-control" style="resize: vertical"></textarea>
					</div>
					<div class="clearfix"></div>					
					
					<label class="col-lg-3 control-label">My Erogenic Zones</label>
					<div class="col-lg-9">
						<textarea id="edit-fav_book" name="edit-fav_book" rows="2" class="form-control" style="resize: vertical"></textarea>
					</div>
					<div class="clearfix"></div>

					<label class="col-lg-3 control-label">Turn Ons</label>
					<div class="col-lg-9">
						<textarea id="edit-turnon" name="edit-turnon" rows="2" class="form-control" style="resize: vertical"></textarea>
					</div>
					<div class="clearfix"></div>
					
					<label class="col-lg-3 control-label">Turn Offs</label>
					<div class="col-lg-9">
						<textarea id="edit-turnoff" name="edit-turnoff" rows="2" class="form-control" style="resize: vertical"></textarea>
					</div>
					<div class="clearfix"></div>					

				</div>			
			</div>
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
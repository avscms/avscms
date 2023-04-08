<div class="modal fade in" id="g-signup-modal">
	<div class="modal-dialog signup-modal">
      <div class="modal-content">
        <form name="g-signup-form" method="post" action="{$relative}/signup">
		<div class="modal-header">
          <h4 class="modal-title">{t c='socialsignup.welcome'}<span id="g-signup-title"></span>!</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>		  
        </div>
        <div class="modal-body">
			<input name="g-signup-id" id="g-signup-id" type="hidden" value="" />
			<input name="g-signup-picture" id="g-signup-picture" type="hidden" value="" />
			<input name="g-signup-email" id="g-signup-email" type="hidden" value="" />		
			<input name="g-signup-first-name" id="g-signup-first-name" type="hidden" value="" />
			<input name="g-signup-last-name" id="g-signup-last-name" type="hidden" value="" />			
			<input name="g-signup-gender" id="g-signup-gender" type="hidden" value="" />
			<input name="g-signup-age-min" id="g-signup-age-min" type="hidden" value="" />			
			<div id="g-signup-picture-block" class="form-group">
				<div class="row">
					<div class="col-xs-6 col-sm-4 mx-auto">
						<img class="img-responsive" id="g-signup-picture-img" src="" />
					</div>					
				</div>
				<div class="row">
					<div class="mx-auto mt-2">
						<input name="g-signup-usepp" type="checkbox" id="g-signup-usepp">
						<label class="form-check-label" for="g-signup-usepp">
							{t c='socialsignup.use_profile_picture'}
						</label>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>	
			<div id="g-signup-tabs">
				<nav>
				  <div class="nav nav-tabs" id="nav-tab" role="tablist">
					<a class="nav-item nav-link active" id="g-signup-new-tab" data-toggle="tab" href="#g-signup-new" role="tab" aria-controls="g-signup-new" aria-selected="true">{t c='socialsignup.new_user'}</a>
					<a class="nav-item nav-link" id="g-signup-existing-tab" data-toggle="tab" href="#g-signup-existing" role="tab" aria-controls="g-signup-existing" aria-selected="false">{t c='socialsignup.returning_user'}</a>
				  </div>
				</nav>
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="g-signup-new" role="tabpanel" aria-labelledby="g-signup-new-tab">
						<div class="form-group mt-2">
							<span>{t c='socialsignup.link_account_new' u='google' v=$site_name}</span>
						</div>		
						<div class="form-group">
							<label class="control-label">{t c='global.email'}:</label>							
							<div>
								<span id="g-signup-email-label"></span>
							</div>
						</div>						
						<div class="form-group">
							<label for="g-signup-username" class="control-label">{t c='global.username'}:</label>
							<input name="g-signup-username" type="text" value="" id="g-signup-username" class="form-control" />
							<div class="m-t-5">
								<span id="g-signup-username-check"></span>
							</div>
						</div>
						<div class="form-group">
							<div class="small">
								<b>{t c='socialsignup.agreement'}</b></br>
								{t c='socialsignup.certify'}</br>
								{t c='socialsignup.terms' u=$baseurl v=$baseurl}
							</div>
						</div>				  
					</div>
					<div class="tab-pane fade" id="g-signup-existing" role="tabpanel" aria-labelledby="g-signup-existing-tab">
						<div class="form-group mt-2">
							<span>{t c='socialsignup.link_account_existing_details' u='google' v=$site_name}</span>
						</div>		
						<div class="form-group">
							<label for="g-signup-existing-username" class="control-label">{t c='global.username'}:</label>
							<input name="g-signup-existing-username" type="text" value="" id="g-signup-existing-username" class="form-control" />
						</div>
						<div class="form-group">
							<label for="g-signup-existing-password" class="control-label">{t c='global.password'}:</label>
							<input name="g-signup-existing-password" type="password" value="" id="g-signup-existing-password" class="form-control" />
						</div>
						<div class="form-group">
							<a href="{$relative}/lost" rel="nofollow">{t c='global.forgot'}</a>
						</div>			  
					</div>
				</div>
			</div>
			<div id="g-signup-single">
				<div class="form-group mt-2">
					<span>{t c='socialsignup.link_account_existing_password' u='google' v=$site_name}</span>
				</div>		
				<div class="form-group">
					<label for="g-signup-existing-username-locked" class="control-label">{t c='global.username'}:</label>
					<input name="g-signup-existing-username-locked" type="text" value="" id="g-signup-existing-username-locked" class="form-control" readonly/>
				</div>
				<div class="form-group">
					<label for="g-signup-existing-password-locked" class="control-label">{t c='global.password'}:</label>
					<input name="g-signup-existing-password-locked" type="password" value="" id="g-signup-existing-password-locked" class="form-control" />
				</div>
				<div class="form-group">
					<a href="{$relative}/lost" rel="nofollow">{t c='global.forgot'}</a>
				</div>				
			</div>
        </div>
        <div class="modal-footer">
			<button name="g-signup-submit-new" id="g-signup-submit-new" type="submit" class="btn btn-primary btn-bold">{t c='socialsignup.create_account'}</button>
			<button name="g-signup-submit-existing" id="g-signup-submit-existing" type="submit" class="btn btn-primary btn-bold">{t c='socialsignup.link_account'}</button>		  
        </div>
		</form>			
      </div>
    </div>
</div>
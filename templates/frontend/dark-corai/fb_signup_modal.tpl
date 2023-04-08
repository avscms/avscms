<div class="modal fade in" id="fb-signup-modal">
	<div class="modal-dialog signup-modal">
      <div class="modal-content">
        <form name="fb-signup-form" method="post" action="{$relative}/signup">
		<div class="modal-header">
          <h4 class="modal-title">{t c='socialsignup.welcome'}<span id="fb-signup-title"></span>!</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>		  
        </div>
        <div class="modal-body">
			<input name="fb-signup-id" id="fb-signup-id" type="hidden" value="" />
			<input name="fb-signup-picture" id="fb-signup-picture" type="hidden" value="" />
			<input name="fb-signup-email" id="fb-signup-email" type="hidden" value="" />		
			<input name="fb-signup-first-name" id="fb-signup-first-name" type="hidden" value="" />
			<input name="fb-signup-last-name" id="fb-signup-last-name" type="hidden" value="" />			
			<input name="fb-signup-gender" id="fb-signup-gender" type="hidden" value="" />
			<input name="fb-signup-age-min" id="fb-signup-age-min" type="hidden" value="" />			
			<div id="fb-signup-picture-block" class="form-group">
				<div class="row">
					<div class="col-xs-6 col-sm-4 mx-auto">
						<img class="img-responsive" id="fb-signup-picture-img" src="" />
					</div>					
				</div>
				<div class="row">
					<div class="mx-auto mt-2">
						<input name="fb-signup-usepp" type="checkbox" id="fb-signup-usepp">
						<label class="form-check-label" for="fb-signup-usepp">
							{t c='socialsignup.use_profile_picture'}
						</label>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>	
			<div id="fb-signup-tabs">
				<nav>
				  <div class="nav nav-tabs" id="nav-tab" role="tablist">
					<a class="nav-item nav-link active" id="fb-signup-new-tab" data-toggle="tab" href="#fb-signup-new" role="tab" aria-controls="fb-signup-new" aria-selected="true">{t c='socialsignup.new_user'}</a>
					<a class="nav-item nav-link" id="fb-signup-existinfb-tab" data-toggle="tab" href="#fb-signup-existing" role="tab" aria-controls="fb-signup-existing" aria-selected="false">{t c='socialsignup.returning_user'}</a>
				  </div>
				</nav>
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="fb-signup-new" role="tabpanel" aria-labelledby="fb-signup-new-tab">
						<div class="form-group mt-2">
							<span>{t c='socialsignup.link_account_new' u='facebook' v=$site_name}</span>
						</div>		
						<div class="form-group">
							<label class="control-label">{t c='global.email'}:</label>							
							<div>
								<span id="fb-signup-email-label"></span>
							</div>
						</div>						
						<div class="form-group">
							<label for="fb-signup-username" class="control-label">{t c='global.username'}:</label>
							<input name="fb-signup-username" type="text" value="" id="fb-signup-username" class="form-control" />
							<div class="m-t-5">
								<span id="fb-signup-username-check"></span>
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
					<div class="tab-pane fade" id="fb-signup-existing" role="tabpanel" aria-labelledby="fb-signup-existinfb-tab">
						<div class="form-group mt-2">
							<span>{t c='socialsignup.link_account_existing_details' u='facebook' v=$site_name}</span>
						</div>		
						<div class="form-group">
							<label for="fb-signup-existinfb-username" class="control-label">{t c='global.username'}:</label>
							<input name="fb-signup-existinfb-username" type="text" value="" id="fb-signup-existinfb-username" class="form-control" />
						</div>
						<div class="form-group">
							<label for="fb-signup-existinfb-password" class="control-label">{t c='global.password'}:</label>
							<input name="fb-signup-existinfb-password" type="password" value="" id="fb-signup-existinfb-password" class="form-control" />
						</div>
						<div class="form-group">
							<a href="{$relative}/lost" rel="nofollow">{t c='global.forgot'}</a>
						</div>			  
					</div>
				</div>
			</div>
			<div id="fb-signup-single">
				<div class="form-group mt-2">
					<span>{t c='socialsignup.link_account_existing_password' u='facebook' v=$site_name}</span>
				</div>		
				<div class="form-group">
					<label for="fb-signup-existinfb-username-locked" class="control-label">{t c='global.username'}:</label>
					<input name="fb-signup-existinfb-username-locked" type="text" value="" id="fb-signup-existinfb-username-locked" class="form-control" readonly/>
				</div>
				<div class="form-group">
					<label for="fb-signup-existinfb-password-locked" class="control-label">{t c='global.password'}:</label>
					<input name="fb-signup-existinfb-password-locked" type="password" value="" id="fb-signup-existinfb-password-locked" class="form-control" />
				</div>
				<div class="form-group">
					<a href="{$relative}/lost" rel="nofollow">{t c='global.forgot'}</a>
				</div>				
			</div>
        </div>
        <div class="modal-footer">
			<button name="fb-signup-submit-new" id="fb-signup-submit-new" type="submit" class="btn btn-primary btn-bold">{t c='socialsignup.create_account'}</button>
			<button name="fb-signup-submit-existing" id="fb-signup-submit-existing" type="submit" class="btn btn-primary btn-bold">{t c='socialsignup.link_account'}</button>		  
        </div>
		</form>			
      </div>
    </div>
</div>
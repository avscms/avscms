<script type="text/javascript">
	signup_section = true;
</script>
<div class="container mt-3 mb-3">
	<div class="well-filters">
		<h1>{t c='lost.title'}</h1>
	</div>
	<div class="row">
		<div class="col-lg-12 col-xl-8 mt-5 d-flex justify-content-center">		
			<form class="form-horizontal" name="login_form" id="login_form" method="post" action="{$relative}/login">	
				{if $fb_signin == '1'}
					<div class="form-group">
						<button id="facebook-signin-s" class="btn btn-facebook" disabled><div></div><i class="fab fa-facebook-f"></i> <span>{t c='socialsignup.login_with'} Facebook</span></button>
					</div>
				{/if}
				{if $g_signin == '1'}						
					<div class="form-group">
						<button id="google-signin-s" class="btn btn-google" disabled><div></div><i class="fab fa-google-plus-g"></i> <span>{t c='socialsignup.login_with'} Google</span></button>
					</div>				
				{/if}
				<div class="form-group {if $errors}has-error{/if}">
					<label for="login_username">{t c='global.username'}</label>
					<input type="text" name="username" value="{$signup.username}" id="login_username" class="form-control" placeholder="{t c='global.username'}">
				</div>
				<div class="form-group {if $errors}has-error{/if}">
					<label for="login_password">{t c='global.password'}</label>
					<input name="password" type="password" id="login_password" class="form-control" placeholder="{t c='global.password'}">
					<div class="form-check mt-1">
						<input name="login_remember"type="checkbox" class="form-check-input" id="login_remember">
						<label class="form-check-label" for="login_remember">{t c='global.remember'}</label>
					</div>					
				</div>								
				<div class="form-group mt-3">
					<button type="submit" name="submit_login" class="btn btn-primary">{t c='global.login'}</button>						
				</div>
				<small id="submit_signupHelp_3" class="form-text text-muted text-x2">{t c='login.signup_help'}</small>
				<div>
					<a href="{$relative}/lost" id="lost_password">{t c='global.forgot'}</a><br />
					<a href="{$relative}/confirm" id="confirmation_email">{t c='global.confirm'}</a>					
				</div>
			</form>
		</div>
				
		<div class="col-lg-12 col-xl-4 mt-5 d-flex justify-content-center what-is">
			<div class="col-12">
				<h5>{t c='global.what_is' s=$site_name}</h5>				
				{include file='static/whatis.tpl'}				
			</div>
		</div>

	</div>
</div>
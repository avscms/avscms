<script type="text/javascript" src="{$relative_tpl}/js/jquery.signup.js"></script>
<script type="text/javascript">
	signup_section = true;
</script>
{if $captcha == '1'}
	<script src='https://www.google.com/recaptcha/api.js?hl={$captcha_language}'></script>		
{/if}
<div class="container mt-3">
	<div class="well-filters">
		<h1>{t c='signup.title' s=$site_name}</h1>
	</div>
	<div class="row">
		<div class="col-lg-12 col-xl-8 mt-5 d-flex justify-content-center">
			<form class="form-horizontal" name="signup_form" id="signup_form" method="post" action="{$relative}/signup">
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
				<div class="form-group {if $err.email}has-error{/if}">
					<label for="signup_email">{t c='global.email'}</label>
					<input type="email" name="email"  value="{$signup.email}" class="form-control" id="signup_email" aria-describedby="emailHelp" placeholder="{t c='global.email'}" autocomplete="off">
					<small id="emailHelp" class="form-text text-muted">{t c='signup.email_help'}</small>
				</div>				
				<div class="form-group {if $err.username}has-error{/if}">
					<label for="signup_username">{t c='global.username'}</label>
					<input type="text" name="username" value="{$signup.username}" id="signup_username" class="form-control" aria-describedby="usernameHelp" placeholder="{t c='global.username'}" autocomplete="off">
					<small id="usernameHelp" class="form-text text-muted">{t c='signup.username_help'}</small>
				</div>
				<div class="form-group {if $err.password}has-error{/if}">
					<label for="signup_password">{t c='global.password'}</label>
					<input type="password" name="password" id="signup_password" class="form-control" placeholder="{t c='global.password'}" aria-describedby="passwordHelp" autocomplete="new-password">
					<small id="passwordHelp" class="form-text text-muted">&nbsp;</small>
				</div>
				<div class="form-group {if $err.password_confirm}has-error{/if}">
					<label for="signup_password_confirm">{t c='global.password_confirm'}</label>
					<input type="password" name="password_confirm" id="signup_password_confirm" class="form-control" placeholder="{t c='global.password_confirm'}" aria-describedby="retypePasswordHelp" autocomplete="retype-new-password">
					<small id="retypePasswordHelp" class="form-text text-muted">&nbsp;</small>					
				</div>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="radio" name="gender" id="signup_gender_male" value="Male" {if $signup.gender != 'Female'} checked="checked"{/if}>
				  <label class="form-check-label" for="inlineRadio1">{t c='global.male'}</label>
				</div>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="radio" name="gender" id="signup_gender_female" value="Female" {if $signup.gender == 'Female'} checked="checked"{/if}>
				  <label class="form-check-label" for="inlineRadio2">{t c='global.female'}</label>
				</div>				
				<small id="submit_signupHelp_1" class="form-text text-muted text-x2">{t c='signup.certify'}</small>		
				<small id="submit_signupHelp_2" class="form-text text-muted text-x2">{t c='signup.terms' u=$baseurl v=$baseurl}</small>	
				{if $captcha == '1'}
					<div class="form-group mt-3">
						<div class="g-recaptcha" data-sitekey="{$recaptcha_site_key}"></div>
					</div>
				{/if}				
				<div class="form-group mt-3">
					<button type="submit" name="submit_signup" class="btn btn-primary">{t c='global.sign_up'}</button>						
				</div>
				<small id="submit_signupHelp_3" class="form-text text-muted text-x2 mb-3">{t c='signup.login_help'}</small>					
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
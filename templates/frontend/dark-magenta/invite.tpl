<script type="text/javascript">
    {literal}
        $(document).ready(function(){
            $("#captcha_reload").click(function(event){
                event.preventDefault();
                $("#captcha_image").attr('src', "{/literal}{$relative}{literal}/captcha" + '/' + Math.random());
            });
        });
    {/literal}  
</script>
{if $captcha == '1'}
	<script src='https://www.google.com/recaptcha/api.js?hl={$captcha_language}'></script>		
{/if}
<div class="container mt-3">
	<div class="well-filters">
		<h1>{t c='invite.title'}</h1>
	</div>
	<div class="row">
		<div class="col-lg-12 col-xl-8 mt-5 d-flex justify-content-center">		
				<form class="form-horizontal" name="inviteFriendsForm" id="inviteFriendsForm" method="post" action="{$relative}/invite">
				  <fieldset>
					<legend>{t c='invite.expl'}</legend>

						
						<div class="form-group {if $err.emails}has-error{/if}">
							<label for="friend_1">{t c='global.friend'} {t c='global.one'}</label>
							<div>
								<input name="friend_1" type="text" class="form-control" value="{$emails[0]}" id="friend_1" placeholder="{t c='global.email'}" />
							</div>
						</div>

						<div class="form-group">
							<label for="friend_2">{t c='global.friend'} {t c='global.two'}</label>
							<div>
								<input name="friend_2" type="text" class="form-control" value="{$emails[1]}" id="friend_2" placeholder="{t c='global.email'}" />
							</div>
						</div>

						<div class="form-group">
							<label for="friend_3">{t c='global.friend'} {t c='global.three'}</label>
							<div>
								<input name="friend_3" type="text" class="form-control" value="{$emails[2]}" id="friend_3" placeholder="{t c='global.email'}" />
							</div>
						</div>

						<div class="form-group">
							<label for="friend_4">{t c='global.friend'} {t c='global.four'}</label>
							<div>
								<input name="friend_4" type="text" class="form-control" value="{$emails[3]}" id="friend_4" placeholder="{t c='global.email'}" />
							</div>
						</div>

						<div class="form-group">
							<label for="friend_5">{t c='global.friend'} {t c='global.five'}</label>
							<div>
								<input name="friend_5" type="text" class="form-control" value="{$emails[4]}" id="friend_5" placeholder="{t c='global.email'}" />
							</div>
						</div>						

						<div class="form-group {if $err.name}has-error{/if}">
							<label for="invite_name">{t c='global.name'}</label>
							<div>
								<input name="name" type="text" class="form-control" value="{$invite.name}" id="invite_name" placeholder="{t c='global.name'}" />
							</div>
						</div>	

						<div class="form-group {if $err.message}has-error{/if}">
							<label for="invite_friends_message">{t c='global.message'}</label>
							<div>
								<textarea name="message" class="form-control" id="invite_friends_message" rows="4" placeholder="{t c='global.message'}" >{$invite.message}</textarea>
							</div>
						</div>						

						{if $captcha == '1'}
							<div class="form-group">
								<label></label>
								<div>
									<div class="g-recaptcha" data-sitekey="{$recaptcha_site_key}"></div>
								</div>
							</div>
						{/if}						
						
						<div class="form-group">
							<div>
								<button name="submit_invite" type="submit" class="btn btn-primary">{t c='invite.send'}</button>
							</div>
						</div>
						
				  </fieldset>
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
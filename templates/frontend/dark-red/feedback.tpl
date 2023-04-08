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
		<h1>{t c='feedback.title'}</h1>
	</div>
	<div class="row">
		<div class="col-lg-12 col-xl-8 mt-5 d-flex justify-content-center">		
			<form class="form-horizontal" name="contactUsForm" id="contactUsForm" method="post" action="{$relative}/feedback">
			  <fieldset>
				<legend>{t c='feedback.title'}</legend>
				
					<div class="form-group {if $err.department}has-error{/if}">
						<label for="contact_option">{t c='feedback.department'}</label>
						<div>
							<select name="department" id="contact_option" class="form-control">
								<option value="General"{if $feedback.department == 'General'} selected="selected"{/if}>{t c='feedback.general'}</option>
								<option value="Violations"{if $feedback.department == 'Violations'} selected="selected"{/if}>{t c='feedback.violations'}</option>
								<option value="Advertising"{if $feedback.department == 'Advertising'} selected="selected"{/if}>{t c='feedback.advertising'}</option>
							</select>
						</div>
					</div>

					<div class="form-group {if $err.email}has-error{/if}">
						<label for="contact_email">{t c='global.email'}</label>
						<div>
							<input name="email" type="text" class="form-control" value="{$feedback.email}" maxlength="100" id="contact_email" placeholder="{t c='global.email'}" />
						</div>
					</div>

					<div class="form-group {if $err.name}has-error{/if}">
						<label for="contact_name">{t c='global.name'}</label>
						<div>
							<input name="name" type="text" class="form-control" value="{$feedback.name}" maxlength="100" id="contact_name" placeholder="{t c='global.name'}" />
						</div>
					</div>

					<div class="form-group {if $err.message}has-error{/if}">
						<label for="contact_message">{t c='global.message'}</label>
						<div>
							<textarea class="form-control" name="message" id="contact_message" rows="5" placeholder="{t c='global.message'}" >{$feedback.message}</textarea>
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
							<button name="submit_feedback" type="submit" class="btn btn-primary">{t c='global.send'}</button>
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
<script type="text/javascript">
	signup_section = true;
</script>
<div class="container mt-3">
	<div class="well-filters">
		<h1>{t c='confirm.expl'}</h1>
	</div>
	<div class="row">
		<div class="col-lg-12 col-xl-8 mt-5 d-flex justify-content-center">		
			<form class="form-horizontal" name="lost_password_form" id="lost_password_form" method="post" action="{$relative}/lost">
			  <fieldset>
				<div class="form-group {if $errors}has-error{/if}">
					<label for="lost_email">{t c='global.email'}</label>
					<div>
						 <input name="email" type="text" class="form-control" value="" id="lost_email" placeholder="{t c='global.email'}" />
					</div>
				</div>
				<div class="form-group">
					<div>
						<input name="submit_lost" type="submit" value=" {t c='lost.send'} " id="lost_submit" class="btn btn-primary">
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
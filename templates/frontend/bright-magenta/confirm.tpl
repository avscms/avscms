<div class="container mt-3">
	<div class="well-filters">
		<h1>{t c='confirm.title'}</h1>
	</div>
	<div class="row">
		<div class="col-lg-12 col-xl-8 mt-5 d-flex justify-content-center">		
			<form class="form-horizontal" name="confirmEmailForm" id="confirmEmailForm" method="post" action="{$relative}/confirm">
				<div class="form-group">
					<label for="confirm_email">{t c='confirm.expl'}</label>
					<input type="email" name="email" value="" id="confirm_email" class="form-control" placeholder="{t c='global.username'}" autocomplete="off">
				</div>							
				<div class="form-group mt-3">
					<button type="submit" name="submit_confirm" id="confirm_submit" class="btn btn-primary">{t c='confirm.send'}</button>						
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
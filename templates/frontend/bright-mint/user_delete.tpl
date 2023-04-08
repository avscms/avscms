<div class="container mt-3">
	<fieldset>
		<legend>{t c='user.DELETE_TITLE'}</legend>
		<form class="form-horizontal" name="deleteAccount" id="deleteAccount" method="post" action="{$relative}/user/delete">
			<h5 class="text-danger">{t c='user.delete_expl'}</h5>
			<div class="form-group">
				<label for="delete">{t c='user.delete_ask'}</label>
				<div class="mt-3">
					<input name="delete_yes" type="submit" value="{t c='global.yes'}" class="btn btn-primary" id="delete" />
					<input name="delete_no" type="submit" value="{t c='global.back_to_profile'}" class="btn btn-secondary" id="delete_no" />						
				</div>
			</div>
			<div class="form-group">
				<div>
					<div class="checkbox">
						<label>
							<input name="confirm_delete" type="checkbox" id="confirm_delete" /> {t c='user.delete_confirm'}
						</label>
					</div>								
				</div>
			</div>
		</form>
	</fieldset>
</div>
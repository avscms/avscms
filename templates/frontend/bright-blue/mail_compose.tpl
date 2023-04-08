<div class="container mt-4 mb-4">
	<div class="mail-left">
		{include file='mail_menu.tpl'}		
	</div>
	<div class="mail-right">
		<div class="col-12 mail">
			<h1>
				{t c='mail.compose_title'}
			</h1>
			<div class="mail-body">
				<form class="form-horizontal" name="compose_message_form" id="compose_message_form" method="post" action="{$relative}/mail/compose">
					
					<div class="form-group {if $err.receiver}has-error{/if}">
						<label for="receiver">{t c='global.To'}</label>
						<div>
							<input name="receiver" type="text" class="form-control pull-left" value="{$compose.receiver}" maxlength="30" id="receiver" placeholder="{t c='mail.select_expl' s=$site_name}" />
							<select  class="form-control mt-2" name="receiver_friend">
								<option value="">{t c='mail.select_friend'}</option>
								{section name=i loop=$friends}
								<option value="{$friends[i].username}"{if $friends[i].username == $compose.friend} selected="yes"{/if}>{$friends[i].username|escape:'html'}</option>
								{/section}
							</select>								
						</div>
					</div>
					
					<div class="form-group {if $err.subject}has-error{/if}">
						<label for="subject">{t c='global.subject'}</label>
						<div>
							<input name="subject" type="text" class="form-control" value="{$compose.subject}" id="subject" maxlength="99" placeholder="{t c='global.subject'}" />
						</div>
					</div>

					<div class="form-group {if $err.body}has-error{/if}">
						<label for="body">{t c='global.message'}</label>
						<div>
							<textarea name="body" id="body" class="form-control" rows="8" placeholder="{t c='global.message'}">{$compose.body}</textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div>
							<div class="checkbox">
								<label>
									<input name="save_outbox" type="checkbox" id="save_outbox"{if $compose.save_outbox == '1'} checked="checked"{/if} /> {t c='mail.save_outbox'}
								</label>
							</div>								
						</div>
						<div>
							<div class="checkbox">
								<label>
									<input name="send_self" type="checkbox" id="send_self"{if $compose.send_self == '1'} checked="checked"{/if} /> {t c='mail.send_myself'}
								</label>
							</div>								
						</div>						
					</div>						

					<div class="form-group">
						<div>
							<input name="send_mail" type="submit" value=" {t c='mail.send'} " id="send" class="btn btn-primary" />
						</div>
					</div>						

				</form>	
			</div>				
		</div>	
	</div>
</div>
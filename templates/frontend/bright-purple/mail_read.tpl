<div class="container mt-4 mb-4">
	<div class="mail-left">
		{include file='mail_menu.tpl'}		
	</div>
	<div class="mail-right">
		<div class="col-12 mail-container">
			<h1>
				<span class="title-truncate">{t c='mail.reading'}: <span class="text-white">{$mail.subject|truncate:100:'...':true|escape:'html'}</span></span>
			</h1>
			<div>
				{t c="global.from"}: <a href="{$relative}/user/{$mail.sender}">{$mail.sender}</a><br>
			</div>			
			<div>
				{t c="global.subject"}: <span class="text-white">{$mail.subject}</span>			
			</div>	
			<div class="mail-body">
				{$mail.body|nl2br}	
			</div>		
			<div class="mt-3">
				<a href="{$relative}/mail/compose/{$mail.sender}?s=Re: {$mail.subject|escape:urlpathinfo|escape:'html'}" class="btn btn-primary" >{t c='global.reply'}</a>
				<a href="{$relative}/mail/{$folder}?delete={$mail.mail_id}" class="btn btn-secondary m-l-5" >{t c='global.delete'}</a>			
			</div>
		</div>	
	</div>
</div>
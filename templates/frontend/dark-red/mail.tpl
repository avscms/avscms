<div class="container mt-4 mb-4">

		<div class="mail-left">
			{include file='mail_menu.tpl'}		
		</div>
		<div class="mail-right">
		
			<div class="mail">
				<h1>
					{$folder|ucfirst}
				</h1>
				<div class="mail-body">
					{if $mails}
						<div class="well-info mb-3">
							{t c='global.showing'} <span class="text-white">{$start_num}</span> {t c='global.to'} <span class="text-white">{$end_num}</span> {t c='global.of'} <span class="text-white">{$total_mails}</span> {t c='global.messages'}.
						</div>
						<div class=" d-none d-sm-block">
							<table class="table table-striped table-dark">
								<thead>
									<tr>
										<th>{t c='global.status'}</th>
										<th>{t c='global.sender'}</th>                                        
										<th>{t c='global.subject'}</th>
										<th>{t c='global.date'}</th>
										<th>{t c='global.delete'}</th>
									</tr>
								</thead>
								<tbody>
								{section name=i loop=$mails}
								<tr>
									<td class="{if $mails[i].readed == '1'}mail-read{else}mail-unread{/if}"><i class="{if $mails[i].readed == '1'}far fa-envelope-open{elseif $folder == 'outbox'}far fa-envelope{else}fas fa-envelope{/if}"></i></td>
									<td class="user">
										<a href="{$relative}/user/{$mails[i].sender}">
											<span>
												<img src="{$relative}/media/users/{if $mails[i].photo == ''}nopic-{$mails[i].gender}.gif{else}{$mails[i].photo}{/if}" alt="{$mails[i].sender}" class="small-avatar" />
											</span>
											<span>{$mails[i].sender|truncate:15:'...':true|escape:'html'}</span>
										</a>
									</td>
									<td class="{if $mails[i].readed == '1'}subject-read{else}subject-unread{/if} v-middle">
										<a href="{$relative}/mail/read?id={$mails[i].mail_id}&f={$folder}"><span>{$mails[i].subject|truncate:25:'...':true|escape:'html'}</span>
									</td>
									<td>{$mails[i].send_date|date_format:"%B %e, %Y"}</td>
									<td>
										<a href="{$relative}/mail/{$folder}?delete={$mails[i].mail_id}"><i class="fas fa-trash"></i></a>
									</td>
								</tr>
								{/section}
								</tbody>
							</table>
						</div>
						<div class="d-block d-sm-none">
							<table class="table table-striped table-dark">
								<thead>
									<tr>
										<th>{t c='global.sender'}</th>                                        
										<th>{t c='global.subject'}</th>
										<th>{t c='global.delete'}</th>
									</tr>
								</thead>
								<tbody>
								{section name=i loop=$mails}
								<tr>
									<td class="user">
										<a href="{$relative}/user/{$mails[i].sender}">
											<span>
												<img src="{$relative}/media/users/{if $mails[i].photo == ''}nopic-{$mails[i].gender}.gif{else}{$mails[i].photo}{/if}" alt="{$mails[i].sender}" class="small-avatar" />
											</span>
											<span>{$mails[i].sender|truncate:10:'...':true|escape:'html'}</span>
										</a>
									</td>
									<td class="{if $mails[i].readed == '1'}subject-read{else}subject-unread{/if} v-middle">
										<a href="{$relative}/mail/read?id={$mails[i].mail_id}&f={$folder}"><span>{$mails[i].subject|truncate:10:'...':true|escape:'html'}</span></a>
									</td>
									<td>
										<a href="{$relative}/mail/{$folder}?delete={$mails[i].mail_id}"><i class="fas fa-trash"></i></a>
									</td>
								</tr>
								{/section}
								</tbody>
							</table>						
						</div>
						
						
					{else}
						<span class="text-danger">{t c='mail.none'}.</span>
					{/if}
				</div>				
			</div>	
		</div>

</div>
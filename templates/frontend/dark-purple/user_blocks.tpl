<script type="text/javascript">
var lang_block_user = "{t c='user.block'}";
var lang_unblock_user = "{t c='user.unblock'}";
</script>
<div class="container mt-3">
	<fieldset class="m-b-15">
		<legend>{t c='user.BLOCK_TITLE'}</legend>
			{if $blocks}
				<table class="table table-striped table-dark">
					<thead>
						<tr>
							<th>
								{t c='global.username'}
							</th>
							<th>
								{t c='global.action'}
							</th>                                        
						</tr>
					</thead>
					<tbody>
					{section name=i loop=$blocks}
					<tr>
						<td class="v-middle">
							{$blocks[i].username}
						</td>
						<td class="v-middle user">
							<div id="unblock_{$blocks[i].UID}"><a href="#unblock" id="unblock_username_{$blocks[i].UID}">{t c='user.unblock'}</a></div>
						</td>

					</tr>
					{/section}
					</tbody>
				</table>
			{else}
				<span class="text-danger">{t c='user.block_none'}</span>
			{/if}
	</fieldset>
</div>
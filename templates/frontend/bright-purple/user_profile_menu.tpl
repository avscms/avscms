<script type="text/javascript">
var lang_blocking = "{t c='global.blocking'}";
var lang_unblocking = "{t c='global.unblocking'}";
var lang_block = "{t c='user.block'}";
var lang_unblock = "{t c='user.unblock'}";
</script>
<script type="text/javascript" src="{$relative_tpl}/js/jquery.profile.js"></script>
<div class="container mt-3 profile-menu">
	<div class="d-none d-md-block">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-link {if $profile_menu == 'edit'}active{/if}"><a href="{$relative}/user/edit">{t c='user.personal'}</a></li>
			<li class="nav-link {if $profile_menu == 'prefs'}active{/if}"><a href="{$relative}/user/prefs">{t c='user.prefs'}</a></li>
			<li class="nav-link {if $profile_menu == 'avatar'}active{/if}"><a href="{$relative}/user/avatar">{t c='user.avatar'}</a></li>
			<li class="nav-link {if $profile_menu == 'blocks'}active{/if}"><a href="{$relative}/user/blocks">{t c='user.block_list'}</a></li>
			<li class="nav-link {if $profile_menu == 'delete'}active{/if}"><a href="{$relative}/user/delete">{t c='user.delete_profile'}</a></li>
			<li class="nav-link ml-auto"> <a href="{$relative}/user/{$username}">{t c='global.back_to_profile'}</a></li>		
		</ul>
	</div>
	<div class="d-sm-block d-md-none">
		<div class="well-filters">
			<div class="btn-group m-l-14">
				<a class="well-action dropdown-toggle" data-toggle="dropdown">{if $profile_menu == 'edit'}{t c='user.personal'}{elseif $profile_menu == 'prefs'}{t c='user.prefs'}{elseif $profile_menu == 'avatar'}{t c='user.avatar'}{elseif $profile_menu == 'blocks'}{t c='user.block_list'}{else}{t c='user.delete_profile'}{/if} <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li {if $profile_menu == 'edit'} class="active"{/if}><a href="{$relative}/user/edit">{t c='user.personal'}</a></li>
					<li {if $profile_menu == 'prefs'} class="active"{/if}><a href="{$relative}/user/prefs">{t c='user.prefs'}</a></li>
					<li {if $profile_menu == 'avatar'} class="active"{/if}><a href="{$relative}/user/avatar">{t c='user.avatar'}</a></li>
					<li {if $profile_menu == 'blocks'} class="active"{/if}><a href="{$relative}/user/blocks">{t c='user.block_list'}</a></li>
					<li {if $profile_menu == 'delete'} class="active"{/if}><a href="{$relative}/user/delete">{t c='user.delete_profile'}</a></li>
					<li class="divider"></li>
					<li> <a href="{$relative}/user/{$username}">{t c='global.back_to_profile'}</a></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>

	{if $profile_menu == 'delete'}
		<div class="mt-2 mb-2 text-white">
			{t c='user.delete_sub'}
		</div>
	{elseif $profile_menu == 'blocks'}
		<div class="mt-2 mb-2 text-white">
			{t c='user.block_sub'}
		</div>
	{elseif $profile_menu == 'avatar'}
		<div class="mt-2 mb-2 text-white">
			{t c='user.avatar_sub'}
		</div>
	{elseif $profile_menu == 'prefs'}
		<div class="mt-2 mb-2 text-white">
			{t c='user.prefs_sub'}
		</div>
	{else}
		<div class="mt-2 mb-2 text-white">
			{t c='user.profile_sub'}
		</div>
	{/if}

</div>
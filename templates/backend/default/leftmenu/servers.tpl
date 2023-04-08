			<li class="{if $active_menu == 'servers'}open{/if}">
				<a href="javascript:;">
					<i class="fa fa-hdd-o"></i>
					<span class="title">Servers</span>
					<span class="arrow {if $active_menu == 'servers'}open{/if}"></span>					
				</a>
				<ul class="sub-menu" {if $active_menu == 'servers'}style="overflow: hidden; display: block;"{/if}>
					<li class="{if $active_menu == 'servers' && $module == 'all'}active{/if}"><a href="servers.php?m=all&all=1">Manage Servers</a></li>
					<li class="{if $active_menu == 'servers' && $module == 'add'}active{/if}"><a href="servers.php?m=add">Add Server</a></li>
				</ul>
			</li>	
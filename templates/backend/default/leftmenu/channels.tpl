			<li class="{if $active_menu == 'channels'}open{/if}">
				<a href="javascript:;">
					<i class="fa fa-th"></i>
					<span class="title">Categories</span>
					<span class="arrow {if $active_menu == 'channels'}open{/if}"></span>					
				</a>
				<ul class="sub-menu" {if $active_menu == 'channels'}style="overflow: hidden; display: block;"{/if}>
					<li class="{if $module == 'list'}active{/if}"><a href="channels.php?m=list&all=1">Video Categories</a></li>
					<li class="{if $module == 'listalbum'}active{/if}"><a href="channels.php?m=listalbum&all=1">Album Categories</a></li>								
				</ul>
			</li>
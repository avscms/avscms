			<li class="{if $active_menu == 'notices'}open{/if}">
				<a href="javascript:;">
					<i class="fa fa-pencil-square-o"></i>
					<span class="title">Notices</span>
					<span class="arrow {if $active_menu == 'notices'}open{/if}"></span>					
				</a>
				<ul class="sub-menu" {if $active_menu == 'notices'}style="overflow: hidden; display: block;"{/if}>
					<li class="{if $module == 'list'}active{/if}"><a href="notices.php?m=list&all=1">Notices</a></li>
					<li class="{if $module == 'list_images'}active{/if}"><a href="notices.php?m=list_images">Notice Images</a></li>
					<li class="{if $module == 'list_categories'}active{/if}"><a href="notices.php?m=list_categories&all=1">Notice Categories</a></li>
					<li class="{if $active_menu == 'notices' && $module == 'add'}active{/if}"><a href="notices.php?m=add">Add Notice</a></li>
				</ul>
			</li>